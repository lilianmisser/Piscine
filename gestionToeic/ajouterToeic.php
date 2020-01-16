<?php
	$errSujetAjoutUtilisee='none';
	$errSujetAjoutManquant='none';
	$errQuest='none';
	$succesAjout='none';
	
    // GESTION D'ERREUR
	if(isset($_GET["errQt"])){ // isset retourne true si ce qu'elle contient existe et est different de NULL
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
		<!-- TITRE DU SUJET -->
		<!-- la classe banniere affiche la bande bleue contenant un titre -->
		<div class="banniere" style="padding-left:5%;border-radius: 0.25rem 0.25rem 0rem 0rem;">	
			<?php echo 'Nom du sujet'; ?>
		</div>
		<!-- la classe bordure affiche un cadre bleu, border-radius arrondit les angles du cadre -->
		<div class="bordure" style="border-radius: 0rem 0rem 0.25rem 0.25rem;">
			<br> <!-- saut de ligne -->
			<!-- création du formulaire dans lequel on ecrit un nom pour le nouveau sujet -->
			<div class="form-group col-lg-12">
				<input name=nom_sujet type="text" class="form-control" id="nom" required>
				<div class=invalid-feedback style="display:<?php echo($errSujetAjoutUtilisee); ?>;">
						Nom déjà utilisée
				</div>
				<div class=invalid-feedback style="display:<?php echo($errSujetAjoutManquant); ?>;">
						Choisissez un nom de sujet
				</div>
			</div>

		<!-- QUESTIONS A REMPLIR POUR LE SUJET -->
		<div class="row" style="display:flex;text-align:center;">
			<!-- création d'une colonne pour LISTENING prenant la moitie de l'espace (6/12) -->
			<div class="form-group col-lg-6">
					<div class=banniere style="border-radius: 0.25rem 0.25rem 0rem 0rem;"><h4>Listening</h4></div> <!-- titre listening dans le bandeau bleu -->

				<div class=repQuest>
					<?php
					if(isset($_GET["recupVal"]) && $_GET["recupVal"]==1) {
						for($i=1 ; $i <= 100 ; $i++){ // pour chanque reponse on regarde ce qui est coche
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

			<!-- création d'une colonne pour LISTENING prenant la moitie de l'espace (6/12) -->
			<div class="form-group col-lg-6">
				<div class=banniere style="border-radius: 0.25rem 0.25rem 0rem 0rem;"><h4>Reading</h4></div>
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
		<!-- BOUTON -->
		<div style="padding-bottom: 1%;padding-left: 1%;">
			<button class="btn btn-dark" type = "submit" value = "Valider">Valider</button>
		</div>
		
		</div>
	</form>
	<h4 style='padding-bottom:5%;padding-top:5%;color:green;display:<?php echo($succesAjout); ?>'>Sujet ajouté !</h4>
</div>