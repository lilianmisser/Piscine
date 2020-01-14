<?php
	include("connectbdd.php");
	session_start();
	if(!(isset($_SESSION['user_id']))){
		header("Location: index.php");
		exit;
	}
	if($requete = $bdd->prepare("SELECT est_admin FROM compte WHERE compte.id_compte = ?")){
		$requete->bind_param("i",$_SESSION["user_id"]);
		$requete->execute();
		$requete->store_result();
		$requete->bind_result($admin);
		$requete->fetch();
	}
	if(!$admin){
		header("Location: accueil.php");
		exit;
	}
	include("traitement/getResult.php");
	if($requete = $bdd->prepare("SELECT id_spe FROM specialite")){
		$requete->execute();
		$tab = get_result($requete);
	}
	$bdd->close();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Statistiques</title>
</head>
<body>
	<form method = "post" action = "statsProfs.php">
		Insérez groupe
		<br>
		<select name = "groupe_niveau">
			<option value=""></option>
			<option value=1>1</option>
			<option value=2>2</option>
			<option value=3>3</option>
		</select>
		<br>
		Insérez promo
		<br>
		<select name="specialite_et_annee">
			<?php
				for($i=0 ; $i < count($tab) ; $i++){
			?>
			<option value="<?php echo($tab[$i]["id_spe"]); ?>"><?php echo($tab[$i]["id_spe"]); ?></option>
			<?php
				}
			?>
		</select>
		<br>
		<input type = "submit" value = "Statistiques partielles">
		
	</form>
	<form method = "post" action = "statsProfs2.php">
		Insérez groupe
		<br>
		<select name = "groupe_niveau">
			<option value=""></option>
			<option value=1>1</option>
			<option value=2>2</option>
			<option value=3>3</option>
		</select>
		<br>
		Insérez promo
		<br>
		<select name="specialite_et_annee">
			<?php
				for($i=0 ; $i < count($tab) ; $i++){
			?>
			<option value="<?php echo($tab[$i]["id_spe"]); ?>"><?php echo($tab[$i]["id_spe"]); ?></option>
			<?php
				}
			?>
		</select>
		<br>

		<input type ="submit" value = "Vision promotion"/>
	</form>
</body>
</html>