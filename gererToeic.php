<?php
	include("connectbdd.php");
	session_start();

	//Redirection si non connecté
	if(!(isset($_SESSION['user_id']))){
		header("Location: index.php");
		exit;
	}

	//Vérification du statut administrateur
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
	
	//Fonction get_result($requete)
	include("traitement/getResult.php");



	$bdd->close();

?>



<html>
<head>
	<link rel=stylesheet href=css/bootstrap.css type=text/css>
	<link rel=stylesheet href=css/gererToeic.css type=text/css>
	<link rel=stylesheet href=css/format.css type=text/css>
	<link rel=stylesheet href=css/gererUtilisateurs.css type=text/css>
	<title>Gestion de Toeic</title>
</head>
<body>
	<?php
		include("bandeau/bandeauAdm.php"); 
		include("menu/menuAdm.php");
	?>
	<div class=container>
		<div class=row style="padding-top: 5%;">

			<!-- Menu sur le côté -->
			<div class="col-lg-3">
				<div class="btn-group-vertical">
					<a type="button" class="btn btn-blue" href=#z>Ajouter un TOEIC</a>
					<a type="button" class="btn btn-blue" href=#e>Modifier un TOEIC</a>
					<a type="button" class="btn btn-blue" href=#r>Supprimer un TOEIC</a>
				</div>
			</div>
			

			<!-- Interface centrale -->
			<div class="col contenu">
			    <div class=container>
				    
			    	<!-- Affiche l'interface selon le bouton du menu sélectionné -->
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
