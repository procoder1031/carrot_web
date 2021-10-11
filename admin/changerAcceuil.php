<?php
	session_start();
	if ( empty($_SESSION['user']) )
	{
		header('Location: ../index.php');
		exit();
	}
	
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
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="/css/index.css">
		<link rel="stylesheet" type="text/css" href="/css/editor/editor.css">
		<script src="/css/editor/editor.js"></script>
		<title>Modification de l'acceuil</title>
	</head>
	<body>
		<div id="top">
<a href="https://suppliers.bdrthermea-france.fr/admin/admin.php" title="BDR THERMEA France"><img src="/css/BDR-THERMEA-FRANCE.png" /></a>
		</div>
		<div id="container">
			<br><br>
      <form id="submitForm" action="./uploadHomepage.php" method="post" enctype="multipart/form-data">
				<h1>Modifiez le message de la page d'acceuil et ajoutez y des fichiers</h1>
        <label for="msg_acceuil">Message d'acceuil (FR)</label> <br>
		<div id="msg_fr_body" style="text-align: left;"><textarea name="msg_fr" id="msg_fr"></textarea></div>
        <label style="margin-top: 10px;" for="msg_acceuil">Message d'acceuil (EN)</label> <br>
		<div id="msg_en_body" style="text-align: left;"><textarea name="msg_en" id="msg_en"></textarea></div>
        <label style="margin-top: 10px;" for="files">Fichiers</label><br>
		<div class="row">
			<div class="col-md-6">
	        	<input type="file" name="files[]" id="files" style="display: inline-block; width: 100%;" multiple><br>
			</div>
			<div class="col-md-6" style="text-align: left;">
				Fichers
				<table class="table table-responsive">
					<tbody>
						<?php
						while ($file = $result->fetch()) {
						?>
						<tr>
							<td><img src="/css/icons/32x32/<?= $file['fileicon'] ?>.png"></td>
							<td><a target="_blank" href="/fichiers_communs/uploads/<?= $file['filename'] ?>"><?= $file['filename'] ?></a></td>
							<td><i data-id="<?= $file['id'] ?>" data-name="<?= $file['filename'] ?>" class="fa fa-trash deleteFile" style="color: red; font-size: 20px; cursor: pointer;"></i></td>
						</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
        <input type="button" id="submit_btn" value="Ok">
		<input type="hidden" name="content_fr" id="content_fr" >
		<input type="hidden" name="content_en" id="content_en" >
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
	<script>
		$(document).ready(function() {
			$("#msg_fr").Editor();
			$("#msg_en").Editor();
			$('#msg_fr_body .Editor-editor').html(`<?= $content_fr ?>`);
			$('#msg_en_body .Editor-editor').html(`<?= $content_en ?>`);
		});

		$('#submit_btn').click(function() {
			var content_sub_fr = $('#msg_fr_body .Editor-editor > pre').html();
			if (content_sub_fr) {
				$('#msg_fr_body .fa-code').click();
			}
			var content_fr = $('#msg_fr_body .Editor-editor').html();
			$('#content_fr').val(content_fr);
			var content_sub_en = $('#msg_en_body .Editor-editor > pre').html();
			if (content_sub_en) {
				$('#msg_en_body .fa-code').click();
			}
			var content_en = $('#msg_en_body .Editor-editor').html();
			$('#content_en').val(content_en);
			$('#submitForm').submit();
		});

		$('.deleteFile').click(function() {
			var data_id = $(this).attr('data-id');
			var name = $(this).attr('data-name');
			var parent = $(this).parent().parent();
			$.ajax({
				url: "./ajax/deleteHomepageFile.php", //the page containing php script
				type: "post", //request type,
				async: false,

				data: {
					id: data_id,
					name: name
				},
				success: function(result) {
					var jsonData = JSON.parse(result);
					if (jsonData['status'] == 'success') {
						parent.remove();
					}
				}
			});
		});
	</script>
</html>
