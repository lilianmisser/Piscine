<?php
	include("../connectbdd.php");
	$un = 1;
	$zero = 0;
	if(isset($_POST['id_session'])){
		if($requete = $bdd->prepare("UPDATE session SET est_en_cours = ? WHERE session.id_session = ?")){
			$requete->bind_param("ii",$un,$_POST['id_session']);
			$requete->execute();
			header("Location: ../gererSession.php?sessionCommencee=1#StartSession");
			exit;
		}
	}
	else{
		header("Location: ../gererSession.php?sessionCommencee=0#StartSession");
		exit;
	}
	$bdd->close();
?>