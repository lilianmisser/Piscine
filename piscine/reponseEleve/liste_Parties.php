<!-- listes des parties d'un toeic, pensera faire le lien avec question_toeic a chaque fois-->

<!DOCTYPE html>
<html>
    <head>
    	<link rel=stylesheet href=../css/bootstrap.css type=text/css>
		<link rel=stylesheet href=../css/format.css type=text/css>
		<link rel=stylesheet href=../css/menu.css type=text/css>
		<link rel=stylesheet href=../css/index.css type=text/css>
		<link rel=stylesheet href=../css/gererToeic.css type=text/css>
        <title>Lancer TOEIC/Liste des parties</title>
        <meta charset="utf-8" />
    </head>
    <body>


		<div class="container-fluid header border-bottom border-top">
			<table class=mx-auto style="height:100px;">
				<tr>
					<td class=align-middle>
						<h1 class=titre>Liste des parties</h1>
					</td>
				</tr>
			</table>
		</div>

<?php
	session_start();
	if(!(isset($_SESSION["user_id"])) or !(isset($_POST["id_session"]))){
		header("Location: ../index.php");
		exit;
	}
	$session=$_POST["id_session"];
	include("../connectbdd.php");
	include("../traitement/getResult.php");
	if($requete = $bdd->prepare('SELECT session.id_session FROM session,sous_partie,compte WHERE compte.id_compte = ? AND compte.id_compte = sous_partie.id_compte AND session.id_session = sous_partie.id_session AND session.id_session= ?')){
			$requete->bind_param("ii",$_SESSION["user_id"],$session);
            $requete->execute();
            $note=get_result($requete);
		}
		if(count($note)>0){
			header("Location: ../accueil.php");
			exit;
		}else{
?>
<div class="container" style="padding-top:5%;">
	<form method="post" action="../traitement/correction_questions.php">

		<div class="row" style="display:flex;text-align:center;">
			<div class="form-group col-lg-6	">
				<h4>Listening</h4>
				<div class=repQuest>
					<?php
						for($i=1 ; $i <= 100 ; $i++){
							echo '
							<div class="form-group row questions" style="display:flex;margin-right:0px;margin-left:0px;">
								<label style="display:inline-block;" class="col-sm-2 col-form-label col-form-label-sm">Q',$i,'</label>
								<div style="display:inline-block" class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="question',$i,'" id="grp1" value=A>
									<label class="form-check-label col-form-label" for="grp1">A</label>
								</div>
								<div style="display:inline-block" class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="question',$i,'" id="grp2" value=B>
									<label class="form-check-label col-form-label" for="grp2">B</label>
								</div>
								<div style="display:inline-block" class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="question',$i,'" id="grp3" value=C>
									<label class="form-check-label col-form-label" for="grp3">C</label>
								</div>
								<div style="display:inline-block" class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="question',$i,'" id="grp3" value=D>
									<label class="form-check-label col-form-label" for="grp3">D</label>
								</div>

							</div>';
					}
				
					?>
				</div>
			</div>

			<div class="form-group col-lg-6">
				<h4>Reading</h4>
				<div class=repQuest>
					<?php
						for($i=101 ; $i <= 200 ; $i++){
							echo '
							<div class="form-group row questions" style="display:flex;margin-right:0px;margin-left:0px;">
								<label style="display:inline-block;" class="col-sm-2 col-form-label col-form-label-sm">Q',$i,'</label>
								<div style="display:inline-block" class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="question',$i,'" id="grp1" value=A>
									<label class="form-check-label col-form-label" for="grp1">A</label>
								</div>
								<div style="display:inline-block" class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="question',$i,'" id="grp2" value=B>
									<label class="form-check-label col-form-label" for="grp2">B</label>
								</div>
								<div style="display:inline-block" class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="question',$i,'" id="grp3" value=C>
									<label class="form-check-label col-form-label" for="grp3">C</label>
								</div>
								<div style="display:inline-block" class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="question',$i,'" id="grp3" value=D>
									<label class="form-check-label col-form-label" for="grp3">D</label>
								</div>

								
							</div>';
					}
				
					?>
				</div>
			</div>
		</div>
		<input type=hidden name=id_session value="<?php echo($session); ?>">
		<button class="btn btn-dark" type = "submit" value = "Valider">Valider</button>
	</form>
</div>
<?php } ?>
    </body>
</html>
