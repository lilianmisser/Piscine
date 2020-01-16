<?php
	include("connectbdd.php");
	
	//Récupère la liste des sessions programmées
	if($requete = $bdd->prepare("SELECT * FROM sujet_toeic,session,participe,groupe WHERE session.est_en_cours=0 AND session.est_fini=0 AND session.id_sujet=sujet_toeic.id_sujet AND participe.id_session=session.id_session AND participe.id_grp=groupe.id_grp ORDER BY session.date_session")){ // on recupere les sessions existantes qui n'ont pas deja ete lancees
		$requete->execute();
		$session = get_result($requete);
		}

		$bdd->close();
?>

<div style="max-height:27rem;height:auto;overflow-y:scroll;">
	<?php
		if($requete->num_rows == 0){
			echo '<h4 style="color:red;">Pas de sessions programmées</h4>';
		}else{
			for ($i=0;$i<count($session);$i++){
				if($i==0){
					echo 'Sujet : <b style="color:red;">',$session[$i]["nom_sujet"],'</b> prévu le : <b style="color:red;">',$session[$i]["date_session"],'</b> groupes : <b style="color:red;">',$session[$i]["id_spe"],'-',$session[$i]["num_grp"],'</b>'; //concatenation indiquant le sujet, la date et les groupes concernes
				}elseif($session[$i]["id_session"] != $session[$i-1]["id_session"]){
					echo '<br/>';
					echo 'Sujet : <b style="color:red;">',$session[$i]["nom_sujet"],'</b> prévu le : <b style="color:red;">',$session[$i]["date_session"],'</b> groupes : <b style="color:red;">',$session[$i]["id_spe"],'-',$session[$i]["num_grp"],'</b>';
				}else{
					echo '<b style="color:red;">; ',$session[$i]["id_spe"],'-',$session[$i]["num_grp"],'</b>';
				}

				if( ($i==count($session)-1) || ($session[$i]["id_session"] != $session[$i+1]["id_session"]))  { //regarde toutes les sessions existantes qui n'ont pas ete lancees (ni supprimees)
					// bouton Lancer une session
					echo '<form style="padding-top:2%;" method="post" action="traitement/traitement_sessions_creees.php">
							<button class="btn btn-secondary" type="submit" name="id_session" value="',$session[$i]["id_session"],'">Commencer cette session</button>
						</form>';
					// bouton supprimer
					echo '<form method="post" action="traitement/suppression_session.php">
								<button class="btn btn-secondary" type="submit" name="id_session" value="',$session[$i]["id_session"],'">Supprimer cette session</button>
						</form>';
				}
			}
}
	?>
</div>
<?php
//Message d'erreur ou de succès
if($requete->num_rows != 0){
	if(isset($_GET["sessionCommencee"]) && $_GET["sessionCommencee"]==1 ){
		echo '<h4 style="padding-bottom:2%;color:green;">Session commencée !</h4>';
	}elseif(isset($_GET["sessionCommencee"]) && $_GET["sessionCommencee"]==0){
		echo '<h4 style="padding-bottom:2%;color:red;">Session non trouvée</h4>';
	}
	if(isset($_GET["sessionSupp"]) && $_GET["sessionSupp"]==1 ){
		echo '<h4 style="padding-bottom:2%;color:green;">Session supprimée !</h4>';
	}elseif(isset($_GET["sessionSupp"]) && $_GET["sessionSupp"]==0 ){
		echo '<h4 style="padding-bottom:2%;color:red;">Session non trouvée</h4>';
	}
}


	?>



