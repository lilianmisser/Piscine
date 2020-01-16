<?php
include("traitement/getResult.php");
	include("connectbdd.php");
	if($requete = $bdd->prepare("SELECT id_spe FROM specialite")){ // on recupere les id (ici ce sont aussi les noms) de toutes les specialites
		$requete->execute();
		$tab = get_result($requete);
	}
	$bdd->close();
?>

<html>
<head>
	<link rel=stylesheet href=css/bootstrap.css type=text/css>
	<link rel=stylesheet href=css/format.css type=text/css>
	<link rel=stylesheet href=css/gererUtilisateurs.css type=text/css>
	<title>Gestion utilisateurs</title>
</head>
<body>
	<?php
		include("bandeau/bandeauAdm.php");
		include("menu/menuAdm.php");
		?>

		<div class=container style="padding-left:5%;padding-right:5%;padding-top:5%;">
			<form id=form method=post action=traitement/gestionUti.php>
				<label style="margin-right:5%;" for=spec>Choisissez une spécialité : </label>
				<?php
				// menu deroulant avec tous les noms des specialites
				echo '<select name=spe class="custom-select col-lg-3" id="spec" required="">
														<option selected disabled value=""></option>';
					for($i=0 ; $i < count($tab) ; $i++){ ?>
						<option href=#5 value=<?php echo $tab[$i]["id_spe"],' '; if(isset($_POST["spe"]) && ($_POST["spe"]==$tab[$i]["id_spe"])){echo 'selected';}echo '>',$tab[$i]["id_spe"],'</option>';
					}
				echo '</select>';


				?>
				<button style="margin-left:5%;" type=submit class="btn btn-secondary">Valider</button>
			</form>

			<!-- UNE FOIS QU'ON A CHOISI UNE SPECIALITE -->
			<?php
			if(isset($_POST["spe"]) && !isset($_POST["compteur"])){ // si la specialite contient 0 personne (vide/null) et si une specialite a bien ete choisie
				echo '<script type="text/JavaScript">
                    document.getElementById("form").submit();
                    </script>';
			}
			if(isset($_POST["compteur"])) { ?> <!-- compteur du nombre de personnes dans la specialite choisie -->

				<div class="container" style="padding-top:5%;">
					
					<div class=row>
						<!-- on fait 3 colonnes de meme taille -->
							<div class="col-lg-4 titre">
								<?php echo 'Nom prénom'; ?>
							</div>
							<div class="col-lg-4 titre">
								<?php echo 'Adresse mail'; ?>
							</div>
							<div class="col-lg-4 titre">

							</div>
						
					</div>

					<?php
						for($i=0; $i < $_POST["compteur"]; $i++){ 
							// cette condition permet d'afficher une bande grise pour chaque groupe 1, 2 ou 3 de la specialite
							if($i==0 || ($_POST["grp".$i]!=$_POST["grp".($i-1)])) {
								echo '<div class=row>
										<div class=col-lg-12 style="padding-top:0.5%;padding-bottom:0.5%;background-color:#6c757d;color:white;text-align:center;">Groupe ',$_POST["grp".$i],'</div>
									</div>';
							}?>

							<div class="row" style="padding-top:1%;padding-bottom:1%;">
								<div class="col-lg-4 donnee"> <!-- la classe donnee affiche un trait bleu a gauche d'une donnee, ici nom prenom -->
									<?php echo strtoupper($_POST["nom".$i]),' ',$_POST["prenom".$i]; //strtoupper met le nom en maj ?> 
								</div>
								<div class="col-lg-4 donnee"> <!-- la classe donnee affiche un trait bleu a gauche d'une donnee, ici le mail de l'etudiant -->
									<?php echo ($_POST["mail".$i]); ?>
								</div>
								<!-- colonne avec le bouton supprimer -->
								<div class="col-lg-4" style="text-align: right;">
									<form method=post action=traitement/suppUti.php>
											<button name=supp class="btn btn-danger" type=submit value="<?php echo($_POST["mail".$i]); ?>">Supprimer</button>
											<input type=hidden name=spe value=<?php echo($_POST["spe"]); ?>>
									</form>
								</div>
							</div>
						<?php 
						} ?>
				</div>
			<?php
			}
			?>
		</div>

	<?php include("logo.php"); ?>

</body>
</html>