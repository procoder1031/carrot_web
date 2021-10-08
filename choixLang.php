<?php
//On vérifie si lang est en GET
if(isset($_GET['lang']) ) {
    //Si oui, on créer une variable $lang avec pour valeur celle de la valeur en GET.
    $_SESSION['lang'] = $_GET['lang'];
}
else {
  //On vérifie si lang est déjà définie
  if ( isset($_SESSION['lang'])) {
      $_SESSION['lang'] =  $_SESSION['lang'];
  }
  else {
    // si lang n'existe pas on utilise la valeur par défaut : fr
      $_SESSION['lang'] = 'fr';
  }
}
require('lang.php');
?>
