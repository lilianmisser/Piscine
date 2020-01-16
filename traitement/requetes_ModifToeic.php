<?php
	include("../connectbdd.php");
    $taille_toeic = 200;
    $correct = true;
    
    if(!(isset($_POST["id_sujet"]))){
    	header("Location: ../accueil.php"); //cas pas normal (accès directement par le lien)
        exit;
    }

    //On test si toutes les quesitons ont été envoyées et elles ont une valeur normale
    for ($i=1 ; $i <= $taille_toeic ; $i++) {
        if(!(isset($_POST['question'.strval($i)]) or !($_POST['question'.strval($i)] == "A" or $_POST['question'.strval($i)] == "B" or $_POST['question'.strval($i)] == "C" or $_POST['question'.strval($i)] == "D"))){
        	$correct = false;
        }
    }
    
    //On met à jour dans la BDD
    if($correct){
    	for ($i=1 ; $i <= $taille_toeic ; $i++){
			if($requete = $bdd->prepare("UPDATE question SET question.reponse = ? WHERE question.id_sujet = ? AND question.num_question = ?")){
				$requete->bind_param('sii', $_POST['question'.strval($i)] , $_POST["id_sujet"] , $i );
				$requete->execute();
			}
		}	    	
		header("Location: ../gererToeic.php?Modif=1#e"); // Cas ou c'est bon
		exit;
    }
    else{
    	header("Location: ../gererToeic.php?Modif=0#e"); // cas ou les valeurs sont pas correctes
		exit;
    }
    $bdd->close();
?>