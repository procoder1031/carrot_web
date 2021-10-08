<?php
/******************************************************************************
 * Initialisation.
 */
session_start();
require('../lang.php');
unset($_SESSION['message_reset']);
unset($_SESSION['message_forgot']);
$ok = true;

/******************************************************************************
 * Traitement des données de la requête
 */

// 1. On vérifie que la méthode HTTP utilisée est bien POST
if ( $_SERVER['REQUEST_METHOD'] != 'POST' )
{
	header('Location: resetpsw.php?login='.$login.'&lang='.$_SESSION['lang'].'&code='.$code);
	exit();
}

// 2. On sécurise les données reçues
$newpassword = htmlspecialchars($_POST['newpassword']);
$confirm = htmlspecialchars($_POST['confirm']);
$login = $_SESSION['user'];
$code = $_SESSION['code'];

// 3. On vérifie que les données attendues existent
if (empty($_POST['newpassword'])|| empty($_POST['confirm']))
{
	$_SESSION['message_reset'] = TXT_POST_MANQUANT;
	header('Location: resetpsw.php?login='.$login.'&lang='.$_SESSION['lang'].'&code='.$code);
	exit();
}


/******************************************************************************
 * Initialisation de l'accès à la BDD
 */

try {
	$bdd = new PDO('mysql:host=localhost;dbname=suppliers;charset=utf8', 'root', '');
}
catch( PDOException $e ) {
	$_SESSION['message_reset'] = TXT_ERREUR_BBD.$e->getMessage();
	header('Location: resetpsw.php?login='.$login.'&lang='.$_SESSION['lang'].'&code='.$code);
	exit();
}


/******************************************************************************
 * Vérifications
 */

// 1. On vérifie que les nouveaux mots de passe correspondent

if($newpassword !== $confirm){
  $_SESSION['message_reset'] = TXT_MDP_DIF;
	header('Location: resetpsw.php?login='.$login.'&lang='.$_SESSION['lang'].'&code='.$code);
	exit();
}

// 2. On vérifie que le mot de passe contient les caractères requis
$uppercase = preg_match('@[A-Z]@', $newpassword);
$lowercase = preg_match('@[a-z]@', $newpassword);
$number    = preg_match('@[0-9]@', $newpassword);
$symbol 	 = preg_match('@[~!#$%^&*()_=+[{};:,.<>?|\]\/\-\@]@', $newpassword);
$longueur  = strlen($newpassword);

if ($uppercase == 1 && $lowercase == 1 && $number == 1 && $symbol == 1 && $longueur>7)
{
	$monmess = "oui";

}
else
{
	$monmess = "non";	
}

if ($monmess == "non")

{
$_SESSION['message_reset'] = TXT_PAS_NORME."PASS ".$newpassword." ".$uppercase." ".$lowercase." ".$number." ".$symbol." ".$longueur." ".$monmess;
header('Location: resetpsw.php?login='.$login.'&lang='.$_SESSION['lang'].'&code='.$code);
exit();
}


//if (!$uppercase || !$lowercase || !$number || !$symbol || $longueur>7)

//{
//$_SESSION['message_reset'] = TXT_PAS_NORME."PASS ".$newpassword." ".$uppercase." ".$lowercase." ".$number." ".$symbol." ".$longueur." ".$monmess;
//header('Location: resetpsw.php?login='.$login.'&lang='.$_SESSION['lang'].'&code='.$code);
//exit();
//}


unset($_SESSION['message_reset']);
// 8. On crypte le nouveau mot de passe
$newpassword = password_hash($newpassword, PASSWORD_DEFAULT);

/******************************************************************************
 * Modification
 */

 // 1. On prépare la requête
 $req = $bdd->prepare('UPDATE users SET hashpassword = :mdp, code = NULL WHERE login = :log');

 // 2. On execute la requête avec les paramètres entrés
 $ok &= $req->execute(array(
   'mdp' => $newpassword,
   'log' => $login
   ));

 // 3. On vérifie que la requête s'est executée sans erreur et on redirige
 if ( !$ok )
 {
 	$_SESSION['message_forgot'] = TXT_ERREUR_DEFINE;
	header('Location: forgotpsw.php');
 	exit();
 }
 else {
   $_SESSION['message_forgot'] = TXT_MDP_MODIF;
	 header('Location: forgotpsw.php');
  	exit();
 }
 ?>
