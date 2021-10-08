<?php
echo "START<br>";

session_start();
//Connexion a la base de données
try {
	$pdo = new PDO('mysql:host=localhost;dbname=suppliers;charset=utf8', 'root', '');
}
catch( PDOException $e ) {
	$_SESSION['message_index'] = TXT_ERREUR_BBD.$e->getMessage();
	header('Location: ../index.php');
	exit();
}
//Boucle sur chaque fournisseur

$req =  'SELECT login FROM users ORDER BY login';
foreach  ($pdo->query($req) as $client) {

	//Vider les dossiers des fichiers OTIF de la semaine dernière
	//Pour les OTIF
	
	$rep = "repertoires_fournisseurs/".$client["login"]."/OTIF/";
	//echo $rep;
	//echo "<br>";
	$dir = opendir($rep);
	while($file = readdir($dir))
	{
		if(is_file($rep.$file))
		{
				echo "Supression : ".$rep.$file;
				echo "<br>";
			unlink($rep.$file);

			
		}
	}
}
?>
