<?php
	include("../connectbdd.php");
	include("getResult.php");
	if(!(isset($_POST["newMail"]) AND isset($_POST["oldMail"]))) {
		header("Location: ../accueil");
        exit;
	}else{
		session_start();
		$session=$_SESSION["user_id"];
		$ancien=$_POST["oldMail"];
		$nv=$_POST["newMail"];
		if($requete = $bdd->prepare('SELECT mail FROM compte WHERE id_compte = ?')){
            $requete->bind_param("i",$session);
            $requete->execute();
            $testMail=get_result($requete);
            if($ancien!=$testMail[0]["mail"]){
                header("Location: ../monCompte.php?chgtMail=0#mail");
        		exit;
        	}else{
        		if(!preg_match("/[\w.]+@etu\.umontpellier\.fr$/",$nv)) {
        			header("Location: ../monCompte.php?chgtMail=1#mail");
        			exit;
        		}elseif($requete = $bdd->prepare("UPDATE compte SET mail = ? WHERE id_compte = ?")){
					$requete->bind_param('si',$nv,$session);
					$requete->execute();
					header("Location: ../monCompte.php?chgtMail=2#mail");
        			exit;
        	}
	}
}
}