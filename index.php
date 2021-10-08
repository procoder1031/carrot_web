<?php
  session_start();
  include('choixLang.php');
  unset($_SESSION['message_forgot']);
  unset($_SESSION['message_contact']);
  //Liste des utilisateurs internes
  $_SESSION['interns'] = array("test", "319199");
?>
<!DOCTYPE html>
<html dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <title><?php echo TXT_TITRE_INDEX; ?></title>
  </head>
  <body>
    <div id="top">
      <a href="https://suppliers.bdrthermea-france.fr/" title="BDR THERMEA France"><img src="/css/BDR-THERMEA-FRANCE.png" /></a>
    </div>
    <div id="container">
      <br><br>
          <form action="/compte/authenticate.php" method="post">
            <h1><?php echo TXT_BIENVENUE_INDEX; ?></h1>
            <h2><?php echo TXT_INFO_INDEX; ?></h2>
            <label for="login"><?php echo TXT_LOG; ?> <br> </label> <input type="text" name="login" id="login" required autofocus>
            <br>
            <label for="password"><?php echo TXT_MDP; ?> <br> </label> <input type="password" name="password" id="password" required>
            <input type="submit" value=<?php echo TXT_TITRE_INDEX; ?>>
            <?php if ( isset($_SESSION['message_index']) && !empty($_SESSION["message_index"]) ){ ?>
              <section id="message">
                <p><?= $_SESSION["message_index"]?></p>
              </section>
            <?php } ?>
            <p><?php echo TXT_INFO_EMAIL; ?></p>
            <p>
              <a href="../accueil/forgotpsw.php"> <?php echo TXT_MDP_OUBLIE; ?> </a> - <a href="../accueil/contact.php"> <?php echo TXT_CONTACT; ?></a>
            </p>
            <?php
            if($_SESSION['lang']==="fr") { ?>
              <div id="fr">
                <a href="index.php?lang=fr" target="_self"><span class="lang"> FR</span></a> - <a href="index.php?lang=en" target="_self">EN</a>
              </div>
            <?php }
            else { ?>
              <div id="en">
                <a href="index.php?lang=fr" target="_self">FR</a> - <a href="index.php?lang=en" target="_self"><span class="lang"> EN</span></a>
              </div>
            <?php } ?>
          </form>
    </div>
  </body>
</html>
