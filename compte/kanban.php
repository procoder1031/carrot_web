<?php
	session_start();
	require('../lang.php');
	if ( empty($_SESSION['user']) )
	{
		header('Location: ../index.php');
		exit();
	}

	unset($_SESSION['message_changemdp']);
	unset($_SESSION['message_conges']);

//Fonction de formatage de la taille
function filesize_formatted($file){
    $size = $file->getSize();
    $units = array( 'o', 'Ko', 'Mo', 'Go', 'To', 'Po', 'Eo', 'Zo', 'Yo');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    return number_format($size / pow(1024, $power), 2, ',', '.') . ' ' . $units[$power];
}

$compteur = 0;

//Fonction récupérant le nom de l'icon en fonction de l'extention
function getIcon($file){

  $icons = array(
                'xls' => 'excel',
                'xlsx' => 'excel',
                'csv' => 'excel',
                'doc' => 'word',
                'ppt' => 'powerpoint',
                'pps' => 'powerpoint',
                'jpg' => 'image',
                'png' => 'image',
                'gif' => 'image',
                'bmp' => 'image',
                'pdf' => 'pdf',
                'txt' => 'txt',
                'zip' => 'zip',);

  $ext = $file->getExtension();
  return $icons[$ext];
}
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
			 <a href="account.php"><?php echo TXT_ACCUEIL; ?></a>
			 <a href="livraisons.php"><?php echo TXT_LIVRAISON; ?></a>
			 <a href="otif.php"><?php echo TXT_OTIF; ?></a>
			 <a class="active" href="kanban.php"><?php echo TXT_KANBAN ?></a>
			 <a href="rating.php"><?php echo TXT_RATING ?></a>
			 <a href="conges.php"><?php echo TXT_CONGES ?></a>
		</div>
		<div id="content">
			<h2><?php echo TXT_PAGE_KANBAN; ?></h2>
			<p><?php echo TXT_MSG_KANBAN; ?></p>
			<table class="files" summary="Fichiers à télécharger">
				<thead>
					<tr>
						<th width="60%" scope="col" class="file"><?php echo TXT_FILE; ?></th>
						<th width="10%" scope="col" class="type"><?php echo TXT_TYPE; ?></th>
						<th width="10%" scope="col" class="size"><?php echo TXT_SIZE; ?></th>
						<th width="20%" scope="col" class="date"><?php echo TXT_DATE; ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
          foreach (new DirectoryIterator("../repertoires_fournisseurs/" . $_SESSION['user'] . "/KANBAN") as $fileInfo) {
              if($fileInfo->isDot()) continue;
							$compteur ++; ?>
              <tr>
                <td class="file"><a href=" <?php echo $fileInfo->getPath();echo "/";echo $fileInfo->getFilename() ?>"target="_blank"><?php echo $fileInfo->getFilename()?></a></td>
								<td class="type"><img src="/css/icons/32x32/<?php echo getIcon($fileInfo)?>.png"></td>
                <td class="size"><?php echo filesize_formatted($fileInfo) ?></td>
                <td class="date"><?php echo date("d/m/Y H:i:s", $fileInfo->getCTime()); ?></td>
              </tr>
            <?php } ?>
          </tbody>
          </table>
					<?php
						if ($compteur===0){
							echo "<br><font color='#FF0000'>" . TXT_PAS_DE_FICHIER . "</font>";
						}
					?>
		</div>
	</body>
	</html>
