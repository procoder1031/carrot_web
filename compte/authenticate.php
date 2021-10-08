<?php
/******************************************************************************
 * Initialisation.
 */

session_start();
require('../lang.php');
unset($_SESSION['message_index']);

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
if ( empty($_POST['login']) || empty($_POST['password']) )
{
	$_SESSION['message_index'] = TXT_POST_MANQUANT;
	header('Location: ../index.php');
	exit();
}

// 3. On sécurise les données reçues
$login = strtolower(htmlspecialchars($_POST['login']));
$password = htmlspecialchars($_POST['password']);

/******************************************************************************
 * Initialisation de l'accès à la BDD
 */

try {
	$pdo = new PDO('mysql:host=localhost;dbname=suppliers;charset=utf8', 'root', '');
}
catch( PDOException $e ) {
	$_SESSION['message_index'] = TXT_ERREUR_BBD.$e->getMessage();
	header('Location: ../index.php');
	exit();
}


/******************************************************************************
 * Authentification
 */

// 1. On prépare la requête
$request = $pdo->prepare( "SELECT hashpassword, changeMdp, name  FROM users WHERE login = :login" );

// 2. On assigne les paramètres nommés
$ok = $request->bindValue( ":login", $login, PDO::PARAM_STR );
// 3. On exécute la requête
$ok &= $request->execute();
// 4. On vérifie que la requête s'est executée sans erreur
if ( !$ok )
{
	$_SESSION['message_index'] = TXT_ERREUR_DEFINE;
	header('Location: ../index.php');
	exit();
}

// 5. On récupère la 1ère ligne du résultat de la requête
$user = $request->fetch();

// 6. On vérifie que l'utilisateur a été trouvé
if ( !$user )
{
	$_SESSION['message_index'] = TXT_ERREUR_ID;
	header('Location: ../index.php');
	exit();
}

// 7. On vérifie que le mot de passe de la BBD correspond
// au mot de passe transmis en POST
if ( !password_verify($password,$user['hashpassword']) )
{
	$_SESSION['message_index'] = TXT_ERREUR_MDP;
	header('Location: ../index.php');
	exit();
}

$_SESSION['name'] = $user['name'];

// 8. On sauvegarde le login dans la session
$_SESSION['user'] = $login;

// 9. On récupère le bool de vérification de changement du mdp
$_SESSION['changemdp'] = $user['changeMdp'];

// 10. On sollicite une redirection vers la page du compte ou de modification du mot de passe
if ($_SESSION['changemdp'] === "1"){
	header('Location: changemdp.php');
}
else if ($_SESSION['user'] === "admin"){
  header('Location: ../admin/admin.php');
}
else if (in_array($_SESSION['user'],$_SESSION['interns'])){
	header('Location: ../admin/accesFournisseur.php');
}
else {
	header('Location: account.php');
}
// 11. On écrit dans les logs qu'une connexion à eu lieu
$logfile = fopen("../log/log_connexion.txt","a");
$newline = "[ ".date('j-m-y, h:i:s')." ] Connexion avec l'identifiant : ".$login."\r\n";
fputs($logfile,$newline);
fclose($logfile);

exit();
