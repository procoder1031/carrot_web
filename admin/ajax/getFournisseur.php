<?php
$retData = array();
$draw = $_GET["draw"];
$searchArray = $_GET["search"];
$searchKey = $searchArray["value"];
$pagination = $_GET["length"];
$start = $_GET["start"];

$bdd = new PDO('mysql:host=localhost;dbname=suppliers;charset=utf8', 'root', '');
$result = $bdd->query('SELECT COUNT(*) as totalCount FROM users');
$row = $result->fetch();
$retData["recordsTotal"] = $row['totalCount'];

$resultFilter = $bdd->query('SELECT COUNT(*) as totalCount FROM users WHERE `login` LIKE "'. $searchKey .'%"');
$rowFilter = $resultFilter->fetch();
$retData["recordsFiltered"] = $rowFilter['totalCount'];

$reponse = $bdd->query('SELECT * FROM users WHERE `login` LIKE "'. $searchKey .'%" LIMIT '. $pagination . ' OFFSET '. $start);

$data = array();
$len = 0;
while ($donnees = $reponse->fetch()) {
    $login = $donnees['login'];
    $link = 'account.php?fournisseur=' . $login;
    $data[$len][0] = '<a style="text-decoration: underline;" href="'. $link .'">'. $login .'</a>';
    $data[$len][1] = $donnees['email'];
    $len ++;
}
$retData["draw"] = $draw;
$retData["data"] = $data;

echo json_encode($retData);
?>