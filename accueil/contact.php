<?php
	session_start();
	require('../lang.php');
	unset($_SESSION['message_index']);
?>

<!DOCTYPE html>
<html dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/css/index.css">
    <title><?php echo TXT_CONTACTEZ_NOUS; ?></title>
  </head>
  <body>
    <div id="top">
      <a href="https://suppliers.bdrthermea-france.fr/index.php" title="BDR THERMEA France"><img src="/css/BDR-THERMEA-FRANCE.png" /></a>
    </div>
		<div id="container">
			<br><br>
          <form action="sendContact.php" method="post">
						<h1><?php echo TXT_CONTACTEZ_NOUS; ?></h1>
            <label for="nom"><?php echo TXT_NOM; ?></label><br>
						<input type="text" name="nom" id="nom" required autofocus><br>
            <label for="société"><?php echo TXT_SOC; ?></label><br>
						<input type="text" name="société" id="société" required><br>
            <label for="email"><?php echo TXT_EMAIL; ?></label><br>
					 	<input type="text" name="email" id="email" required><br>
						<h2><?php echo TXT_VOTRE_MSG; ?></h2>
						<label for="objet"><?php echo TXT_OBJET; ?></label><br>
						<input type="text" name="objet" id="objet" required><br>
						<label for="msg"><?php echo TXT_MSG; ?></label><br>
						<textarea name="msg" id="msg" cols="165" rows="15" placeholder="<?php echo TXT_ENTRER_MSG ?>" required></textarea><br>
            <input type="submit" value=<?php echo TXT_BTN_SEND; ?>>
						<?php if ( isset($_SESSION['message_contact']) && !empty($_SESSION["message_contact"]) ){ ?>
						<section id="message">
							<p><?= $_SESSION["message_contact"]?></p>
						</section>
						<?php } ?>
						<p>
              <a href="../index.php"> <?php echo TXT_RETOUR_INDEX; ?> </a>
            </p>
        </form>
				<br><br>
    </div>
  </body>
</html>
