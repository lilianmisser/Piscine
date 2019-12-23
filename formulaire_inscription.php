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
			<option value="IG3">IG3</option>
			<option value="IG4">IG4</option>
			<option value="IG5">IG5</option>
			<option value="MEA3">MEA3</option>
			<option value="MEA4">MEA4</option>
			<option value="MEA5">MEA5</option>
			<option value="GBA3">GBA3</option>
			<option value="GBA4">GBA4</option>
			<option value="GBA5">GBA5</option>
			<option value="MI3">MI3</option>
			<option value="MI4">MI4</option>
			<option value="MI5">MI5</option>
			<option value="STE3">STE3</option>
			<option value="STE4">STE4</option>
			<option value="STE5">STE5</option>
			<option value="PEIP1">PEIP1</option>
			<option value="PEIP2">PEIP2</option>
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