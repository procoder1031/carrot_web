<?php
$content_fr = $_POST["content_fr"];
$content_en = $_POST["content_en"];

$total = count($_FILES['files']['name']);

$bdd = new PDO('mysql:host=localhost;dbname=suppliers;charset=utf8', 'root', '');

$fileArray = array();

$statement = $bdd->prepare('INSERT INTO homepage_files (`filename`, `filetype`, `fileicon`) VALUES (:filename, :filetype, :fileicon)');
for ($i = 0;$i < $total;$i ++) {
    $tmpFilePath = $_FILES['files']['tmp_name'][$i];
    if ($tmpFilePath != "") {
        $filename = $_FILES['files']['name'][$i];
        $path_parts = pathinfo($filename);
        $extension = strtolower($path_parts['extension']);
        $newFilePath = "../fichiers_communs/uploads/".$filename;

        $fileicon = 'empty';
        if ($extension == 'pdf' || $extension == 'ps' || $extension == 'eps') {
            $fileicon = 'pdf';
        }
        else if ($extension == 'xlsx' || $extension == 'xlsm' || $extension == 'xlsb' || $extension == 'xltx' || $extension == 'xltm' || $extension == 'xls' || $extension == 'xlt'
            || $extension == 'xml' || $extension == 'xlam' || $extension == 'xla' || $extension == 'xlw' || $extension == 'xlr') {
            $fileicon = 'excel';
        }
        else if ($extension == 'tif' || $extension == 'tiff' || $extension == 'bmp' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'gif' || $extension == 'png'
            || $extension == 'eps' || $extension == 'raw' || $extension == 'cr2' || $extension == 'nef' || $extension == 'orf' || $extension == 'sr2') {
            $fileicon = 'image';
        }
        else if ($extension == 'bat' || $extension == 'bin' || $extension == 'cmd' || $extension == 'com' || $extension == 'cpl' || $extension == 'exe' || $extension == 'gadget'
            || $extension == 'inf1' || $extension == 'ins' || $extension == 'inx' || $extension == 'isu' || $extension == 'job') {
            $fileicon = 'exec_wine';
        }
        else if ($extension == 'txt') {
            $fileicon = 'document';
        }
        else if ($extension == 'html' || $extension == 'html') {
            $fileicon = 'html';
        }
        else if ($extension == 'zip' || $extension == 'rar') {
            $fileicon = 'tar';
        }

        if (move_uploaded_file($tmpFilePath, $newFilePath)) {
            $statement->execute([
                ':filename' => $filename,
                ':filetype' => $extension,
                ':fileicon' => $fileicon
            ]);
        }
    }
}

$result = $bdd->query('SELECT COUNT(*) as totalCount FROM homepage');
$row = $result->fetch();
if ($row['totalCount'] == 0) {
    $statement = $bdd->prepare('INSERT INTO homepage (`content_fr`, `content_en`) VALUES (:content_fr, :content_en)');
    $statement->execute([
        ':content_fr' => $content_fr,
        ':content_en' => $content_en
    ]);
}
else {
    $statement = $bdd->prepare('UPDATE homepage SET content_fr=:content_fr, content_en=:content_en');
    $statement->bindParam(':content_fr', $content_fr);
    $statement->bindParam(':content_en', $content_en);
    $statement->execute();
}


header('Location: ./changerAcceuil.php');
exit();
?>