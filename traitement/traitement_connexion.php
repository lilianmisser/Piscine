<?php
	include("../connectbdd.php");

	//Vérification qu'on soit bien passé par la page de connection
	if (isset($_POST['mail']) && isset($_POST['mdp'])) {


		if ($_POST['mail'] != "" and $_POST['mdp'] != ""){

			//Fonction de hashage du mdp
			$hashedPassword = password_verify($_POST["mdp"],PASSWORD_DEFAULT);

			//On récupère le compte associé aux identifiants dans la BDD et on définit les variables globales
			if ($requete = $bdd->prepare('SELECT id_compte,prenom,nom,mdp FROM compte WHERE compte.mail=?')){
				$requete->bind_param('s',$_POST["mail"]);
				$requete->execute();
				$requete->store_result();
				$requete->bind_result($userid,$firstname,$lastname,$mdp);
				$requete->fetch();

				//Si pas de compte associé au mail
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
						header("Location: ../accueil.php"); //Succès
						exit;
					}
					else{
						//Si mdp incorrect
						header("Location: ../index.php?errConnexion=2");
						exit;
					}
				}
				else{
						//Si on trouve plusieurs comptes associés au mail, ne devrait pas arrivé
						header("Location: ../index.php?errConnexion=3");
						exit;
				}
			}
		}	
		else{
			//Si un des champs est non rempli
			header("Location: ../index.php?errConnexion=4");
			exit;
		}
	
	}
	else{
		//Si accès à cette page sans passer par la page de connection
		header("Location: ../index.php");
		exit;
	}
	$bdd->close();
?>
