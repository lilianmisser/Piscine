<?php
	include("traitement/getResult.php");
	include("connectbdd.php");

	//Récupère la liste des spécialités dans la BDD
	if($requete = $bdd->prepare("SELECT id_spe FROM specialite")){
		$requete->execute();
		$tab = get_result($requete);
	}
	$bdd->close();
?>

<html>
<head>
	<link rel=stylesheet href=css/bootstrap.css type=text/css>
	<link rel=stylesheet href=css/index.css type=text/css>
	<link rel=stylesheet href=css/format.css type=text/css>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="Content-Type" content="text/html;charset=utf8" />
	<title>Page d'accueil</title>
</head>

<body>
	
				<!-- Bannière titre -->
	<div class="container-fluid header border-bottom border-top">
		<table class=mx-auto style="height:100px;">
			<tr>
				<td class=align-middle>
					<h1 class=titre>Entrainement TOEIC</h1>
				</td>
			</tr>
		</table>

	</div>

	<div class="container tout">
		<div class=row>
			
			<!--      CONNEXION      -->

			<div class="col-lg-6 connexion">
				<?php
					include("connexion.php");
				?>
			</div>

			
			<!--        INSCRIPTION      -->
			
			<div class="col-lg-6 inscription">
				<?php
					include("inscription.php");
				?>	
			</div>

		</div>
	</div>
	
	<?php include("logo.php"); ?>

</body>


</html>
