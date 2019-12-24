<?php
	include("connectbdd.php");
	
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

	if($requete = $bdd->prepare("SELECT id_spe FROM specialite")){
		$requete->execute();
		$tab = get_result($requete);
	}
	$bdd->close();	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Formulaire d'inscription</title>
</head>
<body>
	<strong>
	<?php
  	if( isset($_GET["erreur"]) ) {
    	echo htmlspecialchars($_GET["erreur"]);
  	}
	?>
	</strong>

	<form method="post" action="traitement_inscription.php">
		Insérez nom
		<br>
		<input type = 'text' name = "nom"/>
		<br>
		Insérez prénom
		<br>
		<input type = 'text' name = "prenom"/>
		<br>
		Insérez mail
		<br>
		<input type = 'text' name = "mail"/>
		<br>
		Insérez specialite et année
		<br>
		<select name="specialite_et_annee">
			<?php
				for($i=0 ; $i < count($tab) ; $i++){
			?>
			<option value="<?php echo($tab[$i]["id_spe"]) ?>"><?php echo($tab[$i]["id_spe"]); ?></option>
			<?php
				}
			?>
		</select>
		<br>
		Insérez mdp
		<br>
		<input type = 'password' name = "mdp"/>
		<br>
		Insérez groupe de niveau
		<br>
		<select name = "groupe_niveau">
			<option value=1>1</option>
			<option value=2>2</option>
		</select>
		<br>
		<input type="submit" value="S'inscrire" />
	</form>
</body>
</html>