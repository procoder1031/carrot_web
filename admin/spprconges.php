<?php
/******************************************************************************
 * Initialisation.
 */
session_start();
$id = $_GET['id'];
require('../lang.php');
unset($_SESSION['message_conges']);

/******************************************************************************
 * Initialisation de l'accès à la BDD
 */

try {
  $bdd = new PDO('mysql:host=localhost;dbname=suppliers;charset=utf8', 'root', '');
}
catch( PDOException $e ) {
  $_SESSION['message_conges'] = TXT_ERREUR_BBD.$e->getMessage();
  header('Location: conges.php');
  exit();
}

$request = $bdd->prepare('DELETE FROM conges WHERE id = :id');
// 2. On assigne les paramètres nommés
$ok = true;
//$ok = $request->bindValue( ":id", $id, PDO::PARAM_INT );

// 3. On exécute la requête
$ok &= $request->execute(array(
  'id'=>$id
));
// 3. On vérifie que la requête s'est executée sans erreur et on redirige
if ( !$ok )
{
 $_SESSION['message_conges'] = TXT_ERREUR_SPPR;
 header('Location: conges.php');
 exit();
}
else
{
  $_SESSION['message_conges'] = TXT_SPPR;
  header('Location: conges.php');
  exit();
}
?>
