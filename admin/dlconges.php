<?php
session_start();
if ( empty($_SESSION['user']) )
{
  header('Location: ../index.php');
  exit();
}

function format_date($date){
  $annee = substr($date,0,4);
  $mois = substr($date,-5,2);
  $jour = substr($date,-2);
  $newdate = $jour . "-" . $mois . "-" . $annee;
  return $newdate;
}

function forcerTelechargement($nom, $situation)
    {
    header('Content-Type: text/plain\n');
    header('Content-disposition: attachment; filename='. $nom);
    header('Pragma: no-cache');
    header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    header('Expires: 0');
    readfile($situation);
    exit();
    }

try {
  $bdd = new PDO('mysql:host=localhost;dbname=suppliers;charset=utf8', 'root', '');
}
catch( PDOException $e ) {
  $_SESSION['message_forgot'] = TXT_ERREUR_BBD.$e->getMessage();
  header('Location: conges.php');
  exit();
}

$request = $bdd->prepare( "SELECT * FROM conges" );

$request->execute();



/*
Téléchargement du fichier au format .txt

unlink("../log/log_conges.txt");
$logfile = fopen("../log/log_conges.txt","a");
$firstline = "Login    Dernière livraison   Première livraison \r\n";
fputs($logfile,$firstline);
while($conges = $request->fetch())
{
  $newline = $conges['login'] . "   " . format_date($conges['debut']) . "           " . format_date($conges['fin']) . "\r\n";
  fputs($logfile,$newline);
}
fclose($logfile);
forcerTelechargement("conges.txt","../log/log_conges.txt");
*/


//Téléchargement du fichier au format .csv
unlink("../log/log_conges.csv");
$logfile = fopen("../log/log_conges.csv","a");
$firstline = array('Login',utf8_decode('Dernière livraison'),utf8_decode('Première livraison'));
fputcsv($logfile,$firstline,';');
while($conges = $request->fetch())
{
  $newline = array($conges['login'],format_date($conges['debut']),format_date($conges['fin']));
  fputcsv($logfile,$newline,';');
}
fclose($logfile);

forcerTelechargement("conges.csv","../log/log_conges.csv");
?>
