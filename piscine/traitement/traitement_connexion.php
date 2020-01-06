<?php
	include("../connectbdd.php");
	if (isset($_POST['mail']) && isset($_POST['mdp'])) {
		if ($_POST['mail'] != "" and $_POST['mdp'] != ""){
			$hashedPassword = password_verify($_POST["mdp"],PASSWORD_DEFAULT);
			if ($requete = $bdd->prepare('SELECT id_compte,prenom,nom,mdp FROM compte WHERE compte.mail=?')){
				$requete->bind_param('s',$_POST["mail"]);
				$requete->execute();
				$requete->store_result();
				$requete->bind_result($userid,$firstname,$lastname,$mdp);
				$requete->fetch();
				if ($requete->num_rows==0){
					header("Location: ../index.php?errConnexion=1");
					exit;
				}
				elseif ($requete->num_rows==1){
					if(password_verify($_POST['mdp'],$mdp)){
						session_start();
						$_SESSION['user_id'] = $userid;
						$_SESSION['user_firstname'] = $firstname;
						$_SESSION['user_lastname'] = $lastname;
						header("Location: ../accueil.php");
						exit;
					}
					else{
						header("Location: ../index.php?errConnexion=2");
						exit;
					}
				}
				else{
						header("Location: ../index.php?errConnexion=3");
						exit;
				}
			}
		}	
		else{
			header("Location: ../index.php?errConnexion=4");
			exit;
		}
	
	}
	else{
		header("Location: ../index.php");
		exit;
	}
	$bdd->close();
?>
