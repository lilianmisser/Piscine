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
				array_push($sessions_running , $i);
			}
			elseif(!$sessions[$i]["est_en_cours"] and !$sessions[$i]["est_fini"]){
				array_push($sessions_just_created,$i);
			}
		}
	}
	//Je récupérer l'indice dans deux listes des sessions qui m'intéressent car grâce à l'indice je peut accéder à toutes les informations qui m'intéressent;
	#TO DO : recuperation des sessions juste crées et de celles en cours, il faut maintenant les traiter
	#Changer les echo \n ça fonctionne pas 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestion des sessions</title>
</head>
<body>
	Sessions en cours :
	<br>
	<?php
		for($i=0;$i<count($sessions_running);$i++){
			echo("Session d'id : ".$sessions[$sessions_running[$i]]["id_session"]);
			echo("\n");
			echo("D'id sujet : ".$sessions[$sessions_running[$i]]["id_sujet"]);
			echo("\n");
			echo("Prévu le : ".$sessions[$sessions_running[$i]]["date_session"]);
			echo("\n");
	?>
	<form method="post" action="traitement_sessions_en_cours.php">
		<input type="hidden" name="id_session" value="<?php echo($sessions[$sessions_running[$i]]["id_session"])?>">
		<input type="submit" value="Finir cette session">
	</form>
	<?php
		}
	?>
	<br>
	Sessions à traiter :
	<br>
	<?php
		for($i=0;$i<count($sessions_just_created);$i++){
			echo("Session d'id : ".$sessions[$sessions_just_created[$i]]["id_session"]);
			echo("\n");
			echo("D'id sujet : ".$sessions[$sessions_just_created[$i]]["id_sujet"]);
			echo("\n");
			echo("Prévu le : ".$sessions[$sessions_just_created[$i]]["date_session"]);
			echo("\n");
	?>
	<form method="post" action="traitement_sessions_creees.php">
		<input type="hidden" name="id_session" value="<?php echo($sessions[$sessions_just_created[$i]]["id_session"])?>">
		<input type="submit" value="Lancer la session">
	</form>
	<form method="post" action="suppression_session.php">
		<input type="hidden" name="id_session" value="<?php echo($sessions[$sessions_just_created[$i]]["id_session"])?>">
		<input type="submit" value="Supprimer cette session">
	</form>
	<?php } ?>
</body>
</html>