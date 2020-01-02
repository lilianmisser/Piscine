<?php
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
	$taille_toeic = 200;
	session_start();
	include("connectbdd.php");
    if(!(isset($_SESSION["user_id"])) or !(isset($_POST["id_session"])) ){
		header("Location: page_accueil.php");
		exit;
	}



    for ($i=1 ; $i <= $taille_toeic ; $i++) {
        if(!(isset($_POST['question'.strval($i)]) or !($_POST['question'.strval($i)] == "A" or $_POST['question'.strval($i)] == "B" or $_POST['question'.strval($i)] == "C" or $_POST['question'.strval($i)] == "D" or $_POST['question'.strval($i)] == "null"))){
        	header("Location: questions_toeic.php");
        	exit;
        }
    }


    if($requete = $bdd->prepare("SELECT id_sujet FROM session WHERE session.id_session = ?")){
    	$requete->bind_param("i",$_POST["id_session"]);
    	$requete->execute();
    	$requete->store_result();
    	$requete->bind_result($sujetid);
    	$requete->fetch();
    	if($requete = $bdd->prepare("SELECT reponse FROM question WHERE question.id_sujet = ?")){
    		$requete->bind_param("i",$sujetid);
    		$requete->execute();
    		$reponses = get_result($requete);
    		$num_question = 0;
    		$score = array(0,0,0,0,0,0,0);
    		$lenght = array(6,25,39,30,30,16,54);
    		for($i=0 ; $i<count($lenght) ; $i++){
    			for($j=0 ; $j < ($lenght[$i]) ; $j++){
    				if($_POST["question".strval($num_question + 1)] == $reponses[$num_question]["reponse"]){
    					$score[$i] += 1;
    				}
    				$num_question += 1;
    			}
    		}
    		for($i=1 ; $i<= count($lenght) ; $i++){
    			if($requete = $bdd->prepare("INSERT INTO sous_partie (num_sp,note_sp,id_compte,id_session) VALUES (?,?,?,?)")){
    				$requete->bind_param("iiii",$i,$score[$i-1],$_SESSION["user_id"],$_POST["id_session"]);
    				$requete->execute();
    			}
    		}
    	}
    }
    
    $bdd->close();	
?>