<?php
	include("../connectbdd.php");

	//Vérification qu'on soit bien passé par la page de suppression
	if(isset($_POST['id_session'])){

		//On supprime la session dans la BDD selon l'id de la session choisie
		if($requete = $bdd->prepare("DELETE FROM session WHERE session.id_session = ?")){
			$requete->bind_param("i",$_POST['id_session']);
			$requete->execute();
			header("Location:  ../gererSession.php?sessionSupp=1#StartSession");
			exit;
		}
	}
	else{
		header("Location: ../gererSession.php?sessionSupp=0#StartSession");
		exit;
	}
	$bdd->close();
?>