<?php
error_reporting(E_ALL ^ E_WARNING); 
switch($_SESSION['lang']) {
    //Si lang=fr on inclut le fichier de langue française
    case 'fr':
        include('./lang/lang_fr.php');
        include('../lang/lang_fr.php');
    break;
    //Si lang=en on inclut le fichier de langue anglaise
    case 'en':
        include('./lang/lang_en.php');
        include('../lang/lang_en.php');
    break;
}
?>
