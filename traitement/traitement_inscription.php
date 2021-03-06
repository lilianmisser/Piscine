<?php 
	include("../connectbdd.php");
	include("getResult.php");


	//On récupère la liste des spécialités pour s'assurer que la spécialité envoyée par la formulaire corresponde à une spécialité de la BDD
	if($requete = $bdd->prepare("SELECT id_spe FROM specialite")){
		$requete->execute();
		$tab = get_result($requete);
	}


	//Gestion des erreurs
	$errNom=0;
	$errPrenom=0;
	$errMail=0;
	$errSpe=0;
	$errMDP=0;
	$errGrp=0;

		
		//Si champs non définis ou vides
		if(!(isset($_POST['nom'])) || ($_POST['nom']=='' )) {
			$errNom=1;
		}
		if(!(isset($_POST['prenom'])) || ($_POST['prenom']=='')) {
			$errPrenom=1;
		}
		if(!(isset($_POST['mail'])) || ($_POST['mail']=='')) {
			$errMail=1;
		}

		//Si ce n'est pas une création de compte administrateur, on vérifie le groupe et la spécialité
		if(!isset($_POST["creationAdm"])){
			if(!(isset($_POST['specialite_et_annee']))) {
				$errSpe=1;
			}
			if(!(isset($_POST['mdp'])) || ($_POST['mdp']=='')){
				$errMDP=1;
			}
			if(!(isset($_POST['groupe_niveau']))){
				$errGrp=1;
			}
		}


		//Test caractères spéciaux
		if ($errNom!=1 && !preg_match('/^[A-Za-z\é\è\ê\-]+$/',$_POST['nom'])){
		    $errNom=2;
		}
		elseif ($errNom!=1 && strlen($_POST['nom']) > 20){
			//Test longueur
		    $errNom=3;
		}

		//Test caractères spéciaux
		if ($errPrenom!=1 && !preg_match('/^[A-Za-z\é\è\ê\-]+$/',$_POST['prenom'])){
		    $errPrenom=2;
		}
		elseif ($errPrenom!=1 && strlen($_POST['prenom']) > 20){
			//Test longueur
			$errPrenom=3;
		}
		
		//Test longueur
		if ($errMDP!=1 && strlen($_POST['mdp']) <= 7){
		    $errMDP=2;
		}

		//On vérifie la mail selon s'il s'agit d'une création de compte administrateur ou élève
		if(!isset($_POST["creationAdm"])){
			if ($errMail!=1 && !preg_match("/[\w.]+@etu\.umontpellier\.fr$/",$_POST['mail'])){
				$errMail=2;
			}
		}else{
			if ($errMail!=1 && !preg_match("/[\w.]+@umontpellier\.fr$/",$_POST['mail'])){
				$errMail=2;
			}
		}

		//Vérification de l'unicité du mail
		if($requete = $bdd->prepare("SELECT mail FROM compte WHERE compte.mail = ?")) {
			$requete->bind_param("s",$_POST["mail"]);
			$requete->execute();
			$requete->store_result();
			if ($requete->num_rows != 0){
				$errMail=3;
			}
		}

		//Si ce n'est pas une création de compte administrateur, on vérifie le groupe et la spécialité
		if(!isset($_POST["creationAdm"])){
			$specialite = $tab;
			$i = 0;
			$correspondance_specialite = false;
			if($errSpe!=1){

				//Vérification si la spécialité appartient à la BDD
				while (!$correspondance_specialite and $i < count($specialite)){
					if($_POST['specialite_et_annee'] == $specialite[$i]["id_spe"]){
						$correspondance_specialite = true;
					}
					else{
						$i = $i + 1;
					}
				}
				if($i == count($specialite)){
					$errSpe=2;
				}
			}

			//Vérification s'il s'agit du groupe 1,2 ou 3
			if ($errGrp!=1 && !($_POST["groupe_niveau"] == 1 or $_POST["groupe_niveau"] == 2 or $_POST["groupe_niveau"] == 3)){
				$errGrp=2;
			}
		}
		
		//On envoie la formulaire des erreurs
		if(!isset($_POST["creationAdm"])){
			if(!($errNom==0 && $errPrenom==0 && $errMail==0 && $errSpe==0 && $errMDP==0 && $errGrp==0)){
				 echo '<form method="post" action="../index.php?errNom=',$errNom,'&errPrenom=',$errPrenom,'&errMail=',$errMail,'&errSpe=',$errSpe,'&errMDP=',$errMDP,'&errGrp=',$errGrp,'" id="form" name="form">';
				 if($errNom==0){
				 	echo '<input type="hidden" name="nomValide" value="',$_POST["nom"],'">';
				 }
				 if($errPrenom==0){
				 	echo '<input type="hidden" name="prenomValide" value="',$_POST["prenom"],'">';
				 }
				 if($errMail==0){
				 	echo '<input type="hidden" name="mailValide" value="',$_POST["mail"],'">';
				 }
				 if($errMDP==0){
				 	echo '<input type="hidden" name="MDPValide" value="',$_POST["mdp"],'">';
				 }
				 if($errGrp==0){
				 	echo '<input type="hidden" name="grpValide" value="',$_POST["groupe_niveau"],'">';
				 }
				 if($errSpe==0){
				 	echo '<input type="hidden" name="speValide" value="',$_POST["specialite_et_annee"],'">';
				 }
				 echo '</form>';
				  echo '<script type="text/JavaScript">
	                    document.getElementById("form").submit();
	                    </script>';

			}else{

				
				//Création du compte élève
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
								$compteid = $requete->insert_id;
								if ($requete = $bdd->prepare("INSERT INTO est_de_groupe (id_compte,id_grp) VALUES (?,?)")){
									$requete->bind_param('ii',$compteid,$groupid);
									$requete->execute();
									
									//Connection automatique après l'inscription
									echo '<form method=post action=traitement_connexion.php id=form name=form>
												<input type=hidden name=mail value=',$_POST["mail"],'>
												<input type=hidden name=mdp value=',$_POST["mdp"],'>
											</form>
											<script type="text/JavaScript">
		                  						  document.getElementById("form").submit();
		                   					 </script>';
								}
								
						}
					}
					else{
						header("Location: ../index.php?erreur=Groupe non trouvé"); // retourne le formulaire d'inscription si problème
						exit;
					}
					
				}
			}	

			//creation du compte administrateur
		}elseif(isset($_POST["creationAdm"]) && $_POST["creationAdm"]=="compteAdm") { 
			//Envoi du formulaire en cas d'erreur
			if(!($errNom==0 && $errPrenom==0 && $errMail==0 && $errMDP==0)){
				 echo '<form method="post" action="../monCompte.php?errNom=',$errNom,'&errPrenom=',$errPrenom,'&errMail=',$errMail,'&errMDP=',$errMDP,'#adm" id="form" name="form">';
				 if($errNom==0){
				 	echo '<input type="hidden" name="nomValide" value="',$_POST["nom"],'">';
				 }
				 if($errPrenom==0){
				 	echo '<input type="hidden" name="prenomValide" value="',$_POST["prenom"],'">';
				 }
				 if($errMail==0){
				 	echo '<input type="hidden" name="mailValide" value="',$_POST["mail"],'">';
				 }
				 if($errMDP==0){
				 	echo '<input type="hidden" name="MDPValide" value="',$_POST["mdp"],'">';
				 }
				 echo '</form>';
				  echo '<script type="text/JavaScript">
	                    document.getElementById("form").submit();
	                    </script>';

			}else{
				//On crée le compet administrateur
				if($requete=$bdd->prepare('INSERT INTO compte VALUES (null,?,?,?,?,1)')){
					$requete->bind_param("ssss",$_POST["nom"],$_POST["prenom"],$_POST["mail"],password_hash($_POST["mdp"],PASSWORD_DEFAULT));
					$requete->execute();
					header("Location: ../monCompte.php?successAdm=1#adm");
					exit;
				}
			}
	}	
	$bdd->close();
?>
