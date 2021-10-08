<?php
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		  <link rel="stylesheet" type="text/css" href="/css/index.css">
		<title>Nouveau fournisseur</title>
	</head>
	<body>
		<div id="top">
			<a href="https://suppliers.bdrthermea-france.fr/admin/admin.php" title="BDR THERMEA France"><img src="/css/BDR-THERMEA-FRANCE.png" /></a>
    </div>
		<div id="container">
			<br><br>
			<form action="adduser.php" method="post">
				<h1>Création d'un nouveau fournisseur</h1>
				<label for="login">Identifiant</label> <br>
				<input type="text" id="login" name="login" required autofocus><br>
				<label for="email">Email</label><br>
				<input type="text" id="email"  name="email"  required><br>
				<label for="entreprise">Entreprise</label><br>
				<input type="text" id="entreprise"  name="entreprise"  required><br>
				<input type="submit" value="Créer">
				<p>
				<a href="admin.php">Retour à la page admin</a> - <a href="../signout.php">Se déconnecter </a>
				</p>
				<?php if ( !empty($_SESSION['message_signup']) ) { ?>
				<section id="message">
					<p><?= $_SESSION['message_signup'] ?></p>
				</section>
				<?php } ?>
			</form>
		</div>
	</body>
</html>
