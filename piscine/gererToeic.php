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


	$bdd->close();

?>



<html>
<head>
	<link rel=stylesheet href=css/bootstrap.css type=text/css>
	<link rel=stylesheet href=css/gererToeic.css type=text/css>
	<link rel=stylesheet href=css/format.css type=text/css>
	<title>Gestion de Toeic</title>
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
					<a type="button" class="btn btn-info" href=#z>Ajouter un TOEIC</a>
					<a type="button" class="btn btn-info" href=#e>Modifier un TOEIC</a>
					<a type="button" class="btn btn-info" href=#r>Supprimer un TOEIC</a>
				</div>
			</div>
			
			<div class="col contenu">
			    <div class=container>
				    

				    <div id="z">
						<?php include("gestionToeic/ajouterToeic.php"); ?>
					</div>

				    <div id="e">
						<?php include("gestionToeic/modifierToeic.php"); ?>
					</div>
					
				    <div id="r">
				    	<?php include("gestionToeic/supprimerToeic.php"); ?>
				    </div>
		    	
		    	</div>
			</div>
		</div>
	</div>
	<?php include("logo.php"); ?>
	
</body>
</html>
