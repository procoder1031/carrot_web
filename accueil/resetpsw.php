<?php
/******************************************************************************
 * Initialisation.
 */
	session_start();
	$ok = true;
	// 1. On récupère la lang  et le login en GET
  $_SESSION['lang'] = $_GET['lang'];
  $lang='../lang/lang_'.$_SESSION['lang'].'.php';
  require($lang);
  $_SESSION['user'] = $_GET['login'];
	$_SESSION['code'] = $_GET['code'];
  // 1. On vérifie que la méthode HTTP utilisée est bien POST
  if ( $_SERVER['REQUEST_METHOD'] != 'GET' )
  {
  	header('Location: ../index.php');
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

	// 1. On vérifie que l'invitation n'a pas expiré
	$verifheure = $bdd->prepare("SELECT heure FROM users WHERE login = :login");

	$ok &= $verifheure->execute(array(
		'login'=> $_SESSION['user']
	));

	if(!$ok){
		$_SESSION['message_forgot'] = "Erreur execute";
		header('Location: forgotpsw.php');
		exit();
	}

	$user = $verifheure->fetch();

	$time = $user['heure'];

	$limite = date("Y-m-d H:i:s", mktime(date("H")-1,date("i"),date("s"),date("m"),date("d"),date("Y")));

	if($limite > $time ){

		$_SESSION['message_forgot'] = TXT_LIEN_INACTIF;
	 header('Location: forgotpsw.php');
	 exit();
 }

	// 2. On vérifie que le code correspond bien au code dans la BDD
	$verifcode = $bdd->prepare("SELECT code FROM users WHERE login = :login");

	$ok &= $verifcode->execute(array(
		'login'=> $_SESSION['user']
	));

	if(!$ok){
	  $_SESSION['message_forgot'] = TXT_ERREUR_DEFINE;
	  header('Location: forgotpsw.php');
	  exit();
	}

	$user = $verifcode->fetch();

	$hash = $user['code'];

	if (md5($_GET['code']) !== $hash) {
		$_SESSION['message_forgot'] = TXT_ERREUR_RESET;
	  header('Location: forgotpsw.php');
	  exit();
	}
?>

<!DOCTYPE html>
<html dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/css/index.css">
    <title><?php echo TXT_RESET; ?></title>
  </head>
  <body>
    <div id="top">
      <a href="https://suppliers.bdrthermea-france.fr/index.php" target="_blank" title="BDR THERMEA France"><img src="/css/BDR-THERMEA-FRANCE.png" /></a>
    </div>
		<div id="container">
			<br><br>
          <form action="newpsw.php" method="post">
						<h1><?php echo TXT_RESET; ?></h1>
            <label for="newpassword"><?php echo TXT_NEW_MDP; ?><br>
						</label> <input type="password" name="newpassword" id="newpassword" required><br>
            <label for="confirm"><?php echo TXT_CONF_MDP; ?><br>
						</label> <input type="password" name="confirm" id="confirm" required><br>
            <input type="submit" value="Ok">
            <p>
              <a href="../index.php"> <?php echo TXT_RETOUR_INDEX; ?> </a>
            </p>
            <?php if ( isset($_SESSION['message_reset']) && !empty($_SESSION["message_reset"]) ){ ?>
            <section id="message">
              <p><?= $_SESSION["message_reset"]?></p>
            </section>
            <?php } ?>
        </form>
    </div>
  </body>
</html>
