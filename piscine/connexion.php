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
		</div>
	</form>