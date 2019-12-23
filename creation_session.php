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
	<input type = "submit" value = "Valider" />
 	</form>
</body>
</html>