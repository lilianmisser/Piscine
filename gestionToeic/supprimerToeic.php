<?php
	include("connectbdd.php");

	if($requete = $bdd->prepare("SELECT id_sujet,nom_sujet FROM sujet_toeic ")){ // on selectionne les id et les noms des toeics qui existent
		$requete->execute();
		$tab = get_result($requete);
	}
	$bdd->close();
	
	echo '<div  class=container style="overflow-y:scroll;max-height:27rem;">'; ?>
	<div class=row>
		<!-- bandeau bleu contenant le titre ci-dessous -->
		<div class="banniere" style="padding-left:5%;border-radius: 0.25rem 0.25rem 0rem 0rem;">	
			<?php echo 'Choix du nom du TOEIC à supprimer'; ?>
		</div>
	</div>
		<?php
		for($i=0;$i<count($tab);$i++){
			$color="#fff"; // couleur blanche en fond de chacune des lignes ou sont ecrits le nom des toeics existants
			echo '<div class=row style="display:flex;padding-top:1%;padding-bottom:1%">'; // display:flex permet de mettre le nom du toeic et le bouton supprimer sur la meme ligne (systeme de colonne)
			// la classe donnee permet de faire un trait bleu a gauche d'une donnee, ici le nom d'un sujet de toeic
				echo '<div class="col-4 donnee" style="padding-left:5%;">
							<h4>',$tab[$i]["nom_sujet"],'</h4>
						</div>
						<div class=col-8 style="text-align: right;padding-right:5%;">
							<form style="padding-top:5px;padding-bottom:5px;margin-block-end:0em;background:linear-gradient(to right,',$color,',white);" method="post" action= "traitement/traitement_suppressionToeic.php">
							<button name="id_sujet" value="',$tab[$i]["id_sujet"],'" class="btn btn-danger" type="submit">Supprimer</button>
						</div>
							</form>';
			echo '</div>';
			}
			?>
		</div>
		<?php
		// verifie si le sujet a bien ete supprime
			if(isset($_GET["supp"])){
				switch($_GET["supp"]){
					case 1:
						echo '<h4 style="padding-bottom:2%;padding-top:2%;color:green;">Sujet supprimé !</h4>';
						break;
					case 0:
						echo '<h4 style="padding-bottom:2%;padding-top:2%;color:green;">Erreur, sujet non trouvé</h4>';
						break;
				}
			}
		?>

