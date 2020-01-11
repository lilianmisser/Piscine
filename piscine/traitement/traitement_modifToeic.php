<?php
	include("../connectbdd.php");
	include("getResult.php");

	if(!isset($_POST["nom_sujet"])){
		header("Location: ../page_accueil.php");
		exit;
	}

	if($requete = $bdd->prepare("SELECT id_sujet FROM sujet_toeic WHERE sujet_toeic.nom_sujet = ?")){
		$requete->bind_param("s",$_POST["nom_sujet"]);
		$requete->execute();
		$requete->store_result();
		$requete->bind_result($id_sujet);
		$requete->fetch();
		if($requete = $bdd->prepare("SELECT reponse FROM question WHERE question.id_sujet = ?")){
			$requete->bind_param("i",$id_sujet);
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
	Bonjour admin ! Veuillez modifier les réponses que vous souhaitez
	<br>
	<form method="post" action="requetes_ModifToeic.php">
	<?php
    $taille_toeic = 200;
    for ($i=1 ; $i <= $taille_toeic ; $i++) {
        echo "Question numéro : ".$i;
	?>
	<br>
    <input type="radio" name="<?php echo "question".strval($i) ?>" value="A" <?php if($tab[$i-1]["reponse"] == "A"){echo("checked");} ?>>A
    <input type="radio" name="<?php echo "question".strval($i) ?>" value="B" <?php if($tab[$i-1]["reponse"] == "B"){echo("checked");} ?>>B
    <input type="radio" name="<?php echo "question".strval($i) ?>" value="C" <?php if($tab[$i-1]["reponse"] == "C"){echo("checked");} ?>>C
    <input type="radio" name="<?php echo "question".strval($i) ?>" value="D" <?php if($tab[$i-1]["reponse"] == "D"){echo("checked");} ?>>D

    <br>
	<?php
    	}
	?>
	<input type="hidden" name="id_sujet" value="<?php echo($id_sujet); ?>" />
	<input type = "submit" value = "Valider" />
 	</form>
</body>
</html>
