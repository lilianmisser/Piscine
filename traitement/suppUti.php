<?php
	include("../connectbdd.php");
	

	//Vérification qu'on soit bien passé par la page de suppression
	if(isset($_POST["supp"])){

		//On supprime le compte dans la BDD avec son mail
		if($requete = $bdd->prepare("DELETE FROM compte WHERE compte.mail = ?")){
			$requete->bind_param("s",$_POST["supp"]);
			$requete->execute();
			echo '<form id=form method=post action=../gererUtilisateurs.php?supp=1>
						<input type=hidden name=spe value=',$_POST["spe"],'>
					</form>';
			

			//Envoi du formulaire automatiquement
			echo '<script type="text/JavaScript">
                   	 document.getElementById("form").submit();
                  </script>';
		}
		else{
			header("Location: ../gererUtilisateurs.php?supp=0"); //ne trouve pas le mail du compte associe
			exit;
		}	
	}
	else{
		header("Location: ../accueil.php"); // si accès a la page par le lien
		exit;
	}
	$bdd->close();
?>