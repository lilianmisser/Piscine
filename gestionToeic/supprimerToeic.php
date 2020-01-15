<?php
	include("connectbdd.php");

	if($requete = $bdd->prepare("SELECT id_sujet,nom_sujet FROM sujet_toeic ")){
		$requete->execute();
		$tab = get_result($requete);
	}
	$bdd->close();
	
	echo '<div  class=container style="overflow-y:scroll;max-height:27rem;">';
		for($i=0;$i<count($tab);$i++){
			if($i%2==0){
				$color="#89B4DA";
			}else{
				$color="#53A0E3";
			}
			echo '<form style="padding-top:5px;padding-bottom:5px;margin-block-end:0em;background:linear-gradient(to right,',$color,',white);" method="post" action= "traitement/traitement_suppressionToeic.php">
					<div style="display:flex;" class="row justify-content-between">
						<div class=col-4 style="padding-left:5%;">
							<h4>',$tab[$i]["nom_sujet"],'</h4>
						</div>
						<div class=col-4>
							<button name="id_sujet" value="',$tab[$i]["id_sujet"],'" class="btn btn-danger" type="submit">Supprimer</button>
						</div>
					</div>
				</form>';
			}
			?>
		</div>
		<?php
			if(isset($_GET["supp"])){
				switch($_GET["supp"]){
					case 1:
						echo '<h5 style="padding-bottom:2%;padding-top:2%;color:green;">Sujet supprimé !</h5>';
						break;
					case 0:
						echo '<h5 style="padding-bottom:2%;padding-top:2%;color:green;">Erreur, sujet non trouvé</h5>';
						break;
				}
			}
		?>

