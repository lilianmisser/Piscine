<?php
	include("../connectbdd.php");
    $taille_toeic = 200;
    $correct = true;
    
    if(!(isset($_POST["id_sujet"]))){
    	header("Location: page_accueil.php"); //cas pas normal (accès directement par le lien)
        exit;
    }

    for ($i=1 ; $i <= $taille_toeic ; $i++) {
        if(!(isset($_POST['question'.strval($i)]) or !($_POST['question'.strval($i)] == "A" or $_POST['question'.strval($i)] == "B" or $_POST['question'.strval($i)] == "C" or $_POST['question'.strval($i)] == "D"))){
        	$correct = false;
        }
    }
    
    if($correct){
    	for ($i=1 ; $i <= $taille_toeic ; $i++){
			if($requete = $bdd->prepare("UPDATE question SET question.reponse = ? WHERE question.id_sujet = ? AND question.num_question = ?")){
				$requete->bind_param('sii', $_POST['question'.strval($i)] , $_POST["id_sujet"] , $i );
				$requete->execute();
			}
		}	    	
		header("Location: gererToeic.php"); // Cas ou c'est bon
		exit;
    }
    else{
    	header("Location: traitement_modifToeic.php"); // cas ou les valeurs sont pas correctes
		exit;
    }
    $bdd->close();
?>