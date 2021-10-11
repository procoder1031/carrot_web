<?php
session_start();
$data = array();
if ( empty($_SESSION['user']) ) {
    $data['status'] = 'fail';
    echo json_encode($data);
    exit;
}
$id = $_POST["id"];
$name = $_POST["name"];

$bdd = new PDO('mysql:host=localhost;dbname=suppliers;charset=utf8', 'root', '');
$statement = $bdd->prepare('DELETE FROM homepage_files WHERE id = :id');
$statement->bindParam(':id', $id, PDO::PARAM_INT);
if ($statement->execute()) {
    $data['status'] = 'success';
    if (file_exists('../../fichiers_communs/uploads/'.$name)) {
        unlink('../../fichiers_communs/uploads/'.$name);
    }
}
echo json_encode($data);
?>