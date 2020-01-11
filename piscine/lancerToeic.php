<?php 
	session_start();
	include("connectbdd.php");
	$show_something = false;
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
	
	if(isset($_SESSION["user_id"])){
		if($requete = $bdd->prepare("SELECT id_grp FROM est_de_groupe WHERE est_de_groupe.id_compte = ?")){
			$requete->bind_param("i",$_SESSION["user_id"]);
			$requete->execute();
			$requete->store_result();
			$requete->bind_result($groupid);
			$requete->fetch();
			if($requete = $bdd->prepare("SELECT id_session FROM participe WHERE participe.id_grp = ?")){
				$requete->bind_param("i",$groupid);
				$requete->execute();
				$sessions = get_result($requete);
				if(count($sessions) != 0){
					$sessions_available = array();
					for($i=0;$i<count($sessions);$i++){
						if($requete = $bdd->prepare("SELECT est_en_cours,est_fini FROM session WHERE session.id_session = ?")){
							$requete->bind_param("i",$sessions[$i]["id_session"]);
							$requete->execute();
							$requete->store_result();
							$requete->bind_result($session_ready,$session_over);
							$requete->fetch();
							if($session_ready and !$session_over){
								array_push($sessions_available,$sessions[$i]["id_session"]);
							}
						}
					}
					if(count($sessions_available) != 0){
						$show_something = true;
					}
				}
			}
		}
	}
	else{
		header("Location: lancerToeic.php");
		exit;
	}
	$bdd->close();
 ?>
<!-- TO DO : vérifier si le form a bien une valeur dans la cible -->
<!DOCTYPE html>
<html>
<head>
	<title>Connection session toeic</title>
</head>
<body>
	<?php

		if($show_something){
	echo'<br>
			Voici les sessions qui vous sont disponibles
		<br>';
 //s'il y a au moins une session possible
			for($i=0;$i<count($sessions_available);$i++){
	?>
	<form method="post" action="reponseEleve/liste_Parties.php"> <!-- formulaire, lien avec le serveur web -->
		Session dispo de code : <?php echo($sessions_available[$i]) ?>
		<br>
		<input type="hidden" name="id_session" value="<?php echo($sessions_available[$i])?>">
		<input type="submit" value="Rejoindre">	<!-- submit pour bouton -->
		<br>
	</form>
	<?php
			}
		}else{
			echo "pas de sessions";
		}
	?>
</body>
</html>

