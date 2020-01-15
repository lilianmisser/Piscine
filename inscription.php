					<?php 
						$verif=true;
						if(isset($_GET["errNom"]) && isset($_GET["errPrenom"]) && isset($_GET["errMail"]) && isset($_GET["errMDP"]) && isset($_GET["errSpe"]) && isset($_GET["errGrp"])){
							$verif=false;
							$nomRequis='none';
							$nomTropLong='none';
							$nomCS='none';
							$prenomRequis='none';
							$prenomTropLong='none';
							$prenomCS='none';
							$mailRequis='none';
							$mailEtud='none';
							$mailUtilisee='none';
							$mdpRequis='none';
							$mdpTropCourt='none';
							$speRequis='none';
							$speNV='none';
							$grpRequis='none';
							$grpNV='none';

							$errNom=$_GET["errNom"];
							$errPrenom=$_GET["errPrenom"];
							$errMail=$_GET["errMail"];
							$errMDP=$_GET["errMDP"];
							$errGrp=$_GET["errGrp"];
							$errSpe=$_GET["errSpe"];

							if($errNom==1){
								$nomRequis='block';
							}elseif($errNom==3){
								$nomTropLong='block';
							}elseif($errNom==2){
								$nomCS='block';
							}
							if($errPrenom==1){
								$prenomRequis='block';
							}elseif($errPrenom==3){
								$prenomTropLong='block';
							}elseif($errPrenom==2){
								$PrenomCS='block';
							}
							if($errMail==1){
								$mailRequis='block';
							}elseif($errMail==2){
								$mailEtud='block';
							}elseif($errMail==3){
								$mailUtilisee='block';
							}
							if($errMDP==1){
								$mdpRequis='block';
							}elseif($errMDP==2){
								$mdpTropCourt='block';
							}
							if($errGrp==1){
								$grpRequis='block';
							}elseif($errGrp==2){
								$grpNV='block';
							}
							if($errSpe==1){
								$speRequis='block';
							}elseif($errSpe==2){
								$speNV='block';
							}



						}

					?>

					<p>Inscription</p>

					<div class=container>
						<form class="needs-validation" method="post" action="traitement/traitement_inscription.php" novalidate>
						<div class=form-row>
							<div class="form-group col-lg-6">
								<label for="nom">Nom</label>
								<?php
									if(isset($_POST["nomValide"])){
										echo '<input name=nom type="text" class="form-control" id="nom" value="',$_POST["nomValide"],'"" required>';
									}else{
										echo '<input name=nom type="text" class="form-control" id="nom" required>';
									}
								?>
								
	     						<div class=invalid-feedback style="display:<?php echo($nomRequis); ?>;">
									Champs requis
								</div>
								<div class=invalid-feedback style="display:<?php echo($nomTropLong); ?>;">
									Nom trop long
								</div>
								<div class=invalid-feedback style="display:<?php echo($nomCS); ?>;">
									Pas de caractères spéciaux
								</div>
	     					</div>
	     					<div class="form-group col-lg-6">
	     						<label for="prenom">Prénom</label>
	     						<?php
									if(isset($_POST["prenomValide"])){
										echo '<input name=prenom type="text" class="form-control" id="prenom" value="',$_POST["prenomValide"],'"" required>';
									}else{
										echo '<input name=prenom type="text" class="form-control" id="prenom" required>';
									}
								?>
	     						<div class=invalid-feedback style="display:<?php echo($prenomRequis); ?>;">
									Champs requis
								</div>
								<div class=invalid-feedback style="display:<?php echo($prenomTropLong); ?>;">
									Prénom trop long
								</div>
								<div class=invalid-feedback style="display:<?php echo($prenomCS); ?>;">
									Pas de caractères spéciaux
								</div>
	     					</div>
						</div>
						<div class=form-group>
							<label for="email">Email</label>
							<?php
									if(isset($_POST["mailValide"])){
										echo '<input name=mail type="email" class="form-control" id="email" value="',$_POST["mailValide"],'"" required>';
									}else{
										echo '<input name=mail type="email" class="form-control" id="email" required>';
									}
								?>
	     					<?php 
	     						if(!(isset($_GET["errMail"])) || $_GET["errMail"]==0) {
	     							echo '<small id="passwordHelpBlock" class="form-text text-muted">Adresse mail étudiante requise
	     									</small>';
	     						}else{
	     							echo '<div class=invalid-feedback style="display:',$mailRequis,';">
											Champs requis
										</div>
										<div class=invalid-feedback style="display:',$mailEtud,';">
											Adresse mail étudiante requise
										</div>
										<div class=invalid-feedback style="display:',$mailUtilisee,';">
											Adrese mail déjà utilisée
										</div>';
	     						}
	     					?>
						</div>
						<div class=form-group>
							<label for="mdpInsc">Mot de passe</label>
							<?php
									if(isset($_POST["MDPValide"])){
										echo '<input name=mdp type="password" class="form-control" id="mdpInsc" value="',$_POST["MDPValide"],'"" required>';
									}else{
										echo '<input name=mdp type="password" class="form-control" id="mdpInsc" required>';
									}
								?>
	     					<?php 
	     						if(!(isset($_GET["errMDP"])) || $_GET["errMDP"]==0) {
	     							echo '<small id="passwordHelpBlock" class="form-text text-muted">Minimum 8 caractères, pas de caractères spéciaux
	     								</small>';
	     						}else{
	     							echo '<div class=invalid-feedback style="display:',$mdpRequis,';">
											Champs requis
										</div>
										<div class=invalid-feedback style="display:',$mdpTropCourt,';">
											Mot de passe trop court
										</div>';
	     						}
	     						?>	
						</div>

						<div class="form-group row">
							<label class="col-lg-3 col-form-label col-form-label-sm" for="spec">Spécialité</label>
							<?php
									if(isset($_POST["speValide"])){
										echo '<select name=specialite_et_annee type="text" class="custom-select col-lg-3" id="spec" value="',$_POST["speValide"],'"" required>
												<option disabled value=""></option>';
										for($i=0 ; $i < count($tab) ; $i++){
											if($tab[$i]["id_spe"]==$_POST["speValide"]){
												echo '<option selected value=',$tab[$i]["id_spe"],'>',$tab[$i]["id_spe"],'</option>';
											}else{
												echo '<option value=',$tab[$i]["id_spe"],'>',$tab[$i]["id_spe"],'</option>';
											}
										}
												echo '</select>';
									}else{
										echo '<select name=specialite_et_annee class="custom-select col-lg-3" id="spec" required="">
												<option selected disabled value=""></option>';
								
									for($i=0 ; $i < count($tab) ; $i++){
										echo '<option value=',$tab[$i]["id_spe"],'>',$tab[$i]["id_spe"],'</option>';
									}
										echo '</select>';
								
									}
								?>
								<div class=invalid-feedback style="padding-left:2%;width:auto;display:<?php echo($speRequis); ?>;">
									Champs requis
								</div>
								<div class=invalid-feedback style="padding-left:2%;width:auto;display:<?php echo($speNV); ?>;">
									Spécialité non valide
								</div>
						</div>

						<div class="form-group row">
							<?php 
								$grp1='';
								$grp2='';
								$grp3='';
								if(isset($_POST["grpValide"])){
									if($_POST["grpValide"]==1){
										$grp1='checked';
									}elseif($_POST["grpValide"]==2){
										$grp2='checked';
									}else{
										$grp3='checked';
									}
								}
								echo '
							<label class="col-sm-2 col-form-label col-form-label-sm">Groupe</label>
							<div class="form-check form-check-inline ">
								<input class="form-check-input" type="radio" name="groupe_niveau" id="grp1" value=1 ',$grp1,' required>
								<label class="form-check-label" for="grp1">1</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="groupe_niveau" id="grp2" value=2 ',$grp2,' required>
								<label class="form-check-label" for="grp2">2</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="groupe_niveau" id="grp3" value=3 ',$grp3,' required>
								<label class="form-check-label" for="grp3">3</label>
							</div>';
							?>
							<div class=invalid-feedback style="padding-left:2%;width:auto;display:<?php echo($grpRequis); ?>;">
								Champs requis
							</div>
							<div class=invalid-feedback style="padding-left:2%;width:auto;display:<?php echo($grpNV); ?>;">
								Groupe non valide
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-10">
								<button type="submit" value="S'inscrire" class="btn btn-primary">S'inscrire</button>
							</div>
						</div>
						</form>
