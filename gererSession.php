<?php
	include("connectbdd.php");
	session_start();
	if(!(isset($_SESSION['user_id']))){ // s'il n'y a pas de session
		header("Location: index.php"); // redirection vers la page de connexion/inscription
		exit;
	}
	if($requete = $bdd->prepare("SELECT est_admin FROM compte WHERE compte.id_compte = ?")){ // selectionne le booleen indiquant si l'utilisateur est administrateur ou non
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
	if($requete = $bdd->prepare("SELECT id_grp,id_spe,num_grp FROM groupe")){ // selectionne tous les groupes d'apres les specialites (IG3-1,...)
		$requete->execute();
		$tab = get_result($requete);
	}
	if($requete = $bdd->prepare("SELECT nom_sujet FROM sujet_toeic")){ // selectionne les noms des sujets de toeic (pour plus tard les proposer dans un menu deroulant)
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
					<!-- creation du menu a onglet pour la gestion des sessions -->
					<div class="btn-group-vertical">
						<a type="button" class="btn btn-blue" href=#NewSession>Programmer une session</a>
						<a type="button" class="btn btn-blue" href=#StartSession>Lancer une session</a>
						<a type="button" class="btn btn-blue" href=#RunningSession>Sessions en cours</a>
					</div>
				</div>

				<div class="col contenu">
					<div class=container>
						<!-- lien entre le menu a onglet et les "pages" correspondantes -->
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