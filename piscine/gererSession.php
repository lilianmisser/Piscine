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
	if($requete = $bdd->prepare("SELECT id_grp,id_spe,num_grp FROM groupe")){
		$requete->execute();
		$tab = get_result($requete);
	}
	if($requete = $bdd->prepare("SELECT nom_sujet FROM sujet_toeic")){
		$requete->execute();
		$listeSujet = get_result($requete);
	}




	$bdd->close();

	?>

<html>
	<head>
		<link rel=stylesheet href=css/bootstrap.css type=text/css>
		<link rel=stylesheet href=css/gererToeic.css type=text/css>
		<link rel=stylesheet href=css/format.css type=text/css>
		<title>Gestion de session</title>
	</head>
	<body>
		<?php
		include("bandeau/bandeauAdm.php"); 
		include("menu/menuAdm.php");
		?>
		<div class=container>
			<div class=row style="padding-top: 5%;">
				<div class="col-lg-3">
					<div class="btn-group-vertical">
						<a type="button" class="btn btn-blue" href=#NewSession>Programmer une session</a>
						<a type="button" class="btn btn-blue" href=#StartSession>Lancer une session</a>
						<a type="button" class="btn btn-blue" href=#RunningSession>Sessions en cours</a>
					</div>
				</div>

				<div class="col contenu">
					<div class=container>
						<div id="NewSession">
							<?php include("gestionSession/progSession.php"); ?>
						</div>
						<div id="StartSession">
							<?php include("gestionSession/lancerSession.php"); ?>
						</div>
						<div id="RunningSession">
							<?php include("gestionSession/sessionEnCours.php"); ?>
						</div>
					</div>
				</div>
			</div>
		</div>

	</body>
</html>