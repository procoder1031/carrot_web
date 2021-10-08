<?php
	session_start();
	require('../lang.php');
	if ( empty($_SESSION['user']) )
	{
		header('Location: ../index.php');
		exit();
	}
	unset($_SESSION['message_changemdp']);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="/css/account.css">
		<title><?php echo TXT_TITRE_COMPTE ?></title>
	</head>
	<body>
		<div id="top">
			<a href="https://suppliers.bdrthermea-france.fr/compte/account.php" title="BDR THERMEA France"><img src="/css/BDR-THERMEA-FRANCE.png" /></a>
			<div id="infos">
				<p>
					<?php echo TXT_UTILISATEUR; echo $_SESSION['user']; echo " - ";?> <a href="changemdp.php"><?php echo TXT_CHANGE_MDP; ?></a> - <a href="../signout.php"><?php echo TXT_DECO; ?></a>
				</p>
			</div>
		</div>
		<div class="topnav">
			 <a class="active" href="account.php"><?php echo TXT_ACCUEIL; ?></a>
			 <a href="livraisons.php"><?php echo TXT_LIVRAISON; ?></a>
			 <a href="otif.php"><?php echo TXT_OTIF; ?></a>
			 <a href="kanban.php"><?php echo TXT_KANBAN ?></a>
			 <a href="rating.php"><?php echo TXT_RATING ?></a>
			 <a href="conges.php"><?php echo TXT_CONGES ?></a>
		</div>
		<div id="content">
			<h2><?php echo TXT_BIENVENUE; echo $_SESSION['name']; ?></h2>
			<p><?php	echo TXT_MSG_ACCUEIL;	?></p>
			<h2><?php echo TXT_DOCS ?></h2>
			<p>
				<a href="../fichiers_communs/annuaire_fournisseurs_dedietrich_2018.pdf" target="_blank" title="Contact" rel="nofollow"><img src="/css/icons/16x16/pdf.png"> <?php echo TXT_LIEN_LISTE_CONTACT ?> </a><br><br>
				<a href="../fichiers_communs/calendrier_usine_2021.pdf" target="_blank" title="Calendrier" rel="nofollow"><img src="/css/icons/16x16/pdf.png"> <?php echo TXT_LIEN_CALENDRIER ?> </a><br><br>
				<a href="../fichiers_communs/plan_circulation.pdf" target="_blank" title="Circulation" rel="nofollow"><img src="/css/icons/16x16/pdf.png"> <?php echo TXT_LIEN_PLAN ?> </a><br><br>
				<br><br>
				<a href="../fichiers_communs/<?php echo TXT_LIEN_GUIDE ?>" target="_blank" title="Guide" rel="nofollow"><img src="/css/icons/16x16/pdf.png"><?php echo TXT_GUIDE; ?></a>
			</p>
		</div>
	</body>
</html>
