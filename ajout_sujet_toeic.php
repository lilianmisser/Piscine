<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	Bonjour admin ! Veuillez rentrer un nom et toutes les réponses à votre sujet toeic pour en créer un nouveau.
	<br>
    <strong>
    <?php
    if( isset($_GET["erreur"]) ) {
        echo htmlspecialchars($_GET["erreur"]);
    }
    ?>
    </strong>
    <br>
	<form method="post" action="traitement_nouveau_toeic.php">
	<br>
    Nom sujet toeic :
    <br>
    <input type = "text" name = "nom_sujet" />
    <br>
    <br>
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
	<input type = "submit" value = "Valider" />
 	</form>
</body>
</html>