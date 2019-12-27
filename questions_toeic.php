<?php
	session_start();
	if(!(isset($_SESSION["user_id"])) or !(isset($_POST["id_session"]))){
		header("Location: page_accueil.php");
		exit;
	}
	echo("Session : ".$_POST["id_session"]);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Réponse aux questions</title>
</head>
<body>
	<form method="post" action="correction_questions.php">
    <?php
    $taille_toeic = 200;
    for ($i=1 ; $i <= $taille_toeic ; $i++) {
        echo "Question numéro : ".$i;
        echo "\n";
	?>
    <select name="<?php echo "question".strval($i) ?>">
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
    </select>
    <br>
	<?php
    	}
	?>
	<input type="hidden" name="id_session" value="<?php echo($_POST["id_session"])?>">
	<input type = "submit" value = "Valider" />
 	</form>
</body>
</html>