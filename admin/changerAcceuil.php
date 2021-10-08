<?php
	session_start();
	if ( empty($_SESSION['user']) )
	{
		header('Location: ../index.php');
		exit();
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="/css/index.css">
		<title>Modification de l'acceuil</title>
	</head>
	<body>
		<div id="top">
<a href="https://suppliers.bdrthermea-france.fr/admin/admin.php" title="BDR THERMEA France"><img src="/css/BDR-THERMEA-FRANCE.png" /></a>
		</div>
		<div id="container">
			<br><br>
      <form action=".php" method="post">
				<h1>Modifiez le message de la page d'acceuil et ajoutez y des fichiers</h1>
        <label for="msg_acceuil">Message d'acceuil</label> <br>
				 <textarea name="msg" id="msg" cols="165" rows="15" required><?php echo "Ceci est le message actuel (à recup via bdd)" ?></textarea><br>
        <label for="files">Fichiers</label><br>
        <input type="file" name="files" id="files" multiple><br>
        <input type="submit" value="Ok">
        <p>
          <a href="admin.php">Retour à la page admin</a> - <a href="../signout.php">Se déconnecter </a>
        </p>
        <?php if ( isset($_SESSION['message_changerAcceuil']) && !empty($_SESSION["message_changerAcceuil"]) ){ ?>
        <section id="message">
          <p><?= $_SESSION["message_changerAcceuil"]?></p>
        </section>
        <?php } ?>
      </form>
    </div>
	</body>
</html>
