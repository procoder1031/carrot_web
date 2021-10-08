<?php
session_start();
$a_suppr = array();
//Connexion a la base de données
try {
	$pdo = new PDO('mysql:host=localhost;dbname=suppliers;charset=utf8', 'root', '');
}
catch( PDOException $e ) {
	$_SESSION['message_index'] = TXT_ERREUR_BBD.$e->getMessage();
	echo "erreur";
	header('Location: ../index.php');
	exit();
}
//Boucle sur chaque fournisseur
$req =  'SELECT login FROM users ORDER BY login';
foreach  ($pdo->query($req) as $client) {
	$rep = "exchange/from_sap/";
	$dir = opendir($rep);
	while ($file = readdir($dir))
	{
		if(is_file($rep.$file))
		{
			//Pour chaque fichier, on vérifie s'il contient le numéro de fournisseur et on le range dans le dossier correspondant, on ajoute une ligne au log pour chaque fichier déposé
			if(str_contains($file,$client['login']))
			{
				array_push($a_suppr,$client['login']);
			}
		}
	}
}

foreach ($a_suppr as $log) {
	//Pour les KANBAN
	$rep = "repertoires_fournisseurs/".$log."/KANBAN/";
	$dir = opendir($rep);
	while($file = readdir($dir))
	{
		if(is_file($rep.$file))
		{
			unlink($rep.$file);
		}
	}
	//Pour les CALL_OF
	$rep = "repertoires_fournisseurs/".$log."/CALL_OF/";
	$dir = opendir($rep);
	while($file = readdir($dir))
	{
		if(is_file($rep.$file))
		{
			unlink($rep.$file);
		}
	}
}

foreach ($a_suppr as $log) {
		//Rangement des nouveaux fichiers pour la journée
		$rep = "exchange/from_sap/";
    $dir = opendir($rep);
    while ($file = readdir($dir))
    {
			if(is_file($rep.$file))
      {
        //Pour chaque fichier, on vérifie s'il contient le numéro de fournisseur et on le range dans le dossier correspondant, on ajoute une ligne au log pour chaque fichier déposé
        if(str_contains($file,$log))
				{
          if(str_contains($file,".pdf"))
					{
            rename("exchange/from_sap/".$file, "repertoires_fournisseurs/".$log."/KANBAN/".$file);
          }

          elseif(str_contains($file,"OTIF"))
					{
            rename("exchange/from_sap/".$file, "repertoires_fournisseurs/".$log."/OTIF/".$file);
          }
          else
					{
            rename("exchange/from_sap/".$file, "repertoires_fournisseurs/".$log."/CALL_OF/".$file);
          }
					$logfile = fopen("log/log_script.txt","a");
					$newline = "[ ".date('j-m-y, H:i:s')." ] Dépôt du fichier : ".$file."\r\n";
					fputs($logfile,$newline);
					fclose($logfile);
				}
      }
    }
	}

$rep = "exchange/from_sap/";
$dir = opendir($rep);
while ($file = readdir($dir))
{
	unlink($rep.$file);
}

 ?>
