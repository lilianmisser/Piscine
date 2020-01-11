<?php
	include("../connectbdd.php");
	
	if(isset($_POST["nom_sujet"])){
		if($requete = $bdd->prepare("DELETE FROM sujet_toeic WHERE sujet_toeic.nom_sujet = ?")){
			$requete->bind_param("s",$_POST["nom_sujet"]);
			$requete->execute();
			header("Location: bon.php"); // sujet suppr
			exit;
		}
		else{
			header("Location: pas_bon.php");
			exit;
		}	
	}
	else{
		header("Location: pas_bon.php"); // probleme pas de nom sujet( un petit hacker)
		exit;
	}
	$bdd->close();
?>