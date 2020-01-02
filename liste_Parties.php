<!-- listes des parties d'un toeic, pensera faire le lien avec question_toeic a chaque fois-->

<!DOCTYPE html>
<html>
    <head>
    	<link rel=stylesheet href=css/bootstrap.css type=text/css>
		<link rel=stylesheet href=css/format.css type=text/css>
		<link rel=stylesheet href=css/menu.css type=text/css>
		<link rel=stylesheet href=css/index.css type=text/css>
        <title>Lancer TOEIC/Liste des parties</title>
        <meta charset="utf-8" />
    </head>
    <body>

    	<?php
		include("menu/menuUti.php")
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


		<div class="container tout">
			<div class=row>
				<div class="col-lg-6 col-md-6 listening">
					<table class=mx-auto style="height:100px;">
						<tr>
							<td class=align-middle>
								<p>Listening</p>
								<div class=container>
									<div class='form-group'>
										<a href="partie1.php"> Part 1 </a>
										<br />
										<a href="partie2.php"> Part 2 </a>
										<br />
										<a href="partie3.php"> Part 3 </a>
										<br />
										<a href="partie4.php"> Part 4 </a>
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
										<a href="partie5.php"> Part 5 </a>
										<br />
										<a href="partie6.php"> Part 6 </a>
										<br />
										<a href="partie7.php"> Part 7 </a>
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

		<div class="container-fluid">
			<img src="logo/logoUM.png" width=7% class="rounded float-left" alt="Responsive image">
			<img src="logo/logoPO.jpeg" width=7% class="rounded float-right" alt="Responsive image">
		</div>

    </body>
</html>
