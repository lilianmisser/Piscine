<?php
	session_start();
	if(!(isset($_SESSION['user_id']))){
		header("Location: index.php");
		exit;
	}
	include("connectbdd.php");
	if($requete = $bdd->prepare("SELECT est_admin FROM compte WHERE compte.id_compte = ?")){
		$requete->bind_param("i",$_SESSION["user_id"]);
		$requete->execute();
		$requete->store_result();
		$requete->bind_result($admin);
		$requete->fetch();
	}
	?>

<html>
<head>
	<link rel=stylesheet href=css/bootstrap.css type=text/css>
	<link rel=stylesheet href=css/format.css type=text/css>
	<link rel=stylesheet href=css/monCompte.css type=text/css>
	<title>Mon Compte</title>
</head>
<body>
	<?php
		if(!$admin){
			include("bandeau/bandeauUti.php");
			include("menu/menuUti.php");
		}else{
			include("bandeau/bandeauAdm.php");
			include("menu/menuAdm.php");
		}
	?>
	<div class="container tout" style="padding-top:5%">
		<div class=bordure>
			<div class=mdp id=mdp>
				<div class=banniere>
					Changer de mot de passe
				</div>
				<div class="container donnee">
						<form method=post action=traitement/traitement_nv_mdp.php>
							<div class="form-group decalage col-lg-6">
	    						<label for="mdp">Mot de passe actuel</label>
	   							<input name=oldMDP type="password" class="form-control" id="mdp">
	   						</div>
	   						<div class="form-group decalage col-lg-6">
	    						<label for="Newmdp">Nouveau mot de passe</label>
	   							<input name=newMDP type="password" class="form-control" id="Newmdp">
	   						</div>
	   						<div class=decalage>
	   							<button type=submit class="btn btn-blue">Valider</button>
	   						</div>
						</form>
						<?php
							if(isset($_GET["chgtMdp"])){

								switch($_GET["chgtMdp"]){
									case 0:
										echo '<h4 class=decalage style="padding-bottom:2%;padding-top:2%;color:red;">Mot de passe incorrect</h4>';
										break;
									case 1:
										echo '<h4 class=decalage style="padding-bottom:2%;padding-top:2%;color:red;">Mot de passe trop court !</h4>';
										break;
									case 2:
										echo '<h4 class=decalage style="padding-bottom:2%;padding-top:2%;color:green;">Mot de passe modifié !</h4>';
										break;
								}
							}
						?>
				</div>
			</div>
			<div class=mail id=mail>
				<div class=banniere>
					Changer d'adresse mail
				</div>
				<div class="container donnee" style="border-bottom:solid white;">
					<form method=post action=traitement/traitement_nv_mail.php>
							<div class="form-group decalage col-lg-6">
	    						<label for="mail">Adresse mail actuelle</label>
	   							<input name=oldMail type="email" class="form-control" id="mail">
	   						</div>
	   						<div class="form-group decalage col-lg-6">
	    						<label for="Newmail">Nouvelle adresse mail</label>
	   							<input name=newMail type="email" class="form-control" id="Newmail">
	   						</div>
	   						<div class=decalage>
	   							<button type=submit class="btn btn-blue">Valider</button>
	   						</div>
					</form>
					<?php
							if(isset($_GET["chgtMail"])){

								switch($_GET["chgtMail"]){
									case 0:
										echo '<h4 class=decalage style="padding-bottom:2%;padding-top:2%;color:red;">Adresse mail incorrecte</h4>';
										break;
									case 1:
										echo '<h4 class=decalage style="padding-bottom:2%;padding-top:2%;color:red;">Adresse mail étudiante uniquement</h4>';
										break;
									case 2:
										echo '<h4 class=decalage style="padding-bottom:2%;padding-top:2%;color:green;">Adresse mail modifiée !</h4>';
										break;
								}
							}
						?>
				</div>
			</div>
			<?php
				if($admin){
			?>
			<div class=creerAdm id=adm>
				<?php 
						$verif=true;
						if(isset($_GET["errNom"]) && isset($_GET["errPrenom"]) && isset($_GET["errMail"]) && isset($_GET["errMDP"])) {
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
							
							$errNom=$_GET["errNom"];
							$errPrenom=$_GET["errPrenom"];
							$errMail=$_GET["errMail"];
							$errMDP=$_GET["errMDP"];


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
								$prenomCS='block';
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
						}

					?>
				<div class=banniere>
					Créer un nouveau compte administrateur
				</div>
				<div class="container donnee">
					<form class="needs-validation" method="post" action="traitement/traitement_inscription.php" novalidate>
						
						<div class="form-row decalage">
							<div class="form-group col-lg-5">
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
	     					<div class="form-group col-lg-5">
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
						
						<div class="form-group col-lg-10 decalage">
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
	     							echo '<small id="passwordHelpBlock" class="form-text text-muted">Adresse mail universitaire requise
	     									</small>';
	     						}else{
	     							echo '<div class=invalid-feedback style="display:',$mailRequis,';">
											Champs requis
										</div>
										<div class=invalid-feedback style="display:',$mailEtud,';">
											Adresse mail universitaire requise
										</div>
										<div class=invalid-feedback style="display:',$mailUtilisee,';">
											Adrese mail déjà utilisée
										</div>';
	     						}
	     					?>
						</div>
						<div class="form-group col-lg-10 decalage">
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
						<div class=decalage>
	   							<button name=creationAdm type=submit class="btn btn-blue" value=compteAdm>Valider</button>
	   					</div>
	   					<?php
	   						if(isset($_GET["successAdm"]) && $_GET["successAdm"]==1){
	   							echo '<h4 class=decalage style="padding-top:2%;padding-bottom:2%;color:green;">Compte créé !</h4>';
	   						}
	   					?>
					</form>
				</div>
			</div>
		<?php } ?>
	</div>
	</div>
</body>
</html>