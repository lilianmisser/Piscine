<?php
	include("../connectbdd.php");
	
	if(isset($_POST["id_sujet"])){
		if($requete = $bdd->prepare("DELETE FROM sujet_toeic WHERE sujet_toeic.id_sujet = ?")){
			$requete->bind_param("s",$_POST["id_sujet"]);
			$requete->execute();
			header("Location: ../gererToeic.php?supp=1#r"); // sujet suppr
			exit;
		}
		else{
			header("Location: ../gererToeic.php?supp=0#r"); //ne trouve pas l'id du sujet associe
			exit;
		}	
	}
	else{
		header("Location: ../accueil.php"); // probleme pas de nom sujet( un petit hacker)
		exit;
	}
	$bdd->close();
?>