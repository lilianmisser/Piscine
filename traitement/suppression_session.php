<?php
	include("../connectbdd.php");
	$un = 1;
	$zero = 0;
	if(isset($_POST['id_session'])){
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