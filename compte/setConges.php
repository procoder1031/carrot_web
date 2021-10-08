<?php
/******************************************************************************
 * Initialisation.
 */
session_start();
require('../lang.php');
unset($_SESSION['message_conges']);

 /******************************************************************************
  * Traitement des données de la requête
  */

 // 1. On vérifie que la méthode HTTP utilisée est bien POST
 if ( $_SERVER['REQUEST_METHOD'] != 'POST' )
 {
 	header('Location: conges.php');
 	exit();
 }

 // 2. On sécurise les données reçues
 $start = $_POST['start'];
 $end = $_POST['end'];
 $login = $_SESSION['user'];

 /******************************************************************************
  * Initialisation de l'accès à la BDD
  */

 try {
 	$bdd = new PDO('mysql:host=localhost;dbname=suppliers;charset=utf8', 'root', '');
 }
 catch( PDOException $e ) {
 	$_SESSION['message_reset'] = TXT_ERREUR_BBD.$e->getMessage();
 	header('Location: conges.php');
 	exit();
 }

 $request = $bdd->prepare('INSERT INTO conges (login, debut, fin) VALUES (:login,:debut,:fin)');
 $ok = true;
 $ok &= $request->execute(array(
   'login'=>$login,
   'debut'=>$start,
   'fin'=>$end
 ));

if ( !$ok )
{
 $_SESSION['message_conges'] = TXT_ERREUR_AJOUT;
 header('Location: conges.php');
 exit();
}
else
{
  $_SESSION['message_conges'] = TXT_AJOUT;
  header('Location: conges.php');
  exit();
}
?>
