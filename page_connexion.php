<!DOCTYPE html>
<html>
<head>
	<title>Page de connexion</title>
</head>
<body>
	<strong>
	<?php
	if( isset($_GET["erreur"]) ) {
    	echo htmlspecialchars($_GET["erreur"]);
  	}
  	?>
	</strong>

	<form method="post" action="traitement_connexion.php">
		Insérez mail
		<br>
		<input type = 'text' name = "mail"/>
		<br>
		Insérez mdp
		<br>
		<input type = 'password' name = "mdp"/>
		<input type = "submit" value="Se connecter" />
	</form>
</body>
</html>