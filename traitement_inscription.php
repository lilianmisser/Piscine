<?php 
	include("connectbdd.php") ;
	//fonction créer par @Sophivorus
	//celle-çi permet de récupérer dans un tableau le résultat d'une requête préparée
	function get_result(\mysqli_stmt $statement){
	    $result = array();
	    $statement->store_result();
	    for ($i = 0; $i < $statement->num_rows; $i++)
	    {
	        $metadata = $statement->result_metadata();
	        $params = array();
	        while ($field = $metadata->fetch_field())
	        {
	            $params[] = &$result[$i][$field->name];
	        }
	        call_user_func_array(array($statement, 'bind_result'), $params);
	        $statement->fetch();
	    }
	    return $result;
	}

	if($requete = $bdd->prepare("SELECT id_spe FROM specialite")){
		$requete->execute();
		$tab = get_result($requete);
	}

	if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['mail']) && isset($_POST['specialite_et_annee']) && isset($_POST['mdp']) && isset($_POST['groupe_niveau']) ) {
//Partie test des formulaires
		if ($_POST["nom"] == "" or $_POST['prenom'] == "" or $_POST['mail'] == "" or $_POST["specialite_et_annee"] == "" or $_POST["mdp"] == "" or $_POST["groupe_niveau"] == ""){
			header("Location: formulaire_inscription.php?erreur=Champ non rempli");
			exit;
		}

		if (!preg_match('/^[\p{L}-]+$/',$_POST['nom'])){
		    header("Location: formulaire_inscription.php?erreur=Nom non valable");
			exit;
		}
		elseif (strlen($_POST['nom']) > 20){
		    header("Location: formulaire_inscription.php?erreur=Nom trop long");
			exit;
		}

		if (!preg_match('/^[\p{L}-]+$/',$_POST['prenom'])){
		    header("Location: formulaire_inscription.php?erreur=Prénom non valable");
		    exit;
		}
		elseif (strlen($_POST['prenom']) > 20){
			header("Location: formulaire_inscription.php?erreur=Prénom trop long");
			exit;
		}

		if (strlen($_POST['mdp']) <= 6){
		    header("Location: formulaire_inscription.php?erreur=Le mot de passe doit faire plus de 6 caractères");
		    exit;
		}

		if (!preg_match("/[\w.]+@etu\.umontpellier\.fr$/",$_POST['mail'])){
			header("Location: formulaire_inscription.php?erreur=E-mail non valide, il faut qu'elle soit universitaire de MTP");
			exit;
		}

		$specialite = $tab;
		$i = 0;
		$correspondance_specialite = false;
		while (!$correspondance_specialite and $i < count($specialite)){
			if($_POST['specialite_et_annee'] == $specialite[$i]["id_spe"]){
				$correspondance_specialite = true;
			}
			else{
				$i = $i + 1;
			}
		}
		if($i == count($specialite)){
			header("Location: formulaire_inscription.php?erreur=Cette spécialité n'existe pas");
			exit;
		}


		if (!($_POST["groupe_niveau"] == 1 or $_POST["groupe_niveau"] == 2)){
			header("Location: formulaire_inscription.php?erreur=Ce groupe de niveau n'existe pas");
			exit;
		}
		
//Fin partie test formulaire
//Partie requete
		if ($requete = $bdd->prepare('SELECT id_grp FROM groupe NATURAL JOIN specialite WHERE groupe.num_grp=? AND specialite.id_spe=?')){
			$requete->bind_param('is', intval($_POST['groupe_niveau']) , $_POST['specialite_et_annee']);
			$requete->execute();
			$requete->store_result();
			if ($requete->num_rows == 1 ){
				$requete->bind_result($groupid);
				$requete->fetch();
				$hashedPassword = password_hash($_POST['mdp'],PASSWORD_DEFAULT);
				if($requete = $bdd->prepare("INSERT INTO compte (nom,prenom,mail,mdp) VALUES (?,?,?,?)")) {
					$requete->bind_param("ssss", $_POST["nom"], $_POST["prenom"],$_POST["mail"],$hashedPassword);
					$requete->execute();
					if ($requete->affected_rows == -1){ // car mail dans bdd a un index unique
						header("Location: formulaire_inscription.php?erreur=Mail déjà utilisé");
						exit;
					}
					elseif ($requete->affected_rows == 1){
						$compteid = $requete->insert_id;
						if ($requete = $bdd->prepare("INSERT INTO est_de_groupe (id_compte,id_grp) VALUES (?,?)")){
							$requete->bind_param('ii',$compteid,$groupid);
							$requete->execute();
							header("Location: page_connexion.php"); // redirige sur la page de connexion si inscription complète
							exit;
						}
					}	
				}
			}
			else{
				header("Location: formulaire_inscription.php?erreur=Groupe non trouvé"); // retourne le formulaire d'inscription si problème
				exit;
			}
			
		}	
	}
	else{
		header("Location: page_accueil.php");
		exit;
	}
	$bdd->close();
?>
