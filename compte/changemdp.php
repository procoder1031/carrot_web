<?php
	session_start();
	require('../lang.php');
	if ( empty($_SESSION['user']) && empty($_SESSION['changemdp'])  )
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
		<title><?php echo TXT_TITRE_COMPTE ?></title>
	</head>
	<body>
		<div id="top">
			<?php
			if ($_SESSION['changemdp'] === "1") {
				echo "<a href=\"https://suppliers.bdrthermea-france.fr/index.php\" title=\"BDR THERMEA France\"><img src=\"/css/BDR-THERMEA-FRANCE.png\" /></a>";
			}
			else if($_SESSION['user'] === 'admin'){
				echo "<a href=\"https://suppliers.bdrthermea-france.fr/admin/admin.php\" title=\"BDR THERMEA France\"><img src=\"/css/BDR-THERMEA-FRANCE.png\" /></a>";
			}
			else if(in_array($_SESSION['user'],$_SESSION['interns'])){
				echo "<a href=\"https://suppliers.bdrthermea-france.fr/admin/accesFournisseur.php\" title=\"BDR THERMEA France\"><img src=\"/css/BDR-THERMEA-FRANCE.png\" /></a>";
			}
			else{
				echo "<a href=\"https://suppliers.bdrthermea-france.fr/compte/account.php\" title=\"BDR THERMEA France\"><img src=\"/css/BDR-THERMEA-FRANCE.png\" /></a>";
			} ?>
		</div>
    <div id="container">
			<br><br>
			<form action="changementmdp.php" method="post">
				<h1><?php echo TXT_CHANGE_MDP ?></h1>
        <label for="password"><?php echo TXT_VIEUX_MDP ?></label><br>
				<input type="password" id="password" name="password" required autofocus><br>
        <label for="newpassword"><?php echo TXT_NEW_MDP ?></label><br>
				<input type="password" id="newpassword" name="newpassword" required><br>
        <label for="confirm"><?php echo TXT_CONF_MDP ?></label><br>
				<input type="password" id="confirm"  name="confirm"  required><br>
        <input type="submit" value=<?php echo TXT_CHANGE_MDP ?>>
        <p>
          <?php
					if ($_SESSION['changemdp'] === "1") {
						echo '<a href="../signout.php">'. TXT_RETOUR_INDEX. '</a>';
          }
					else if($_SESSION['user']=== 'admin'){
						echo '<a href="../admin/admin.php">Retour à la page admin</a> - <a href="../signout.php">Se déconnecter</a>';
					}
					else if(in_array($_SESSION['user'],$_SESSION['interns'])){
						echo '<a href="../admin/accesFournisseur.php">Retour à la page d\'accès au fournisseurs</a> - <a href="../signout.php">Se déconnecter</a>';
					}
					else{
						echo '<a href="account.php">'.TXT_RETOUR_COMPTE.'</a> - <a href="../signout.php">' . TXT_DECO . '</a>';
					} ?>
        </p>
        <?php if ( !empty($_SESSION['message_changemdp']) ) { ?>
        <section id="message">
          <p><?= $_SESSION['message_changemdp'] ?></p>
        </section>
        <?php } ?>
      </form>
    </div>
  </body>
</html>
