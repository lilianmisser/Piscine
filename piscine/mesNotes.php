<?php
	session_start();
	include("connectbdd.php");
    if(!(isset($_SESSION["user_id"]))){
		header("Location: accueil.php");
		exit;
	}
	?>


<html>
<head>
	<link rel=stylesheet href=css/bootstrap.css type=text/css>
	<link rel=stylesheet href=css/format.css type=text/css>
	<link rel=stylesheet href=css/gererSession.css type=text/css>
	<title>Mes notes</title>
</head>
<body>
	<?php
		include("bandeau/bandeauUti.php");
		include("menu/menuUti.php");
		include("traitement/getResult.php");
		$tablListening=array(5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,10,15,20,25,30,35,40,45,50,55,60,70,80,85,90,95,100,105,115,125,135,140,150,160,170,175,180,190,200,205,215,220,225,230,235,245,255,260,265,275,285,290,295,300,310,320,325,330,335,340,345,350,355,360,365,370,375,385,395,400,405,415,420,425,430,435,440,445,450,455,460,465,475,480,485,490,495,495,495,495,495,495,495,495);
		$tablReading=array(5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,10,15,20,25,30,35,40,45,55,60,65,70,75,80,85,90,95,105,115,120,125,130,135,140,145,155,160,170,175,185,195,205,210,215,220,230,240,245,250,255,260,270,275,280,285,290,295,295,300,310,315,320,325,330,335,340,345,355,360,370,375,385,390,395,400,405,415,420,425,435,440,450,455,460,470,475,485,485,490,495);
		if($requete = $bdd->prepare('SELECT session.id_session,nom_sujet,num_sp,note_sp,date_session FROM session,sous_partie,compte,sujet_toeic WHERE compte.id_compte = ? AND compte.id_compte = sous_partie.id_compte AND session.id_session = sous_partie.id_session AND session.id_sujet = sujet_toeic.id_sujet')){
			$requete->bind_param("i",$_SESSION["user_id"]);
            $requete->execute();
            $note=get_result($requete);
		}
?>

		<div class=container>
			<div class=row style="padding-top: 5%;">
				<div class="col-lg-3">
					<div class="btn-group-vertical">
						<a type="button" class="btn btn-info" href=#mesNotes>Mes notes</a>
						<a type="button" class="btn btn-info" href=#Stat>Statistiques</a>
					</div>
				</div>

				<div class="col contenu">
					<div class=container>
						<div id="mesNotes">
							<?php


								for ($i=0;$i<count($note);$i++){
									if($i==0){
										$listening=$note[$i]["note_sp"]+$note[$i+1]["note_sp"]+$note[$i+2]["note_sp"]+$note[$i+3]["note_sp"];
										$reading=$note[$i+4]["note_sp"]+$note[$i+5]["note_sp"]+$note[$i+6]["note_sp"];
										echo 'Session du : <b style="color:red;">',$note[$i]["date_session"],'</b> du sujet : <b style="color:red;">',$note[$i]["nom_sujet"],'</b>, note <b style="color:red;">',$tablReading[$reading]+$tablListening[$listening],'</b>';
									}elseif($note[$i]["id_session"] != $note[$i-1]["id_session"]){
										$listening=$note[$i]["note_sp"]+$note[$i+1]["note_sp"]+$note[$i+2]["note_sp"]+$note[$i+3]["note_sp"];
										$reading=$note[$i+4]["note_sp"]+$note[$i+5]["note_sp"]+$note[$i+6]["note_sp"];
										echo '<br/>';
										echo 'Session du : <b style="color:red;">',$note[$i]["date_session"],'</b> du sujet : <b style="color:red;">',$note[$i]["nom_sujet"],'</b>, note : <b style="color:red;">',$tablReading[$reading]+$tablListening[$listening],'</b>';
									}
								}
		?>
						

						</div>
						<div id="Stat">
							<?php // include("gestionSession/statEleve.php"); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		

</body>
</html>