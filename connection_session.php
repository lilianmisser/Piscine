<!DOCTYPE html>
<html>
<head>
	<title>Connection session toeic</title>
</head>
<body>
	Veuillez insérez le nom de la session à laquelle vous souhaitez participer : 
	<br>
	<strong>
	<?php
    if( isset($_GET["erreur"]) ) {
        echo htmlspecialchars($_GET["erreur"]);
    }
    ?>
	</strong>
    <br>
	<form method="post" action= "traitement_connexion_session.php">
	<br>
    Nom sujet toeic
    <br>
    <input type = "text" name = "nom_sujet" />
    <br>
	<input type = "submit" value = "Valider" />
 	</form>
</body>
</html>