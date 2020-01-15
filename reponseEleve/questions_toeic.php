<?php
session_start();
	if(!(isset($_SESSION["user_id"])) or !(isset($_POST["id_session"]))){
		header("Location: ../index.php");
		exit;
	}
	$session=$_POST["id_session"];
	?>

<!DOCTYPE html>
<html>
	<head>
		<link rel=stylesheet href=../css/bootstrap.css type=text/css>
		<link rel=stylesheet href=../css/format.css type=text/css>
		<link rel=stylesheet href=../css/menu.css type=text/css>
		<link rel=stylesheet href=../css/index.css type=text/css>
		<title>Réponse aux questions</title>
		<meta charset="utf-8" />
	</head>
	<body>

		<?php
		include("../menu/menuUti.php")
		?>


		<?php $nom_partie = basename($_SERVER["PHP_SELF"]); ?> <!-- sert à récupérer le nom de la partie grâce à un morceau de l'url -->

		<div class="container-fluid header border-bottom border-top">
			<table class=mx-auto style="height:100px;">
				<tr>
					<td class=align-middle>
						<?php
						if ($nom_partie == "partie1.php") {
		    				?> <h1 class=titre>Listening : Part 1</h1> <?php
		    			}
		    			else if ($nom_partie == "partie2.php") {
		    				?> <h1 class=titre>Listening : Part 2</h1> <?php
		    			}
		    			else if ($nom_partie == "partie3.php") {
		    				?> <h1 class=titre>Listening : Part 3</h1> <?php
		    			}
		    			else if ($nom_partie == "partie4.php") {
		    				?> <h1 class=titre>Listening : Part 4</h1> <?php
		    			}
		    			else if ($nom_partie == "partie5.php") {
		    				?> <h1 class=titre>Reading : Part 5</h1> <?php
		    			}
		    			else if ($nom_partie == "partie6.php") {
		    				?> <h1 class=titre>Reading : Part 6</h1> <?php
		    			}
		    			else { /* partie 7 */
		    				?> <h1 class=titre>Reading : Part 7</h1> <?php
		    			}
		    			?>
						
					</td>
				</tr>
			</table>
		</div>

		<form method="post" action="correction_questions.php">
			<div class="container tout">
				<div class=row>
					<div class="col-lg-12 col-md-12 listening">
						<table class=mx-auto style="height:100px;">
							<tr>
								<td class=align-middle>  
									<div class=container>
										<div class='form-group'>	
									    <?php
									    /* $taille_toeic = 200; */
									    $taille_partie;
									    if ($nom_partie == "partie1.php") {
									    	$taille_partie = 6;
									    	for ($i=1 ; $i <= $taille_partie ; $i++) {
									        	echo "Question numéro : ".$i;
									    ?>
										        <select name="<?php /* echo "question".strval($i) */ ?>">
											        <option value="null"></option>
											        <option value="A">A</option>
											        <option value="B">B</option>
											        <option value="C">C</option>
											        <option value="D">D</option>
										    	</select>
										    	<br />
									    	<?php
									    	}
									    }
									    else if ($nom_partie == "partie2.php") {
									    	$taille_partie = 25;
									    	for ($i=7 ; $i <= 6+$taille_partie ; $i++) {
									        	echo "Question numéro : ".$i;
									        ?>
										        <select name="<?php /* echo "question".strval($i) */ ?>">
										        	<option value="null"></option>
											        <option value="A">A</option>
											        <option value="B">B</option>
											        <option value="C">C</option>
											        <option value="D">D</option>
										    	</select>
										    	<br />
									    	<?php
									    	}
									    }
									    else if ($nom_partie == "partie3.php") {
									   		$taille_partie = 39;
									   		for ($i=32 ; $i <= 31+$taille_partie ; $i++) {
									        	echo "Question numéro : ".$i;
									        ?>
										        <select name="<?php /* echo "question".strval($i) */ ?>">
										        	<option value="null"></option>
											        <option value="A">A</option>
											        <option value="B">B</option>
											        <option value="C">C</option>
											        <option value="D">D</option>
										    	</select>
										    	<br />
									    	<?php
									    	}
									    }
									    else if ($nom_partie == "partie4.php") {
									    	$taille_partie = 30;
									    	for ($i=71 ; $i <= 70+$taille_partie ; $i++) {
									        	echo "Question numéro : ".$i;
									        ?>
										        <select name="<?php /* echo "question".strval($i) */ ?>">
										        	<option value="null"></option>
											        <option value="A">A</option>
											        <option value="B">B</option>
											        <option value="C">C</option>
											        <option value="D">D</option>
										    	</select>
										    	<br />
									    	<?php
									    	}
							   			}
									    else if ($nom_partie == "partie5.php") {
									    	$taille_partie = 30;
									    	for ($i=101 ; $i <= 100+$taille_partie ; $i++) {
									        	echo "Question numéro : ".$i;
									        ?>
										        <select name="<?php /* echo "question".strval($i) */ ?>">
										        	<option value="null"></option>
											        <option value="A">A</option>
											        <option value="B">B</option>
											        <option value="C">C</option>
											        <option value="D">D</option>
										    	</select>
										    	<br />
									    	<?php
									    	}
									    }
									    else if ($nom_partie == "partie6.php") {
									    	$taille_partie = 16;
									    	for ($i=131 ; $i <= 130+$taille_partie ; $i++) {
									        	echo "Question numéro : ".$i;
									        ?>
										        <select name="<?php /* echo "question".strval($i) */ ?>">
										        	<option value="null"></option>
											        <option value="A">A</option>
											        <option value="B">B</option>
											        <option value="C">C</option>
											        <option value="D">D</option>
										    	</select>
										    	<br />
									    	<?php
									    	}
									    }
									    else { /* partie 7 */
									    	$taille_partie = 54;
									    	for ($i=147 ; $i <= 146+$taille_partie ; $i++) {
									        	echo "Question numéro : ".$i;
									        ?>
										        <select name="<?php /* echo "question".strval($i) */ ?>">
										        	<option value="null"></option>
											        <option value="A">A</option>
											        <option value="B">B</option>
											        <option value="C">C</option>
											        <option value="D">D</option>
										    	</select>
										    	<br />
									    	<?php
									    	}
									    }
										?>
										</div>
									</div>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<input type="hidden" name="id_session" value="<?php echo($_POST["id_session"])?>">
			<div class="container-fluid">
				<table class=mx-auto style="height:100px;">
					<tr>
						<td class=align-middle>
							<button type="submit" class="btn btn-primary">Valider la partie</button>
						</td>
					</tr>
				</table>
			</div>


		

	 	</form>
	</body>
</html>