<?php
	include("connectbdd.php");
	
	if($requete = $bdd->prepare("SELECT * FROM sujet_toeic,session,participe,groupe WHERE session.est_en_cours=1 AND session.est_fini=0 AND session.id_sujet=sujet_toeic.id_sujet AND participe.id_session=session.id_session AND participe.id_grp=groupe.id_grp ORDER BY session.date_session")){
		$requete->execute();
		$session = get_result($requete);
		}

		$bdd->close();
?>

<div style="max-height:27rem;height:auto;overflow-y:scroll;">
	<?php
		if($requete->num_rows == 0){
			echo '<h4 style="color:red;">Pas de session en cours</h4>';
		}else{
			for ($i=0;$i<count($session);$i++){
				if($i==0){
					echo 'Sujet : <b style="color:red;">',$session[$i]["nom_sujet"],'</b> du : <b style="color:red;">',$session[$i]["date_session"],'</b> groupes : <b style="color:red;">',$session[$i]["id_spe"],'-',$session[$i]["num_grp"],'</b>';
				}elseif($session[$i]["id_session"] != $session[$i-1]["id_session"]){
					echo '<br/>';
					echo 'Sujet : <b style="color:red;">',$session[$i]["nom_sujet"],'</b> du : <b style="color:red;">',$session[$i]["date_session"],'</b> groupes : <b style="color:red;">',$session[$i]["id_spe"],'-',$session[$i]["num_grp"],'</b>';
				}else{
					echo '<b style="color:red;">; ',$session[$i]["id_spe"],'-',$session[$i]["num_grp"],'</b>';
				}

				if( ($i==count($session)-1) || ($session[$i]["id_session"] != $session[$i+1]["id_session"]))  {
					echo '<form style="padding-top:1%;" method="post" action="traitement/traitement_sessions_en_cours.php">
							<button class="btn btn-secondary" type="submit" name="id_session" value="',$session[$i]["id_session"],'">Terminer cette session</button>
						</form>';
				}
		}
}
	?>
</div>
<?php
	if($requete->num_rows != 0){
	if(isset($_GET["sessionTerminee"]) && $_GET["sessionTerminee"]==1 ){
		echo '<h4 style="padding-bottom:2%;color:green;">Session terminée !</h4>';
	}elseif(isset($_GET["sessionTerminee"]) && $_GET["sessionTerminee"]==0){
		echo '<h4 style="padding-bottom:2%;color:red;">Session non trouvée</h4>';
	}
}

	?>