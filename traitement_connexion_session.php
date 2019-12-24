<?php 
	include("connectbdd.php");
	if(isset($_POST["nom_sujet"])){
		if($_POST["nom_sujet"] == ""){
            header("Location: connection_session.php?erreur=Veuillez entrer un nom de sujet non vide");
            exit;
		}

		$current_date = date('Y-m-d');

		if($requete = $bdd->prepare("SELECT id_sujet FROM sujet_toeic WHERE sujet_toeic.nom_sujet = ?")){
			$requete->bind_param("s",$_POST["nom_sujet"]);
			$requete->execute();
			$requete->store_result();
			if($requete->num_rows == 0){
				header("Location: connection_session.php?erreur=Ce nom de sujet n'existe pas");
            	exit;
			}
			elseif($requete->num_rows == 1){
				$requete->bind_result($sujetid);
				$requete->fetch();
				if($requete = $bdd->prepare("SELECT id_session FROM session WHERE session.id_sujet = ? AND session.date_session = ?")){
					$requete->bind_param("is",$sujetid,$current_date);
					$requete->execute();
					$requete->store_result();
					if($requete->num_rows == 0){
						header("Location: connection_session.php?erreur=Aucune session prévu aujourd'hui");
            			exit;	
					}
					elseif($requete->num_rows == 1){
						$requete->bind_result($session);
						$requete->fetch();
						if($requete = $bdd->prepare("SELECT est_en_cours,est_fini FROM session WHERE session.id_session = ?")){
							$requete->bind_param("i",$session);
							$requete->execute();
							$requete->store_result();
							$requete->bind_result($running,$finished);
							$requete->fetch();
							if($finished){
								header("Location: connection_session.php?erreur=Session déjà effectué");
            					exit;
							}
							elseif($running){
								header("Location: questions.php");
            					exit;
							}
							else{
								header("Location: connection_session.php?erreur=Session en attente de lancement");
            					exit;
							}
						}
					}
				}
			}
		}
	}
	else{
		header("Location: page_accueil.php");
		exit;
	}
	$bdd->close();
 ?>