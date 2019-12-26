<?php
	include("connectbdd.php");
	if (isset($_POST['mail']) && isset($_POST['mdp'])) {
		if ($_POST['mail'] != "" and $_POST['mdp'] != ""){
			$hashedPassword = password_verify($_POST["mdp"],PASSWORD_DEFAULT);
			if ($requete = $bdd->prepare('SELECT id_compte,prenom,mdp FROM compte WHERE compte.mail=?')){
				$requete->bind_param('s',$_POST["mail"]);
				$requete->execute();
				$requete->store_result();
				$requete->bind_result($userid,$firstname,$mdp);
				$requete->fetch();
				if ($requete->num_rows==0){
					header("Location: page_connexion.php?erreur=Pas de correspondance mail/mdp");
					exit;
				}
				elseif ($requete->num_rows==1){
					if(password_verify($_POST['mdp'],$mdp)){
						session_start();
						$_SESSION['user_id'] = $userid;
						$_SESSION['user_firstname'] = $firstname;
						header("Location: page_accueil.php");
						exit;
					}
					else{
						header("Location: page_connexion.php?erreur=Pas de correspondance mail/mdp");
						exit;
					}
				}
				else{
						header("Location: page_connexion.php?erreur=ERREUR");
						exit;
				}
			}
		}	
		else{
			header("Location: page_connexion.php?erreur=Informations manquantes");
			exit;
		}
	
	}
	else{
		header("Location: page_accueil.php");
		exit;
	}
	$bdd->close();
?>
