<?php
	include("connectbdd.php");

	if($requete = $bdd->prepare("SELECT id_sujet,nom_sujet FROM sujet_toeic ")){
		$requete->execute();
		$tab = get_result($requete);
	}
	$bdd->close();
	
	echo '<div  class=container style="overflow-y:scroll;max-height:27rem;">'; ?>
	<div class=row>
		<div class="banniere" style="padding-left:5%;border-radius: 0.25rem 0.25rem 0rem 0rem;">	
			<?php echo 'Choix du nom du TOEIC à supprimer'; ?>
		</div>
	</div>
		<?php
		for($i=0;$i<count($tab);$i++){
			$color="#fff";
			echo '<div class=row style="display:flex;padding-top:1%;padding-bottom:1%">';
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

