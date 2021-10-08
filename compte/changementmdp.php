<?php
/******************************************************************************
 * Initialisation.
 */

session_start();
require('../lang.php');
unset($_SESSION['message_changemdp']);

/******************************************************************************
 * Traitement des données de la requête
 */

// 1. On vérifie que la méthode HTTP utilisée est bien POST
if ( $_SERVER['REQUEST_METHOD'] != 'POST' )
{
	header('Location: ../index.php');
	exit();
}

// 2. On vérifie que les données attendues existent
if ( empty($_POST['password']) || empty($_POST['newpassword'])|| empty($_POST['confirm']))
{
	$_SESSION['message_changemdp'] = TXT_POST_MANQUANT;
	header('Location: changemdp.php');
	exit();
}

// 3. On sécurise les données reçues
$password = htmlspecialchars($_POST['password']);
$newpassword = htmlspecialchars($_POST['newpassword']);
$confirm = htmlspecialchars($_POST['confirm']);
$login = $_SESSION['user'];

// 4. On vérifie que le mot de passe contient les caractères requis
/*
if (!preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{10,}$#', $newpassword))
{
	$_SESSION['message_changemdp'] = TXT_PAS_NORME;
	header('Location: changemdp.php');
	exit();
}*/
$uppercase = preg_match('@[A-Z]@', $newpassword);
$lowercase = preg_match('@[a-z]@', $newpassword);
$number    = preg_match('@[0-9]@', $newpassword);
$symbol 	 = preg_match('@[~!#$%^&*()_=+[{};:,.<>?|\]\/\-\@]@', $newpassword);
$longueur  = strlen($newpassword);

if (!$uppercase || !$lowercase || !$number || !$symbol || $longueur<7)
{
	$_SESSION['message_changemdp'] = TXT_PAS_NORME;
	header('Location: changemdp.php');
	exit();
}


/******************************************************************************
 * Initialisation de l'accès à la BDD
 */

try {
	$bdd = new PDO('mysql:host=localhost;dbname=suppliers;charset=utf8', 'root', '');
}
catch( PDOException $e ) {
	$_SESSION['message_changemdp'] = TXT_ERREUR_BBD.$e->getMessage();
	header('Location: changemdp.php');
	exit();
}


/******************************************************************************
 * Vérifications
 */

// 1. On prépare la requête
$request = $bdd->prepare( "SELECT hashpassword FROM users WHERE login = :login" );

// 2. On assigne les paramètres nommés
$ok = $request->bindValue( ":login", $login, PDO::PARAM_STR );

// 3. On exécute la requête
$ok &= $request->execute();

// 4. On vérifie que la requête s'est executée sans erreur
if ( !$ok )
{
	$_SESSION['message_changemdp'] = TXT_ERREUR_DEFINE;
	header('Location: changemdp.php');
	exit();
}

// 5. On récupère la 1ère ligne du résultat de la requête
$user = $request->fetch();

// 6. On vérifie que le mot de passe de la BBD correspond au mot de passe transmis en POST
if ( !password_verify($password,$user['hashpassword']) )
{
	$_SESSION['message_changemdp'] = TXT_ERREUR_MDP;
	header('Location: changemdp.php');
	exit();
}

// 7. On vérifie que les nouveaux mots de passe correspondent
if($newpassword !== $confirm){
  $_SESSION['message_changemdp'] = TXT_MDP_DIF;
	header('Location: changemdp.php');
	exit();
}

// 8. On crypte le nouveau mot de passe
$newpassword = password_hash($newpassword, PASSWORD_DEFAULT);

/******************************************************************************
 * Modification
 */

 // 1. On prépare la requête
 $req = $bdd->prepare('UPDATE users SET hashpassword = :mdp, changeMdp = 0 WHERE login = :log');

 // 2. On execute la requête avec les paramètres entrés
 $ok &= $req->execute(array(
   'mdp' => $newpassword,
   'log' => $login
   ));

 // 3. On vérifie que la requête s'est executée sans erreur
 if ( !$ok )
 {
 	$_SESSION['message_changemdp'] = TXT_ERREUR_DEFINE;
 	header('Location: changemdp.php');
 	exit();
 }
 // 4. Si oui, on modifie le mdp et on affiche le message correspondent
 else {
   $_SESSION['message_changemdp'] = TXT_MDP_MODIF;
  	header('Location: changemdp.php');
  	exit();
 }
 ?>
