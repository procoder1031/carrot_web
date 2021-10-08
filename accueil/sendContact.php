<?php
/******************************************************************************
 * Initialisation.
 */

session_start();
require('../lang.php');

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
if ( empty($_POST['nom']) || empty($_POST['société'])|| empty($_POST['email'])|| empty($_POST['objet'])|| empty($_POST['msg']) )
{
	$_SESSION['message_contact'] = TXT_POST_MANQUANT;
	header('Location: contact.php');
	exit;
}

// 3 . On sécurise les entrées et on verifie que l'email est bien valide
$nom = htmlspecialchars($_POST['nom']);
$soc = htmlspecialchars($_POST['société']);
$email = htmlspecialchars($_POST['email']);
$obj = htmlspecialchars($_POST['objet']);
$msg = $_POST['msg'];

if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
	$_SESSION['message_contact'] = TXT_INVALIDE_EMAIL;
	header('Location: contact.php');
	exit();
}

// 4. On prépare le mail à envoyer
$header="MIME-Version: 1.0\r\n";
$header.='Content-Type:text/html; charset="uft-8"'."\r\n";
$header.='Content-Transfer-Encoding: 8bit\r\n';
$header.='From: no-reply@suppliers.bdrthermea-france.fr';

$message='
      <html>
         <body>
            <div align="center">
               <br />
               <p> Ceci est un message envoyé depuis https://suppliers.bdrthermea-france.fr/acceuil/contact.php </p>
               <u>Nom de l\'expéditeur : </u>' . $nom .'<br />
               <u>Entreprise de l\'expéditeur : </u>' . $soc.'<br />
               <u>Mail de l\'expéditeur : </u>'. $email .'<br />
               <br />
               '.nl2br($msg).'
               <br />
            </div>
         </body>
      </html>
      ';
			//On envoie les infos par mail
      mail("valerie.tetart@bdrthermea.fr", $obj, utf8_decode($message), $header);
      $_SESSION['message_contact'] = TXT_CONTACT_ENVOYE;
      header('Location: contact.php');
      exit();
?>
