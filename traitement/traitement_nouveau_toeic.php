<?php
	include("../connectbdd.php");
    $taille_toeic = 200;
    $i = 1; //variable test si questions cochées
    $errSujetAjout=0;
    $errQuestions=0;


    
    if(!(isset($_POST["nom_sujet"]))){
    	$errSujetAjout=1;
    }else{
        if($_POST["nom_sujet"] == "") {
            $errSujetAjout=1;
        }
        if($requete = $bdd->prepare('SELECT nom_sujet FROM sujet_toeic WHERE sujet_toeic.nom_sujet = ?')){
            $requete->bind_param("s",$_POST["nom_sujet"]);
            $requete->execute();
            $requete->store_result();
            if($requete->num_rows == 1){
                $errSujetAjout=2;
            }
        }
    }
    
    while($i<=200 && $errQuestions==0){
        if(!(isset($_POST['question'.strval($i)]) or !($_POST['question'.strval($i)] == "A" or $_POST['question'.strval($i)] == "B" or $_POST['question'.strval($i)] == "C" or $_POST['question'.strval($i)] == "D"))){
        	$errQuestions=1;
        }
        $i=$i+1;
    }


        if($errQuestions!=0){
            header("Location: ../gererToeic.php?&errQt=".$errQuestions."#z");
             exit;
        }else{
            if($errSujetAjout!=0 ){


            echo '
                    <form method="post" action="../gererToeic.php?recupVal=1&errSujetAjout=',$errSujetAjout,'#z" id="form" name="form">';
                    for ($i=1;$i<=200;$i++){
                echo '<input type="hidden" name="q',$i,'" value="',$_POST["question".strval($i).""],'">';
             }
             echo '</form>';
                  
                    echo '<script type="text/JavaScript">
                    document.getElementById("form").submit();
                    </script>';
         }else{
    if($requete = $bdd->prepare("INSERT INTO sujet_toeic (nom_sujet) VALUES (?)")){
      $requete->bind_param("s",$_POST["nom_sujet"]);
      $requete->execute();
    		if($requete->affected_rows == 1){
    			$sujetid = $requete->insert_id;
    			for ($i=1 ; $i <= $taille_toeic ; $i++){
                   if($requete = $bdd->prepare("INSERT INTO question (num_question,reponse,id_sujet) VALUES (?,?,?)")){
                      $requete->bind_param('isi', $i , $_POST["question".$i.""] , $sujetid);
                      $requete->execute();
                  }
              }	    	
          }
          header("Location: ../gererToeic.php?succesAjout=1#z");
          exit;
      }
  }
}
    $bdd->close();
?>