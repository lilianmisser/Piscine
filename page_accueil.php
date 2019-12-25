<?php
	session_start();
	if(!(isset($_SESSION['user_id']))){
		header("Location: page_connexion.php");
		exit;
	}
	include("connectbdd.php");
	if($requete = $bdd->prepare("SELECT est_admin FROM compte WHERE compte.id_compte = ?")){
		$requete->bind_param("i",$_SESSION["user_id"]);
		$requete->execute();
		$requete->store_result();
		$requete->bind_result($admin);
		$requete->fetch();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Accueil</title>
</head>
<body>
	bienvenue sur la page d'accueil
	<br>
	<strong>
	<?php
  	if( isset($_GET["erreur"]) ) {
    	echo htmlspecialchars($_GET["erreur"]);
  	}
	?>
	<br>
	</strong>
	<a href = "connection_session.php">connection session</a>
	<?php if($admin){ ?>
	<a href = "ajout_sujet_toeic.php">ajout sujet toeic</a>
	<a href = "creation_session.php">creation session</a>
	<a href = "gestion_session.php">gestion des sessions</a>
	<?php }
		  else{
	?>
	<a href = "statistiques_eleve.php">Vision résultats</a>
	<?php } ?>
	<a href='deconnection.php'>deconnection</a>
</body>
</html>