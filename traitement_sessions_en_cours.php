<?php
	include("connectbdd.php");
	$un = 1;
	$zero = 0;
	if(isset($_POST['id_session'])){
		if($requete = $bdd->prepare("UPDATE session SET est_en_cours = ?, est_fini = ? WHERE session.id_session = ?")){
			$requete->bind_param("iii",$zero,$un,$_POST['id_session']);
			$requete->execute();
			header("Location: gestion_session.php");
			exit;
		}
	}
	else{
		header("Location: page_accueil.php");
		exit;
	}
	$bdd->close();
?>