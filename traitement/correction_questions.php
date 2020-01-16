<?php

	//Fonction get_result($requete)
	include("getResult.php");
	$taille_toeic = 200;

	session_start();
	include("../connectbdd.php");

    //Test si utilisateur connecté et qu'il est bien passé par la page des questions
    if(!(isset($_SESSION["user_id"])) or !(isset($_POST["id_session"])) ){
		header("Location: ../accueil.php");
		exit;
	}


    //Récupère le sujet lié à la session que l'utilisateur a participé
    if($requete = $bdd->prepare("SELECT id_sujet FROM session WHERE session.id_session = ?")){
    	$requete->bind_param("i",$_POST["id_session"]);
    	$requete->execute();
    	$requete->store_result();
    	$requete->bind_result($sujetid);
    	$requete->fetch();

        //Récupère les réponses
    	if($requete = $bdd->prepare("SELECT reponse FROM question WHERE question.id_sujet = ?")){
    		$requete->bind_param("i",$sujetid);
    		$requete->execute();
    		$reponses = get_result($requete);

            //Compteur de question
    		$num_question =0;

            //Note par sous-partie
    		$score = array(0,0,0,0,0,0,0);

            //Taille de chaque sous-partie
    		$lenght = array(6,25,39,30,30,16,54);

    		for($i=0 ; $i<count($lenght) ; $i++){
    			for($j=0 ; $j < ($lenght[$i]) ; $j++){
                    if(isset($_POST["question".strval($num_question + 1)]) && $_POST["question".strval($num_question + 1)] == $reponses[$num_question]["reponse"]) {
    					$score[$i] += 1;
    				}
    				$num_question += 1;
    			}
    		}

            //Insertion des notes dans la BDD
    		for($i=1 ; $i<= count($lenght) ; $i++){
    			if($requete = $bdd->prepare("INSERT INTO sous_partie (num_sp,note_sp,id_compte,id_session) VALUES (?,?,?,?)")){
    				$requete->bind_param("iiii",$i,$score[$i-1],$_SESSION["user_id"],$_POST["id_session"]);
    				$requete->execute();
    			}

    		}
            header("Location: ../mesNotes.php");
            exit;
    	}
    }
    //Cas d'erreur (si pas de sujet lié à la session)
    header("Location: ../accueil.php");
    exit;

    
    $bdd->close();	
?>