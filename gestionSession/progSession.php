
<?php
	$errSujet='none';
	$errDate='none';
	$errDate2='none';
	$errGrp='none';
	$success='none';
	if(isset($_GET["errSujet"]) && isset($_GET["errDate"]) && isset($_GET["errDate2"]) && isset($_GET["errGrp"])){
		if($_GET["errSujet"]==1){
			$errSujet='block';
		}
		if($_GET["errDate"]==1){
			$errDate='block';
		}
		if($_GET["errDate2"]==1){
			$errDate2='block';
		}
		if($_GET["errGrp"]==1){
			$errGrp='block';
		}
	}
	if(isset($_GET["erreur"]) && $_GET["erreur"]=="errBDD") {
		echo '<strong>Erreur d\'accès à la base de donnée, sujet non trouvée</strong>';
	}
	if(isset($_GET["success"]) && $_GET["success"]==1){
		$success='block';
	}
?>
<div class=row>
	<div class=col-lg-8>
		<form class=needs-validation method="post" action= "traitement/traitement_newsession.php">

				<div class="banniere" style="padding-left:5%;border-radius: 0.25rem 0.25rem 0rem 0rem;">	
					<?php echo 'Sujet'; ?>
				</div>
				<div class="bordure">
					<br>
					<div class="form-group" style="padding-bottom:5px;padding-left:5%;padding-right:5%;">
						<select type=text name="nom_sujet" class="custom-select" id="sujet">
							<option selected disabled value=""></option>
							<?php
							for($i=0; $i < count($listeSujet) ; $i++){
								echo '<option value="',$listeSujet[$i]["nom_sujet"],'">',$listeSujet[$i]["nom_sujet"],'</option>';
							}
							?>
						</select>
						<div class=invalid-feedback style="display:<?php echo($errSujet); ?>;">
							Choisissez un sujet
						</div>
					</div>
				</div>

			<div class="banniere" style="padding-left:5%;">	
				<?php echo 'Date de la session'; ?>
			</div>
			<div class="bordure">
				<br>
				<div class="form-group" style="padding-bottom:5px;padding-left:5%;padding-right:5%;">									
					
					<?php
					$dateMin = date("Y-m-d");
					$mois=date("m");
					if($mois<9){
						$anneeMax=date("Y");
					}else{
						$anneeMax=date("Y")+1;
					}														
					echo '<input class="form-control" id=date type ="date" min = "',$dateMin,'" max = "',$anneeMax,'-08-31" name = "date_session">';
					?>
					<div class=invalid-feedback style="display:<?php echo($errDate); ?>;">
						Choisissez une date
					</div>
					<div class=invalid-feedback style="display:<?php echo($errDate2); ?>;">
						Choisissez une date postérieure à aujourd'hui
					</div>
				</div>
			</div>
			
			<div class="banniere" style="padding-left:5%;">	
				<?php echo 'Veuillez cocher les groupes qui vont participer à cette session :'; ?>
			</div>
			<div class="bordure" style="border-radius: 0rem 0rem 0.25rem 0.25rem;">
				<br>
				<div class="form-group" style="padding-bottom:5px;padding-left:5%;padding-right:5%;">
					<div class="choixGrp">	
						<?php 
							for($i=0; $i < count($tab) ; $i++){
								echo '<div class="form-check" style="padding-left:7%;">
								<input type="checkbox" id="grp',$i,'" name="groupes[]" class="form-check-input" value="',strval($tab[$i]["id_grp"]),'">
								<label class="form-check-label" for="grp',$i,'">',$tab[$i]["id_spe"]."-".strval($tab[$i]["num_grp"]),'</label>
								</div>';
							}
						?>
						
					</div>
					<div class=invalid-feedback style="display:<?php echo($errGrp); ?>;">
							Choisissez au moins 1 groupe
					</div>
					<br>
					<div class="text-center">
						<button class="btn btn-dark" type = "submit" value = "Valider">Valider</button>
					</div>
				</div>
			</div>
		</form>
		<h4 style='padding-top:5%;color:green;display:<?php echo($success); ?>'>Session programmée !</h4>
	</div>
</div>