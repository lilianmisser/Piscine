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
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ajout sujet toeic</title>
</head>
<body>
    <a href = "page_accueil.php">Accueil</a>
    <br>
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