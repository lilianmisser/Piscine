<?php
	$errSujetAjoutUtilisee='none';
	$errSujetAjoutManquant='none';
	$errQuest='none';
	$succesAjout='none';
	

	if(isset($_GET["errQt"])){
		if($_GET["errQt"]==1){
			$errQuest='block';
		}
	}

	if(isset($_GET["errSujetAjout"])){
		if($_GET["errSujetAjout"]==1){
			$errSujetAjoutManquant='block';

		}
		if($_GET["errSujetAjout"]==2){
			$errSujetAjoutUtilisee='block';
		}
	}
	if(isset($_GET["succesAjout"]) && $_GET["succesAjout"]==1){
		$succesAjout='block';
	}
	?>

<div class="container">
	<form method="post" action="traitement/traitement_nouveau_toeic.php">
		<div class="form-group col-lg-6">
			<label for="nom">Nom du sujet</label>
			<input name=nom_sujet type="text" class="form-control" id="nom" required>
			<div class=invalid-feedback style="display:<?php echo($errSujetAjoutUtilisee); ?>;">
					Nom déjà utilisée
			</div>
			<div class=invalid-feedback style="display:<?php echo($errSujetAjoutManquant); ?>;">
					Choisissez un nom de sujet
			</div>
		</div>

		<div class="row" style="display:flex;text-align:center;">
			<div class="form-group col-lg-6	">
				<h4>Listening</h4>
				<div class=repQuest>
					<?php
					if(isset($_GET["recupVal"]) && $_GET["recupVal"]==1) {
						for($i=1 ; $i <= 100 ; $i++){
							$a='';
							$b='';
							$c='';
							$d='';
							if($_POST["q".$i.""]=='A'){
								$a='checked';
							}elseif($_POST["q".$i.""]=='B'){
								$b='checked';
							}elseif($_POST["q".$i.""]=='C'){
								$c='checked';
							}else{
								$d='checked';
							}
							echo '
							<div class="form-group row questions" style="display:flex;margin-right:0px;margin-left:0px;">
								<label style="display:inline-block;" class="col-sm-2 col-form-label col-form-label-sm">Q',$i,'</label>
								<div style="display:inline-block" class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="question',$i,'" id="grp',$i,'A" value=A ',$a,' required>
									<label class="form-check-label col-form-label" for="grp',$i,'A">A</label>
								</div>
								<div style="display:inline-block" class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="question',$i,'" id="grp',$i,'B" value=B ',$b,' required>
									<label class="form-check-label col-form-label" for="grp',$i,'B">B</label>
								</div>
								<div style="display:inline-block" class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="question',$i,'" id="grp',$i,'C" value=C ',$c,' required>
									<label class="form-check-label col-form-label" for="grp',$i,'C">C</label>
								</div>
								<div style="display:inline-block" class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="question',$i,'" id="grp',$i,'D" value=D ',$d,' required>
									<label class="form-check-label col-form-label" for="grp',$i,'D">D</label>
								</div>
							</div>';
						}
					}else{
						for($i=1 ; $i <= 100 ; $i++){
							echo '
							<div class="form-group row questions" style="display:flex;margin-right:0px;margin-left:0px;">
								<label style="display:inline-block;" class="col-sm-2 col-form-label col-form-label-sm">Q',$i,'</label>
								<div style="display:inline-block" class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="question',$i,'" id="grp',$i,'A" value=A checked required>
									<label class="form-check-label col-form-label" for="grp',$i,'A">A</label>
								</div>
								<div style="display:inline-block" class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="question',$i,'" id="grp',$i,'B" value=B required>
									<label class="form-check-label col-form-label" for="grp',$i,'B">B</label>
								</div>
								<div style="display:inline-block" class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="question',$i,'" id="grp',$i,'C" value=C required>
									<label class="form-check-label col-form-label" for="grp',$i,'C">C</label>
								</div>
								<div style="display:inline-block" class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="question',$i,'" id="grp',$i,'D" value=D required>
									<label class="form-check-label col-form-label" for="grp',$i,'D">D</label>
								</div>
							</div>';
					}
				}
					?>
				</div>
			</div>

			<div class="form-group col-lg-6">
				<h4>Reading</h4>
				<div class=repQuest>
					<?php
					if(isset($_GET["recupVal"]) && $_GET["recupVal"]==1) {
						for($i=101 ; $i <= 200 ; $i++){
							$a='';
							$b='';
							$c='';
							$d='';
							if($_POST["q".$i.""]=='A'){
								$a='checked';
							}elseif($_POST["q".$i.""]=='B'){
								$b='checked';
							}elseif($_POST["q".$i.""]=='C'){
								$c='checked';
							}else{
								$d='checked';
							}
							echo '
							<div class="form-group row questions" style="display:flex;margin-right:0px;margin-left:0px;">
								<label style="display:inline-block;" class="col-sm-2 col-form-label col-form-label-sm">Q',$i,'</label>
								<div style="display:inline-block" class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="question',$i,'" id="grp',$i,'A" value=A ',$a,' required>
									<label class="form-check-label col-form-label" for="grp',$i,'A">A</label>
								</div>
								<div style="display:inline-block" class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="question',$i,'" id="grp',$i,'B" value=B ',$b,' required>
									<label class="form-check-label col-form-label" for="grp',$i,'B">B</label>
								</div>
								<div style="display:inline-block" class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="question',$i,'" id="grp',$i,'C" value=C ',$c,' required>
									<label class="form-check-label col-form-label" for="grp',$i,'C">C</label>
								</div>
								<div style="display:inline-block" class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="question',$i,'" id="grp',$i,'D" value=D ',$d,' required>
									<label class="form-check-label col-form-label" for="grp',$i,'D">D</label>
								</div>
							</div>';
						}
					} else{
						for($i=101 ; $i <= 200 ; $i++){
							echo '
							<div class="form-group row questions" style="display:flex;margin-right:0px;margin-left:0px;">
								<label style="display:inline-block;" class="col-sm-2 col-form-label col-form-label-sm">Q',$i,'</label>
								<div style="display:inline-block" class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="question',$i,'" id="grp',$i,'A" value=A checked required>
									<label class="form-check-label col-form-label" for="grp',$i,'A">A</label>
								</div>
								<div style="display:inline-block" class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="question',$i,'" id="grp',$i,'B" value=B required>
									<label class="form-check-label col-form-label" for="grp',$i,'B">B</label>
								</div>
								<div style="display:inline-block" class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="question',$i,'" id="grp',$i,'C" value=C required>
									<label class="form-check-label col-form-label" for="grp',$i,'C">C</label>
								</div>
								<div style="display:inline-block" class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="question',$i,'" id="grp',$i,'D" value=D required>
									<label class="form-check-label col-form-label" for="grp',$i,'D">D</label>
								</div>
							</div>';
					}
				}
					?>
				</div>
			</div>
			<div class=invalid-feedback style="display:<?php echo($errQuest); ?>;">
					Une réponse n'a pas été sélectionnée
			</div>
		</div>
		<button class="btn btn-dark" type = "submit" value = "Valider">Valider</button>
	</form>
	<h4 style='padding-bottom:5%;padding-top:5%;color:green;display:<?php echo($succesAjout); ?>'>Sujet ajouté !</h4>
</div>