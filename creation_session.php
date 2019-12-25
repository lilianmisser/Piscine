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

	if($requete = $bdd->prepare("SELECT id_grp,id_spe,num_grp FROM groupe")){
		$requete->execute();
		$tab = get_result($requete);
	}
	$bdd->close();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Création session</title>
</head>
<body>
	Veuillez insérez les différentes informations suivantes pour créer une session :
	<br>
	<strong>
	<?php
    if( isset($_GET["erreur"]) ) {
        echo htmlspecialchars($_GET["erreur"]);
    }
    ?>
	</strong>
    <br>
	<form method="post" action= "traitement_newsession.php">
	<br>
    Nom sujet toeic
    <br>
    <input type = "text" name = "nom_sujet" />
    <br>
    Date de la session (cette session sera valable que pour cette date) :
    <br> 
	<input type = "date" min = "2019-07-01" max = "2029-07-01" name = "date_session" />
	<br>
	Cochez les groupes qui vont participer à cette session :
	<br>
	<p>
	<?php
		for($i=0; $i < count($tab) ; $i++){
	?>
	<input type="checkbox" name="groupes[]" value="<?php echo( strval($tab[$i]["id_grp"]) ) ?>" /> <?php echo($tab[$i]["id_spe"]."-".strval($tab[$i]["num_grp"])); ?>
	<?php  
		}
	?>
	<br>
		</p>
	<input type = "submit" value = "Valider" />
 	</form>
</body>
</html>