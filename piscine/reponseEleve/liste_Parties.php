<!-- listes des parties d'un toeic, pensera faire le lien avec question_toeic a chaque fois-->

<!DOCTYPE html>
<html>
    <head>
    	<link rel=stylesheet href=../css/bootstrap.css type=text/css>
		<link rel=stylesheet href=../css/format.css type=text/css>
		<link rel=stylesheet href=../css/menu.css type=text/css>
		<link rel=stylesheet href=../css/index.css type=text/css>
        <title>Lancer TOEIC/Liste des parties</title>
        <meta charset="utf-8" />
    </head>
    <body>

    	<?php
		include("../menu/menuUti.php")
		?>


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
?>

		<div class="container tout">
			<div class=row>
				<div class="col-lg-6 col-md-6 listening">
					<table class=mx-auto style="height:100px;">
						<tr>
							<td class=align-middle>
								<p>Listening</p>
								<div class=container>
									<div class='form-group'>
										<form method=post action=partie1.php>
											<button type=submit name="id_session" value="<?php echo($session); ?>"> Part 1 </button>
										</form>
										<br />
										<form>
											<button type=submit name="id_session" value="<?php echo($session); ?>"> Part 2 </button>
										</form>
										<br />
										<form>
											<button type=submit name="id_session" value="<?php echo($session); ?>"> Part 3</button>
										</form>
										<br />
										<form>
											<button type=submit name="id_session" value="<?php echo($session); ?>"> Part 4 </button>
										</form>
									</div>
								</div>
							</td>
						</tr>
					</table>
				</div>

				<div class="col-lg-6 col-md-6 reading">
					<table class=mx-auto style="height:100px;">
						<tr>
							<td class=align-middle>
								<p>Reading</p>
								<div class=container>
									<div class='form-group'>
										<form>
											<button type=submit name="id_session" value="<?php echo($session); ?>"> Part 5 </button>
										</form>
										<br />
										<form>
											<button type=submit name="id_session" value="<?php echo($session); ?>"> Part 6 </button>
										</form>
										<br />
										<form>
											<button type=submit name="id_session" value="<?php echo($session); ?>"> Part 7 </button>
										</form>
									</div>
								</div>
							</td>
						</tr>
					</table>
				</div>

			</div>
		</div>

		<div class="container-fluid">
			<table class=mx-auto style="height:100px;">
				<tr>
					<td class=align-middle>
							<button type="submit" class="btn btn-primary">Valider mon TOEIC</button>
					</td>
				</tr>
			</table>
		</div>


    </body>
</html>
