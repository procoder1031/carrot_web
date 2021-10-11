<?php
	session_start();
	require('../lang.php');
	if ( empty($_SESSION['user']) )
	{
		header('Location: ../index.php');
		exit();
	}
	unset($_SESSION['message_changemdp']);
	unset($_SESSION['message_conges']);
	$_SESSION['vu'] = $_GET['fournisseur'];

	$bdd = new PDO('mysql:host=localhost;dbname=suppliers;charset=utf8', 'root', '');
	$result = $bdd->query('SELECT * FROM homepage');
	$row = $result->fetch();
	$content_fr = '';
	$content_en = '';
	if ($row) {
		$content_fr = $row['content_fr'];
		$content_en = $row['content_en'];
	}

	$result = $bdd->query('SELECT * FROM homepage_files');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<?php
		include_once('../include/header.php');
		?>
		<link rel="stylesheet" type="text/css" href="/css/account.css">
		<title><?php echo TXT_TITRE_COMPTE ?></title>
	</head>
	<body>
		<div id="top">
			<a href="https://suppliers.bdrthermea-france.fr/compte/account.php" title="BDR THERMEA France"><img src="/css/BDR-THERMEA-FRANCE.png" /></a>
		</div>
		<?php
		include_once('../include/topmenu.php');
		?>
		<div id="content" style="margin-top: 10px;">
			<div class="row" style="text-align: left;">
				<div class="col-md-6">
					<div class="col-md-12">
						<div class="section_box">
							<div class="section_header">
								<div><?php echo TXT_WELCOME ?> - <?= $_SESSION['user'] ?></div>
							</div>
							<div class="section_body">
								<?php
								switch($_SESSION['lang']) {
									case 'fr':
										echo $content_fr;
										break;
									case 'en':
										echo $content_en;
										break;
								}
								?>
							</div>
						</div>
					</div>
					<div class="col-md-12" style="margin-top: 20px;">
						<div class="section_box">
							<div class="section_header">
								<div><?php echo TXT_FILE ?></div>
							</div>
							<div class="section_body">
							<table class="table table-responsive" style="text-align: left; min-width: unset;">
								<tbody>
									<?php
									while ($file = $result->fetch()) {
									?>
									<tr>
										<td><img src="/css/icons/32x32/<?= $file['fileicon'] ?>.png"></td>
										<td><a target="_blank" href="/fichiers_communs/uploads/<?= $file['filename'] ?>"><?= $file['filename'] ?></a></td>
									</tr>
									<?php
									}
									?>
								</tbody>
							</table>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="col-md-12">
						<div class="section_box">
							<div class="section_header">
								<div><?php echo TXT_WELCOME ?></div>
							</div>
							<div class="section_body">
							</div>
						</div>
					</div>
					<div class="col-md-12" style="margin-top: 20px;">
						<div class="section_box">
							<div class="section_header">
								<div><?php echo TXT_WELCOME ?></div>
							</div>
							<div class="section_body">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
