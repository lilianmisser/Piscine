<?php
	include("connectbdd.php");

	if($requete = $bdd->prepare("SELECT nom_sujet FROM sujet_toeic ")){
		$requete->execute();
		$tab = get_result($requete);
	}
	$bdd->close();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Modifier Toeic</title>
</head>
<body>
	<form method="post" action= "traitement/traitement_modifToeic.php">
		<select name="nom_sujet">
		<?php
			for($i=0;$i<count($tab);$i++){
		?>
			<option value="<?php echo($tab[$i]["nom_sujet"])?>"> <?php echo($tab[$i]["nom_sujet"]) ?> </option>
		<?php
			}
		?>
		</select>
		<br>
		<input type="submit" value="Valider">
	</form>
</body>
</html>