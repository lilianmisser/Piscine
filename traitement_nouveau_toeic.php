<?php
	include("connectbdd.php");
    $taille_toeic = 200;
    $correct = true;
    
    if(!(isset($_POST["nom_sujet"])) or $_POST["nom_sujet"] == ""){
    	header("Location: page_accueil.php");
        exit;
    }
    
    for ($i=1 ; $i <= $taille_toeic ; $i++) {
        if(!(isset($_POST['question'.strval($i)]) or !($_POST['question'.strval($i)] == "A" or $_POST['question'.strval($i)] == "B" or $_POST['question'.strval($i)] == "C" or $_POST['question'.strval($i)] == "D"))){
        	$correct = false;
        }
    }
    
    if($correct){
    	if($requete = $bdd->prepare("INSERT INTO sujet_toeic (nom_sujet) VALUES (?)")){
    		$requete->bind_param("s",$_POST["nom_sujet"]);
    		$requete->execute();
    		if($requete->affected_rows == -1){ //le nom de sujet a un index UNIQUE donc il y aura une erreur si il existe déjà
    			header("Location: ajout_sujet_toeic.php?erreur=Nom déjà utilisé");
    			exit;
    		}
    		elseif($requete->affected_rows == 1){
    			$sujetid = $requete->insert_id;
    			for ($i=1 ; $i <= $taille_toeic ; $i++){
					if($requete = $bdd->prepare("INSERT INTO question (num_question,reponse,id_sujet) VALUES (?,?,?)")){
						$requete->bind_param('isi', $i , $_POST['question'.strval($i)] , $sujetid);
						$requete->execute();
					}
				}	    	
			}
			header("Location: page_accueil.php");
			exit;
    	}
    }
    else{
    	header("Location: ajout_sujet_toeic.php?erreur=Valeurs non conformes");
		exit;
    }
    $bdd->close();
?>