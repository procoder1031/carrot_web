<?php
session_start();

try {
	$bdd = new PDO('mysql:host=localhost;dbname=suppliers;charset=utf8', 'root', '');
}
catch( PDOException $e ) {
	$_SESSION['message'] = TXT_ERREUR_BBD.$e->getMessage();
	header('Location: index.php');
	exit();
}
$compteur = 0;
$reponse = $bdd->query( 'SELECT * FROM users');

while($donnees = $reponse->fetch()){

  $log = $donnees["login"];
  $mdp =  password_hash($donnees["password"],PASSWORD_DEFAULT);

  $req = $bdd->prepare('UPDATE users SET hashpassword = :mdp WHERE login = :log');
  $req->execute(array(
  	'mdp' => $mdp,
  	'log' => $log
  	));
  $compteur++;
  }
/*
UPDATE users SET hashpassword = '' WHERE login = 'admin'
$req = $bdd->prepare('UPDATE user SET hashpassword = :mdp WHERE login = :log');
$req->execute(array(
	'mdp' => $mdp,
	'log' => $log
	));
  $bdd->exec('');
  */

echo $compteur;
$reponse->closeCursor();
 ?>
