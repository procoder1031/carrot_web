<?php
session_start();
require('../lang.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<?php
		include_once("../include/header.php");
		?>
		<link rel="stylesheet" type="text/css" href="/css/both.css">
		<link rel="stylesheet" type="text/css" href="/css/jquery.dataTables.min.css">
		<script src="/js/jquery.dataTables.min.js"></script>
		<title><?php echo TXT_TITRE_COMPTE ?></title>
		<style>
			td.sorting_1 {
				background-color: unset !important;
			}
		</style>
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
			<div style="max-width: 1000px; margin: auto;">
				<table id="files" class="display" style="width: 100%;">
					<thead>
						<tr>
							<th width="40%" scope="col" class="file">Fournisseur</th>
							<th width="60%" scope="col" class="type">Email</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th width="40%" scope="col" class="file">Fournisseur</th>
							<th width="60%" scope="col" class="type">Email</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</body>
	<script>
		$(document).ready(function() {
			$('#files').DataTable( {
				"processing": true,
				"serverSide": true,
				"ajax": "./ajax/getFournisseur.php"
			} );
		} );
	</script>
	</html>
