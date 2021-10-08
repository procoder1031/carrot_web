<?php
session_start();
require('../lang.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="/css/both.css">
		<title><?php echo TXT_TITRE_COMPTE ?></title>
	</head>
	<body>
		<div id="top">
			<?php
			if($_SESSION['user'] === "admin"){
				echo '<a href="https://suppliers.bdrthermea-france.fr/admin/admin.php" title="BDR THERMEA France"><img src="/css/BDR-THERMEA-FRANCE.png" /></a>';
			}
			else{
				echo '<a href="https://suppliers.bdrthermea-france.fr/admin/accesFournisseur.php" title="BDR THERMEA France"><img src="/css/BDR-THERMEA-FRANCE.png" /></a>';
			}
			 ?>
		</div>
		<div id="infos">
			<p>
				<?php
				if($_SESSION['user'] === "admin"){
					echo TXT_UTILISATEUR; echo $_SESSION['user']; echo " - ";?> <a href="admin.php"><?php echo "Retour à la page admin"; ?></a> - <a href="../signout.php"><?php echo TXT_DECO; ?></a>
					<?php
				}
				else{
					echo TXT_UTILISATEUR; echo $_SESSION['user']; echo " - ";?> <a href="../compte/changemdp.php"><?php echo TXT_CHANGE_MDP; ?></a> - <a href="../signout.php"><?php echo TXT_DECO; ?></a>
				<?php } ?>
			</p>
		</div>
		<div id="content">
			<h2><?php echo "Liste des fournisseurs"; ?></h2>
			<p><?php echo "Cliquez sur un numéro de fournisseur pour accèder à ses contenus"; ?></p>
			<table class="files" summary="Fichiers à télécharger">
				<thead>
					<tr>
						<th width="40%" scope="col" class="file">Fournisseur</th>
						<th width="60%" scope="col" class="type">Email</th>
					</tr>
				</thead>
				<tbody>
				<?php

				/******************************************************************************
				 * Initialisation de l'accès à la BDD
				 */

				try {
					$bdd = new PDO('mysql:host=localhost;dbname=suppliers;charset=utf8', 'root', '');
				}
				catch( PDOException $e ) {
					$_SESSION['message_admin'] = TXT_ERREUR_BBD.$e->getMessage();
					header('Location: admin.php');
					exit();
				}

				/******************************************************************************
				 * Affichage des fournisseurs
				 */

					// On récupère tout le contenu de la table users
					$reponse = $bdd->query('SELECT * FROM users');

					// On affiche chaque entrée une à une
					while ($donnees = $reponse->fetch())
					{
						$login = $donnees['login'];
						$link = 'account.php?fournisseur=' . $login;
					?>
					<tr>
						<td class="fournisseur"> <a href=" <?php echo $link ?>" target=_blank><?php echo $login;?></a></td>
						<td class="email"><?php echo $donnees['email']; ?></td>
					</tr>
					<?php
					}

					$reponse->closeCursor();
					?>
					</tbody>
					</table>
		</div>
	</body>
	</html>
