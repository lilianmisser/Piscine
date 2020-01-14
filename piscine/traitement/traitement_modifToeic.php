<?php
	include("../connectbdd.php");
	include("getResult.php");

	if(!isset($_POST["id_sujet"])){
		header("Location: ../accueil.php");
		exit;
	}

	if($requete = $bdd->prepare("SELECT id_sujet,nom_sujet FROM sujet_toeic WHERE sujet_toeic.id_sujet = ?")){
		$requete->bind_param("s",$_POST["id_sujet"]);
		$requete->execute();
		$id_sujet=get_result($requete);
		if($requete = $bdd->prepare("SELECT reponse FROM question WHERE question.id_sujet = ?")){
			$requete->bind_param("i",$id_sujet[0]["id_sujet"]);
			$requete->execute();
			$tab = get_result($requete);
		}
	}
	$bdd->close();
?>


<!DOCTYPE html>
<html>
<head>
	<title>Modifier TOEIC</title>
</head>
<body>
	<?php
     echo '
                    <form method="post" action="../gererToeic.php#e" id="form" name="form">';
                    for ($i=1;$i<=200;$i++){
                echo '<input type="hidden" name="quest',$i,'" value="',$tab[$i-1]["reponse"],'">';
             }
             echo '<input type="hidden" name="id_sujet" value="',$id_sujet[0]["id_sujet"],'">';
             echo '</form>';
                  
                    echo '<script type="text/JavaScript">
                    document.getElementById("form").submit();
                    </script>';
    	
	?>
	<input type="hidden" name="id_sujet" value="<?php echo($id_sujet["id_sujet"]); ?>" />
	<input type = "submit" value = "Valider" />
 	</form>
</body>
</html>
