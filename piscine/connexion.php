<?php
	$mailIncorrect='none';
	$MDPIncorrect='none';
	$erreur='none';
	$champsRequis='none';
	if(isset($_GET["erreurConnexion"])){
		if($_GET["erreurConnexion"]==1){
			$mailIncorrect='block';
		}elseif($_GET["erreurConnexion"]==2){
				$MDPIncorrect='block';
		}elseif($_GET["erreurConnexion"]==3){
				$erreur='block';
		}elseif($_GET["erreurConnexion"]==4){
			$champsRequis='block';
		}
	}

	
?>


<p>Se connecter</p>
	<form method="post" action="traitement/traitement_connexion.php">
		<div class=container>
			<div class='form-group'>
				<label for="mailConnec">Adresse mail</label>
				<input name=mail type="email" id="mailConnec" class="form-control" aria-describedby="emailHelp">
			</div>
			<div class='form-group'>
				<label for="pwd">Mot de passe</label>
				<input name=mdp type="password" id="pwd" class="form-control" aria-describedby="passwordHelpBlock">
			</div>
			<div class="form-group row">
				<div class="col-sm-10">
					<button type="submit" value="Se connecter" class="btn btn-primary">Se connecter</button>
				</div>
			</div>
			<div class=invalid-feedback style="display:<?php echo($mailIncorrect); ?>;">
				Adresse mail incorrecte
			</div>
			<div class=invalid-feedback style="display:<?php echo($MDPIncorrect	); ?>;">
				Mot de passe incorrect
			</div>
			<div class=invalid-feedback style="display:<?php echo($erreur); ?>;">
				Erreur
			</div>
			<div class=invalid-feedback style="display:<?php echo($champsRequis); ?>;">
				Adresse mail et mot de passe requis
			</div>
		</div>
	</form>