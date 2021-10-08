<?php
	session_start();
	if ( empty($_SESSION['user']) )
	{
		header('Location: ../index.php');
		exit();
	}
	unset($_SESSION['message_signup']);
	unset($_SESSION['message_changerAcceuil']);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="/css/index.css">
		<title>Page Admin</title>
	</head>
	<body>
		<div id="top">
<a href="https://suppliers.bdrthermea-france.fr/admin/admin.php" title="BDR THERMEA France"><img src="/css/BDR-THERMEA-FRANCE.png" /></a>
		</div>
		<div id="container">
			<br><br>
			<form>
				<h1>Bonjour et bienvenue sur la page d'administration.</h1>
				<input type="button"  value="Créer un nouveau fournisseur" onclick="signup()">
				<input type="button"  value="Accèder à la page d'un fournisseur" onclick="accesF()">
				<input class="inactif" type="button" name="" value="Modifier la page d'acceuil" onclick="changerAcceuil()">
				<input type="button" value="Changer de mot de passe" onclick="changemdpadmin()">
				<input type="button" value="Télécharger périodes de congés" onclick="dlconges()">
				<p><a href="../signout.php">Se déconnecter</a></p>
			</form>
			<script>
				function signup(){
					let url = "signup.php";
      		window.location.href = url;
				}

				function changerAcceuil(){
					/*
					let url = "changerAcceuil.php";
      		window.location.href = url;*/
				}

				function accesF(){
					let url = "accesFournisseur.php";
					window.location.href = url;
				}

				function changemdpadmin(){
					let url = "../compte/changemdp.php";
					window.location.href = url;
				}

				function dlconges(){
					let url = "dlconges.php"
					window.location.href = url;
				}
				</script>
		</div>
	</body>
</html>
