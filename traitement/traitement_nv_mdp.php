<?php
	include("../connectbdd.php");
	include("getResult.php");
	if(!(isset($_POST["newMDP"]) AND isset($_POST["oldMDP"]))) {
		header("Location: ../accueil");
        exit;
	}else{
		session_start();
		$session=$_SESSION["user_id"];
		$ancien=$_POST["oldMDP"];
		$nv=$_POST["newMDP"];
		if($requete = $bdd->prepare('SELECT mdp FROM compte WHERE id_compte = ?')){
            $requete->bind_param("i",$session);
            $requete->execute();
            $testMDP=get_result($requete);
            if(!password_verify($ancien,$testMDP[0]["mdp"])){
                header("Location: ../monCompte.php?chgtMdp=0#mdp");
        		exit;
        	}else{
        		if(strlen($nv)<=7){
        			header("Location: ../monCompte.php?chgtMdp=1#mdp");
        			exit;
        		}elseif($requete = $bdd->prepare("UPDATE compte SET mdp = ? WHERE id_compte = ?")){
        			$nv=password_hash($nv,PASSWORD_DEFAULT);
					$requete->bind_param('si',$nv,$session);
					$requete->execute();
					header("Location: ../monCompte.php?chgtMdp=2#mdp");
        			exit;
        	}
	}
}
}