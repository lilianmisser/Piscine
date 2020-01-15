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
	<link rel=stylesheet href=css/bootstrap.css type=text/css>
	<link rel=stylesheet href=css/format.css type=text/css>
</head>
<body>
	<?php
		include("bandeau/bandeauAdm.php");
		include("menu/menuAdm.php"); //si compte adm, menuUti sinon
		?>
		<div class=container style="padding-top:5%;padding-left:">
			<div class="row justify-content-center">
				<form method = "post" action = "statProf/redirection.php">

					<div class="form-group row">
						<label class=" col-lg-9 col-form-label col-form-label-sm" for="spec">Choisissez une promotion</label>			
						<select name="specialite_et_annee">
							<?php
								for($i=0 ; $i < count($tab) ; $i++){
							?>
							<option value="<?php echo($tab[$i]["id_spe"]); ?>"><?php echo($tab[$i]["id_spe"]); ?></option>
							<?php
								}
							?>
						</select>
					</div>


					<div class="form-group row">
						<label class="col-lg-9 col-form-label col-form-label-sm" for="spec">Choisissez un groupe (optionnel)</label>
						<select name = "groupe_niveau">
							<option value=""></option>
							<option value=1>1</option>
							<option value=2>2</option>
							<option value=3>3</option>
						</select>
					</div>
					<button class="btn btn-secondary" type = "submit" name=redi value = "statPart">Moyenne promotion</button>
					<button class="btn btn-secondary" type ="submit" name=redi value = "promo">Statistiques élèves promotion</button>
				</form>
			
			</div>
			<div class="row justify-content-center">
				<?php
					if(isset($_GET["err"]) && $_GET["err"]==0){
						echo '<h5 style="padding-top:2%;padding-bottom:2%;color:red;">Pas de données pour cette catégorie</h5>';
					}

				?>
			</div>
		</div>
</body>
</html>