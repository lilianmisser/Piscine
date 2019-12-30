					<p>Inscription</p>

					<div class=container>
						<form class="needs-validation" method="post" action="traitement/traitement_inscription.php" novalidate>
						<div class=form-row>
							<div class="form-group col-lg-6">
								<label for="nom">Nom</label>
	     						<input name=nom type="text" class="form-control" id="nom" required>
	     					</div>
	     					<div class="form-group col-lg-6">
	     						<label for="prenom">Prénom</label>
	     						<input name=prenom type="text" class="form-control" id="prenom" required >
	     					</div>
						</div>
						<div class=form-group>
							<label for="email">Email</label>
	     					<input name=mail type="email" class="form-control" id="email" required>
	     					<small id="passwordHelpBlock" class="form-text text-muted">Adresse mail étudiante requise
	     					</small>
						</div>
						<div class=form-group>
							<label for="mdpInsc">Mot de passe</label>
	     					<input name=mdp type="password" class="form-control" id="mdpInsc" required>
	     					<small id="passwordHelpBlock" class="form-text text-muted">Minimum 8 caractères, pas de caractères spéciaux
	     					</small>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label col-form-label-sm" for="spec">Spécialité</label>
							<select name=specialite_et_annee class="custom-select col-lg-3" id="spec" required="">
								<option selected disabled value=""></option>
								<?php 
									for($i=0 ; $i < count($tab) ; $i++){
										echo '<option value=',$tab[$i]["id_spe"],'>',$tab[$i]["id_spe"],'</option>';
									}
								?>
							</select>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 col-form-label col-form-label-sm">Groupe</label>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="groupe_niveau" id="grp1" value=1 required>
								<label class="form-check-label" for="grp1">1</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="groupe_niveau" id="grp2" value=2 required>
								<label class="form-check-label" for="grp2">2</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="groupe_niveau" id="grp3" value=3 required>
								<label class="form-check-label" for="grp3">3</label>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-10">
								<button type="submit" value="S'inscrire" class="btn btn-primary">S'inscrire</button>
							</div>
						</div>
						</form>
					

					<script>
						//script bootstrap pour verification inscription
						(function() {
							'use strict';
							window.addEventListener('load', function() {
							    var forms = document.getElementsByClassName('needs-validation');
							    var validation = Array.prototype.filter.call(forms, function(form) {
									form.addEventListener('submit', function(event) {
									if (form.checkValidity() === false) {
										event.preventDefault();
										event.stopPropagation();
							        }
									form.classList.add('was-validated');
									}, false);
								});
							}, false);
						})();
					</script>
					</div>
