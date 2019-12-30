<?php
	session_start();
	if(!(isset($_SESSION['user_id']))){
		header("Location: index.php");
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
?>


<html>
<head>
	<link rel=stylesheet href=css/bootstrap.css type=text/css>
	<link rel=stylesheet href=css/format.css type=text/css>
	<link rel=stylesheet href=css/accueil.css type=text/css>
	<title>Accueil</title>
</head>
<body>
	<?php
	if(!$admin){
		include("bandeau/bandeauUti.php");
		include("menu/menuUti.php");
	}else{
		include("bandeau/bandeauAdm.php");
		include("menu/menuAdm.php");
	} 
	?>
	
	<div class="container centre">
		<h1>Bienvenue sur entrainement Toeic</h1>
		<img src="image/polytech.jpg" width=50% alt="Responsive image">
	</div>


	<?php include("logo.php"); ?>
</body>''
</html>