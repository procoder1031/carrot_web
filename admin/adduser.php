<?php
/******************************************************************************
 * Initialisation.
 */
session_start();
unset($_SESSION['message_signup']);

/******************************************************************************
 * Traitement des données de la requête
 */

// 1. On vérifie que la méthode HTTP utilisée est bien POST
if ( $_SERVER['REQUEST_METHOD'] != 'POST' )
{
	header('Location: signup.php');
	exit();
}

// 2. On vérifie que les données attendues existent
if ( empty($_POST['login']) ||  empty($_POST["email"]) )
{
	$_SESSION['message_signup'] = "Donnée(s) POST manquante";
	header('Location: signup.php');
	exit();
}

// 3. On sécurise les données reçues
$login = htmlspecialchars($_POST['login']);
$email = $_POST['email'];
$entreprise = $_POST['entreprise'];

// 4. On créer un mode de passe provisoir

// Liste des caractères possibles
$cars="azertyiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN0123456789*$-_/";
$password='';
$long=strlen($cars);

srand((double)microtime()*1000000);
//Initialise le générateur de nombres aléatoires
for($i=0;$i<10;$i++){
	$password=$password.substr($cars,rand(0,$long-1),1);
}

// 5. On crypte le mode de passe
$passwordhash = password_hash($password,PASSWORD_DEFAULT);
/******************************************************************************
 * Initialisation de l'accès à la BDD
 */

 try {
 	$bdd = new PDO('mysql:host=localhost;dbname=suppliers;charset=utf8', 'root', '');
 }
 catch( PDOException $e ) {
 	$_SESSION['message_signup'] = TXT_ERREUR_BBD.$e->getMessage();
 	header('Location: signup.php');
 	exit();
 }

 /******************************************************************************
  * Verification de l'existance du fournisseur
  */

 // 1. On prépare la requête
 $request = $bdd->prepare( 'SELECT login FROM users');

 // 2. On exécute la requête
 $ok = true;
 $ok &= $request->execute();

 // 3. On vérifie que la requête s'est executée sans erreur
 if ( !$ok )
 {
 	$_SESSION['message_signup'] = TXT_ERREUR_DEFINE;
 	header('Location: signup.php');
 	exit();
 }

 // 4. On récupère la 1ère ligne du résultat de la requête
 while($donnees = $request->fetch()){

	 if ( $donnees['login'] === $login )
	 {
	 	$_SESSION['message_signup'] = "Ce fournisseur existe déjà";
	 	header('Location: signup.php');
	 	exit();
	 }
}
$request->closeCursor();
/******************************************************************************
 * Ajout de l'utilisateur
 */
 echo $login;
 echo $email;
 echo $entreprise;

// 1. On prépare la requête
$req = $bdd->prepare( "INSERT INTO users VALUES (:login,:mdp,:email,1,NULL,NULL,:entreprise)" );
// 2. On exécute la requête
$ok &= $req->execute(array(
	'login'=> $login,
	'mdp' => $passwordhash,
	'email' => $email,
	'entreprise' => $entreprise
	));

	echo $ok;

// 3. On vérifie que la requête s'est executée sans erreur
if ( !$ok )
{
	$_SESSION['message_signup'] = "Erreur lors de la création, veuillez réessayer.";
	header('Location: signup.php');
	exit();
}


// 4. On indique que le compte a bien été créé
$_SESSION['message_signup'] = "Nouveau fournisseur créé.";
// 5. On créé les dossiers dans le repertoire fournisseur
mkdir("../repertoires_fournisseurs/".$login);
mkdir("../repertoires_fournisseurs/".$login."/CALL_OF");
mkdir("../repertoires_fournisseurs/".$login."/KANBAN");
mkdir("../repertoires_fournisseurs/".$login."/OTIF");
mkdir("../repertoires_fournisseurs/".$login."/RATING");


//5. On envoie ses Identifiants au nouveau fournisseur

$header="MIME-Version: 1.0\r\n";
$header.='Content-Type:text/html; charset="uft-8"'."\r\n";
$header.='Content-Transfer-Encoding: 8bit\r\n';
$header.="From: no-reply@suppliers.bdrthermea-france.fr\r\n";
$header.='Bcc: christophe.buffler@bdrthermea.fr';

$message='
      <html>
         <body>
            <div align="center">
	            <br />
							Identifiant/Login : ' . $login . '
							<br />
							Mot de passe/Password : ' . $password . '
							<br />
							Lien de connexion/Connection link : https://recette.suppliers.bdrthermea-france.fr/index.php
	          	<br />
							Le changement de mot de passe est obligatoire avant la première connexion/Changing password is mandatory before first connection
							<br />
					  </div>
         </body>
      </html>
      ';
//On envoie les infos par mail
mail($email,"Identifiants/Logins BDR Thermea", utf8_decode($message), $header);

$_SESSION['message_signup'] = "Un email a été envoyé au fournisseur";

// 6. On sollicite une redirection vers la page d'accueil
header('Location: signup.php');
exit();

?>
