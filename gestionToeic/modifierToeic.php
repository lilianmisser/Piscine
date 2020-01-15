<?php
	include("connectbdd.php");

	if($requete = $bdd->prepare("SELECT id_sujet,nom_sujet FROM sujet_toeic ")){
		$requete->execute();
		$tab = get_result($requete);
	}
	$bdd->close();
?>


	


<div class="container">
	<form method="post" action="traitement/traitement_modifToeic.php">
		<div class="banniere" style="padding-left:5%;border-radius: 0.25rem 0.25rem 0rem 0rem;">	
				<?php echo 'Choix du nom du TOEIC à modifier'; ?>
		</div>
		<div class="bordure" style="border-radius: 0rem 0rem 0.25rem 0.25rem;">
			<br>
			<div class="form-group col-lg-6">
				<select name="id_sujet">
			<?php
				for($i=0;$i<count($tab);$i++){
			?>
				<option value=<?php echo '"',$tab[$i]["id_sujet"],'"'; if(isset($_POST["id_sujet"]) && ($_POST["id_sujet"]==$tab[$i]["id_sujet"])){echo 'selected';}?>> <?php echo($tab[$i]["nom_sujet"]) ?> </option>
			<?php
				}
			?>
			</select>
			<input style="margin-left:15%;" class="btn btn-dark" type="submit">
			</div>
		
		</form>
				<br>
				<?php if(isset($_POST["id_sujet"])){ ?>
				<form method=post action=traitement/requetes_ModifToeic.php>
				<div class="row" style="display:flex;text-align:center;">
					<div class="form-group col-lg-6	">
						<div class=banniere style="border-radius: 0.25rem 0.25rem 0rem 0rem;"><h4>Listening</h4></div>
						<!-- <h4>Listening</h4> -->
						<div class=repQuest>
							<?php
							
								for($i=1 ; $i <= 100 ; $i++){
									$a='';
									$b='';
									$c='';
									$d='';
									if($_POST["quest".$i.""]=='A'){
										$a='checked';
									}elseif($_POST["quest".$i.""]=='B'){
										$b='checked';
									}elseif($_POST["quest".$i.""]=='C'){
										$c='checked';
									}else{
										$d='checked';
									}
									echo '
									<div class="form-group row questions" style="display:flex;margin-right:0px;margin-left:0px;">
										<label style="display:inline-block;" class="col-sm-2 col-form-label col-form-label-sm">Q',$i,'</label>
										<div style="display:inline-block" class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="question',$i,'" id="grp1" value=A ',$a,' required>
											<label class="form-check-label col-form-label" for="grp1">A</label>
										</div>
										<div style="display:inline-block" class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="question',$i,'" id="grp2" value=B ',$b,' required>
											<label class="form-check-label col-form-label" for="grp2">B</label>
										</div>
										<div style="display:inline-block" class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="question',$i,'" id="grp3" value=C ',$c,' required>
											<label class="form-check-label col-form-label" for="grp3">C</label>
										</div>
										<div style="display:inline-block" class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="question',$i,'" id="grp3" value=D ',$d,' required>
											<label class="form-check-label col-form-label" for="grp3">D</label>
										</div>
									</div>';
								}
							?>
						</div>
					</div>
					<div class="form-group col-lg-6">
						<div class=banniere style="border-radius: 0.25rem 0.25rem 0rem 0rem;"><h4>Reading</h4></div>
						<div class=repQuest>
							<?php
								for($i=101 ; $i <= 200 ; $i++){
									$a='';
									$b='';
									$c='';
									$d='';
									if($_POST["quest".$i.""]=='A'){
										$a='checked';
									}elseif($_POST["quest".$i.""]=='B'){
										$b='checked';
									}elseif($_POST["quest".$i.""]=='C'){
										$c='checked';
									}else{
										$d='checked';
									}
									echo '
									<div class="form-group row questions" style="display:flex;margin-right:0px;margin-left:0px;">
										<label style="display:inline-block;" class="col-sm-2 col-form-label col-form-label-sm">Q',$i,'</label>
										<div style="display:inline-block" class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="question',$i,'" id="grp1" value=A ',$a,' required>
											<label class="form-check-label col-form-label" for="grp1">A</label>
										</div>
										<div style="display:inline-block" class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="question',$i,'" id="grp2" value=B ',$b,' required>
											<label class="form-check-label col-form-label" for="grp2">B</label>
										</div>
										<div style="display:inline-block" class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="question',$i,'" id="grp3" value=C ',$c,' required>
											<label class="form-check-label col-form-label" for="grp3">C</label>
										</div>
										<div style="display:inline-block" class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="question',$i,'" id="grp3" value=D ',$d,' required>
											<label class="form-check-label col-form-label" for="grp3">D</label>
										</div>
									</div>';
								}
						
							?>
						</div>
					</div>
				</div>
				<input type=hidden name=id_sujet value=<?php echo($_POST["id_sujet"]); ?>>
				<div style="padding-bottom: 1%;padding-left: 1%">
					<button class="btn btn-dark" type = "submit">Valider</button>
				</div>
			</form>
	
<?php } 
	if(isset($_GET["Modif"])){
		switch($_GET["Modif"]){
			case 1:
				echo '<h4 style="padding-bottom:2%;margin-left:2%;color:green;">Sujet modifiée !</h4>';
				break;
			case 0:
				echo '<h4 style="padding-bottom:2%;margin-left:2%;color:green;">Erreur sur les questions sélectionnées, veuillez recommencer</h4>';
				break;
		}
	}
?>
	</div>
</div>