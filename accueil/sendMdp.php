<?php
/******************************************************************************
 * Initialisation.
 */

session_start();
require('../lang.php');
unset($_SESSION['message_forgot']);
unset($_SESSION['message_reset']);

/******************************************************************************
 * Traitement des données de la requête
 */

// 1. On vérifie que la méthode HTTP utilisée est bien POST
if ( $_SERVER['REQUEST_METHOD'] != 'POST' )
{
	header('Location: forgotpsw.php');
	exit();
}


// 2. On vérifie que les données attendues existent
if ( empty($_POST['email']))
{
	$_SESSION['message_forgot'] = TXT_POST_MANQUANT;
	header('Location: forgotpsw.php');
	exit;
}

// 3 . On sécurise l'entrées et on verifie que l'email est bien valide
$email = htmlspecialchars($_POST['email']);
if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
	$_SESSION['message_forgot'] = TXT_INVALIDE_EMAIL;
	header('Location: forgotpsw.php');
	exit();
}

/******************************************************************************
 * Initialisation de l'accès à la BDD
 */

try {
	$bdd = new PDO('mysql:host=localhost;dbname=suppliers;charset=utf8', 'root', '');
}
catch( PDOException $e ) {
	$_SESSION['message_forgot'] = TXT_ERREUR_BBD.$e->getMessage();
	header('Location: forgotpsw.php');
	exit();
}

/******************************************************************************
 * Verification de l'existance de l'email
 */

// 1. On vérifie que l'adresse mail existe
$verifmail = $bdd->prepare("SELECT login FROM users WHERE email = :mail");

$verifmail->bindValue( ":mail", $email, PDO::PARAM_STR );

$verifmail->execute();


// 2. On récupère la 1ère ligne du résultat de la requête
$user = $verifmail->fetch();

if(!$user){
  $_SESSION['message_forgot'] = TXT_MAIL_INCONNU;
  header('Location: forgotpsw.php');
  exit();
}

// 3. On recupère le login
$login = $user['login'];

/******************************************************************************
 * Création d'un code de sécurisation
 */

// 1. On créé un code provisoire pour securiser le lien et une variable date
$code = rand(10000, 99999);
$hash = hash('md5',$code);


// 2. On stock le code, l'heure dans la BDD
$req = $bdd->prepare('UPDATE users SET code = :code, heure = NOW() WHERE login = :log');
$ok = true;
$ok &= $req->execute(array(
	'code'=> $hash,
	'log' => $login
	));


// 3. En cas d'erreur on redirige
if ( !$ok )
{
 $_SESSION['message_forgot'] = TXT_ERREUR_DEFINE;
 header('Location: forgotpsw.php');
 exit();
}


$lien = 'https://suppliers.bdrthermea-france.fr/accueil/resetpsw.php?lang=' . $_SESSION['lang'] . '&code=' . $code . '&login=' .$login;

$objet = TXT_OBJ_RESET;

// 4. On prépare le mail à envoyer
$click = TXT_CLICK;
$reset = TXT_MAIL_MDP;
$id = TXT_YOUR_ID;
$header="MIME-Version: 1.0\r\n";
$header.='Content-Type:text/html; charset="uft-8"'."\r\n";
$header.='Content-Transfer-Encoding: 8bit\r\n';
$header.="From: no-reply@suppliers.bdrthermea-france.fr";
$message='
      <html>
         <body>
            <div align="center">
               <br />
							 ' . $id . $login . '
							 <br />
							 ' . $reset . '<a href=' . $lien . '> ' . $click	. '</a>
               <br />
            </div>
         </body>
      </html>
      ';
			//On envoie les infos par mail
      mail($email,utf8_decode($objet), utf8_decode($message), $header);
      $_SESSION['message_forgot'] = TXT_MAIL_ENVOYE;
      header('Location: forgotpsw.php');
      exit();
?>
