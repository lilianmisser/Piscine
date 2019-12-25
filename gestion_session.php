<?php
	include("connectbdd.php");
	session_start();
	if(!(isset($_SESSION['user_id']))){
		header("Location: page_connexion.php");
		exit;
	}
	include("connectbdd.php");
	if($requete = $bdd->prepare("SELECT est_admin FROM compte WHERE compte.id_compte = ?")){
		$requete->bind_param("i",$_SESSION["user_id"]);
		$requete->execute();
		$requete->store_result();
		$requete->bind_result($admin);
		$requete->fetch();
	}
	if(!$admin){
		header("Location: page_accueil.php");
		exit;
	}

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

	if($requete =$bdd->prepare("SELECT * FROM session")){
		$requete->execute();
		$sessions = get_result($requete);
		$sessions_just_created = array();
		$sessions_running = array();
		for($i=0;$i<count($sessions);$i++){
			if($sessions[$i]["est_en_cours"] and !$sessions[$i]["est_fini"]){
				array_push($sessions_running , $sessions[$i]["id_session"]);
			}
			elseif(!$sessions[$i]["est_en_cours"] and !$sessions[$i]["est_fini"]){
				array_push($sessions_just_created,$sessions[$i]["id_session"]);
			}
		}
	}
	var_dump($sessions_running);
	print_r($sessions_just_created);
	#TO DO : recuperation des sessions juste crées et de celles en cours, il faut maintenant les traiter
?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestion des sessions</title>
</head>
<body>

</body>
</html>