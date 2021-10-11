<?php
	session_start();
	require('../lang.php');
	if ( empty($_SESSION['user']) )
	{
		header('Location: ../index.php');
		exit();
	}

	unset($_SESSION['message_changemdp']);
  $compteur = 0;

	function format_date($date){
		$annee = substr($date,0,4);
		$mois = substr($date,-5,2);
		$jour = substr($date,-2);
		$newdate = $jour . "-" . $mois . "-" . $annee;
		return $newdate;
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<?php
		include_once('../include/header.php');
		?>
		<link rel="stylesheet" type="text/css" href="/css/both.css">
		<title><?php echo TXT_TITRE_COMPTE ?></title>
	</head>
	<body>
    <div id="top">
			<a href="https://suppliers.bdrthermea-france.fr/compte/account.php" title="BDR THERMEA France"><img src="/css/BDR-THERMEA-FRANCE.png" /></a>
		</div>
		<?php
		include_once('../include/topmenu.php');
		?>
    <div id="container">
			<br><br>
          <form action="setConges.php" method="post">
						<h1><?php echo TXT_SET_CONGES; ?></h1>
            <label for="start"><?php echo TXT_CONGES_START ?></label>
            <input type="date" id="start" name="start" value=<?php $today;  ?>required>
            <br><br>
            <label for="end"><?php echo TXT_CONGES_END ?></label>
            <input type="date" id="end" name="end" required>
            <br><br>
            <input type="submit" value=<?php echo TXT_BTN_SEND; ?>>
						<?php if ( isset($_SESSION['message_conges']) && !empty($_SESSION["message_conges"]) ){ ?>
						<section id="message">
							<p><?= $_SESSION["message_conges"]?></p>
						</section>
						<?php } ?>
        </form>
				<br><br>
    </div>
    <div id="content">
			<table class="cong" summary="Conges du fournisseur">
				<thead>
					<tr>
						<th width="40%" scope="col" class="start"><?php echo TXT_DEBUT; ?></th>
						<th width="40%" scope="col" class="end"><?php echo TXT_FIN; ?></th>
						<th width="20%" scope="col" class="delete"><?php echo TXT_SUPPRIMER; ?></th>
					</tr>
				</thead>
				<tbody>
				<?php
				try {
					$bdd = new PDO('mysql:host=localhost;dbname=suppliers;charset=utf8', 'root', '');
				}
				catch( PDOException $e ) {
					$_SESSION['message_forgot'] = TXT_ERREUR_BBD.$e->getMessage();
					header('Location: conges.php');
					exit();
				}
				$login = $_SESSION['user'];
				// 1. On prépare la requête
				$request = $bdd->prepare( "SELECT * FROM conges WHERE login = :login" );

				// 2. On assigne les paramètres nommés
				$ok = $request->bindValue( ":login", $login, PDO::PARAM_STR );
				// 3. On exécute la requête
				$ok &= $request->execute();
				// 4. On vérifie que la requête s'est executée sans erreur
				if ( !$ok )
				{
					$_SESSION['message_index'] = TXT_ERREUR_DEFINE;
					header('Location: conges.php');
					exit();
				}

				// 5. On récupère la 1ère ligne du résultat de la requête
				while($conges = $request->fetch())
				{
					$compteur ++;
					if($_SESSION['lang'] === 'fr'){
						$debut = format_date($conges['debut']);
						$fin = format_date($conges['fin']);
					}
					else{
						$debut = $conges['debut'];
						$fin = $conges['fin'];
					}
					?>
					<tr>
						<td class="start"><?php echo $debut; ?></td>
						<td class="end"><?php echo $fin; ?></td>
						<td class="delete"><a href="spprconges.php?id=<?php echo $conges['id']; ?>" onclick="return confirm('<?php echo  TXT_CONFIRM ?>');" ><?php echo TXT_SUPPRIMER ?></a></td>
					</tr>
					<?php
				}
				$reponse->closeCursor(); // Termine le traitement de la requête
				?>
        </tbody>
        </table>
				<?php
				if ($compteur===0){
					echo "<br><font color='#FF0000'>" . TXT_PAS_VACANCES . "</font>";
				}
				?>
		</div>
	</body>
	</html>
