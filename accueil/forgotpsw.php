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
    <title><?php echo TXT_MDP_OUBLIE; ?></title>
  </head>
  <body>
    <div id="top">
      <a href="https://suppliers.bdrthermea-france.fr/index.php" title="BDR THERMEA France"><img src="/css/BDR-THERMEA-FRANCE.png" /></a>
    </div>
		<div id="container">
			<br><br>
          <form action="sendMdp.php" method="post">
						<h1><?php echo TXT_FORGOT; ?></h1>
            <label for="email"><?php echo TXT_EMAIL; ?></label><br>
						<input type="text" name="email" id="email" required><br>
            <input type="submit" value=<?php echo TXT_BTN_SEND; ?>>
						<?php if ( isset($_SESSION['message_forgot']) && !empty($_SESSION["message_forgot"]) ){ ?>
						<section id="message">
							<p><?= $_SESSION["message_forgot"]?></p>
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
