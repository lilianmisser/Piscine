<?php
	include("../connectbdd.php");
	session_start();
	if(!(isset($_SESSION['user_id']))){
		header("Location: ../index.php");
		exit;
	}
	
	if($requete = $bdd->prepare("SELECT est_admin FROM compte WHERE compte.id_compte = ?")){
		$requete->bind_param("i",$_SESSION["user_id"]);
		$requete->execute();
		$requete->store_result();
		$requete->bind_result($admin);
		$requete->fetch();
	}
	if(!$admin){
		header("Location: ../accueil.php");
		exit;
	}

	$onlyspe = false;

	if(!(isset($_POST["specialite_et_annee"]))){
		header("Location: ../accueil.php");
		exit;
	}

	if($_POST["groupe_niveau"] == ""){
		$onlyspe = true;
	}
	
	include("../traitement/getResult.php");
	//Pré-conditions : date avec le format américain : ('Y/m/d')
	//fonction qui retourne la date en paramètre en format français : ('d/m/Y')
	function fromUsDateToFrDate($us_date){
		return(implode('/',array_reverse(explode('-',$us_date))));
	}

	//Barême
	$tablListening=array(5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,10,15,20,25,30,35,40,45,50,55,60,70,80,85,90,95,100,105,115,125,135,140,150,160,170,175,180,190,200,205,215,220,225,230,235,245,255,260,265,275,285,290,295,300,310,320,325,330,335,340,345,350,355,360,365,370,375,385,395,400,405,415,420,425,430,435,440,445,450,455,460,465,475,480,485,490,495,495,495,495,495,495,495,495);
	$tablReading=array(5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,10,15,20,25,30,35,40,45,55,60,65,70,75,80,85,90,95,105,115,120,125,130,135,140,145,155,160,170,175,185,195,205,210,215,220,230,240,245,250,255,260,270,275,280,285,290,295,295,300,310,315,320,325,330,335,340,345,355,360,370,375,385,390,395,400,405,415,420,425,435,440,450,455,460,470,475,485,485,490,495);

	//On récupére les données en fonction de la promo ou de du groupe et de la promo

	if($onlyspe){
		if($requete = $bdd->prepare('SELECT compte.id_compte,nom,prenom,mail,note_sp,num_sp,id_session FROM groupe,est_de_groupe,compte,sous_partie WHERE groupe.id_spe = ? AND est_de_groupe.id_grp = groupe.id_grp AND compte.id_compte = est_de_groupe.id_compte AND sous_partie.id_compte = compte.id_compte ORDER BY id_compte,id_session,num_sp')){
			$requete->bind_param("s",$_POST["specialite_et_annee"]);
			$requete->execute();
			$donnees_promo = get_result($requete);
			$title = "Voici les élèves de la promotion ".$_POST["specialite_et_annee"].".";
		}
	}
	else{
		if($requete = $bdd->prepare('SELECT compte.id_compte,nom,prenom,mail,note_sp,num_sp,id_session FROM groupe,est_de_groupe,compte,sous_partie WHERE groupe.id_spe = ? AND groupe.num_grp = ? AND est_de_groupe.id_grp = groupe.id_grp AND compte.id_compte = est_de_groupe.id_compte AND sous_partie.id_compte = compte.id_compte ORDER BY id_compte,id_session,num_sp')){
			$requete->bind_param("si",$_POST["specialite_et_annee"],strval($_POST["groupe_niveau"]));
			$requete->execute();
			$donnees_promo = get_result($requete);
			$title = "Voici les élèves de la promotion ".$_POST["specialite_et_annee"]." appartenant au groupe ".$_POST["groupe_niveau"].".";
		}
	}
	
	if(count($donnees_promo) == 0){
		header("Location: ../statistiques.php?err=0");
		exit;
	}

	$verif = $donnees_promo[0]["id_compte"];
	$moyenne_eleves = array();
	$moyenne_reading = array();
	$moyenne_listening = array();
	
	$information_eleves = array(); //Récupérer l'indice des élèves pour ensuite pouvoir accéder à leurs informations
	$cpt_nombre_session = 0;
	$dernier_indice = -1;	

	for($i=0;$i<count($donnees_promo);$i+=7){ // 7 sous parties
		if($verif!=$donnees_promo[$i]["id_compte"]){ //Si l'id de compte change alors je calcule la moyenne et je passe à un nouvel élève
			$moyenne_eleves[$dernier_indice] = $moyenne_eleves[$dernier_indice] / $cpt_nombre_session;
			$moyenne_listening[$dernier_indice] = $moyenne_listening[$dernier_indice] / $cpt_nombre_session;
			$moyenne_reading[$dernier_indice] = $moyenne_reading[$dernier_indice] / $cpt_nombre_session;
			$noteListening = $tablListening[$donnees_promo[$i]["note_sp"]+$donnees_promo[$i+1]["note_sp"]+$donnees_promo[$i+2]["note_sp"]+$donnees_promo[$i+3]["note_sp"]]; 
			$noteReading = $tablReading[$donnees_promo[$i+4]["note_sp"] + $donnees_promo[$i+5]["note_sp"] + $donnees_promo[$i+6]["note_sp"]];
			array_push($moyenne_eleves,$noteListening + $noteReading);
			array_push($information_eleves,$i);
			array_push($moyenne_reading,$noteReading);
			array_push($moyenne_listening,$noteListening);
			$cpt_nombre_session = 1;
			$dernier_indice +=1;
			$verif = $donnees_promo[$i]["id_compte"];
		}
		else{	//Içi l'id de compte ne change pas donc je rajoute la note et j'indente le compteur de nb de sessions
			$noteListening = $tablListening[$donnees_promo[$i]["note_sp"]+$donnees_promo[$i+1]["note_sp"]+$donnees_promo[$i+2]["note_sp"]+$donnees_promo[$i+3]["note_sp"]]; 
			$noteReading =  $tablReading[$donnees_promo[$i+4]["note_sp"] + $donnees_promo[$i+5]["note_sp"] + $donnees_promo[$i+6]["note_sp"]];
			if(empty($moyenne_eleves)){ // cas initial
				array_push($moyenne_eleves,$noteListening + $noteReading);
				array_push($moyenne_reading,$noteReading);
				array_push($moyenne_listening,$noteListening);
				array_push($information_eleves,$i);
				$cpt_nombre_session += 1;
				$dernier_indice += 1;
			}
			else{
				$moyenne_eleves[$dernier_indice] += $noteListening + $noteReading;
				$moyenne_listening[$dernier_indice] += $noteListening;
				$moyenne_reading[$dernier_indice] += $noteReading;
				$cpt_nombre_session += 1;
			}
		}
	}

	$moyenne_eleves[$dernier_indice] = $moyenne_eleves[$dernier_indice] / $cpt_nombre_session; //Il faut diviser la dernière somme des notes par le nombre d'élèves
	$moyenne_listening[$dernier_indice] = $moyenne_listening[$dernier_indice] / $cpt_nombre_session;
	$moyenne_reading[$dernier_indice] = $moyenne_reading[$dernier_indice] / $cpt_nombre_session; 	


	$pourcentage_en_dessous = 0;
	$pourcentage_en_dessous_reading = 0;
	$pourcentage_en_dessous_listening = 0;

	for($i=0;$i<count($moyenne_eleves);$i++){
		if($moyenne_eleves[$i]<785){
			$pourcentage_en_dessous += 1;
		}
		if($moyenne_listening[$i]<392.5){
			$pourcentage_en_dessous_listening += 1;
		}
		if($moyenne_reading[$i]<392.5){
			$pourcentage_en_dessous_reading += 1;
		}
	}

	$pourcentage_en_dessous = $pourcentage_en_dessous / count($moyenne_eleves) * 100;
	$pourcentage_en_dessous_reading = $pourcentage_en_dessous_reading / count($moyenne_eleves) * 100;
	$pourcentage_en_dessous_listening = $pourcentage_en_dessous_listening / count($moyenne_eleves) * 100;


	if($onlyspe){
		$title = "Élèves de la promotion ".$_POST["specialite_et_annee"];
	}
	else{
		$title = "Élèves de la promotion ".$_POST["specialite_et_annee"]." appartenant au groupe ".$_POST["groupe_niveau"];
	}	
	$bdd->close();
?>

<!DOCTYPE html>
<html>
<head>
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3"></script>
	<link rel=stylesheet href=../css/bootstrap.css type=text/css>
	<link rel=stylesheet href=../css/format.css type=text/css>

	<title>Statistiques eleves</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark btn-blue">
  <a class="navbar-brand" href="../statistiques.php">Retour</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
  </div>
</nav>
	<div class=container style="padding-top:5%;">
	<div class="row banniere" style="width:auto;">
		<div class=col-lg-4>
			<div class=><?php echo($title); ?></div>
		</div>
		<div class=col-lg-2>
			Moyenne
		</div>
		<div class=col-lg-3>
			Lacunes
		</div>
		<div class=col-lg-3>
			Statistiques
		</div>
	</div>




<?php 

	for($i=0;$i<count($moyenne_eleves);$i++){
		$color="white";
		if($moyenne_eleves[$i]<785){
			$color="#AE1C1C";
		}
		else{
			$color="#1C912A";
		}
		if($moyenne_listening[$i]<392.5 && $moyenne_reading[$i]<392.5){

		}else{
			if($moyenne_listening[$i]<392.5){

			}
			if($moyenne_reading[$i]<392.5){

			}
		}
		echo '<div class=row style="padding-top:1%;padding-bottom:1%;color:',$color,'">
					<div class=col-lg-4 style="padding-left:2%;">
					',$donnees_promo[$information_eleves[$i]]["nom"],' ',$donnees_promo[$information_eleves[$i]]["prenom"],'
					</div>
				
				
					<div class=col-lg-2 style="padding-left:3%;">
						',round($moyenne_eleves[$i],1),'
					</div>
				
				<div class=col-lg-3 style="padding-left:2%;">';
					if($moyenne_listening[$i]<392.5 && $moyenne_reading[$i]<392.5){
						echo 'Listening/Reading';
					}else{
						if($moyenne_listening[$i]<392.5){
							echo 'Listening';
						}elseif($moyenne_reading[$i]<392.5){
							echo 'Reading';
						}
					}	
				echo '</div>
				<div class=col-lg-3 style="padding-left:4%;">
					<form method = "post" action = "traitementStatsProfs2.php">					
						<input type="hidden" name="nom" value="',$donnees_promo[$information_eleves[$i]]["nom"],'">
						<input type="hidden" name="prenom" value="',$donnees_promo[$information_eleves[$i]]["prenom"],'">
						<input type="hidden" name="promo" value="',$_POST["specialite_et_annee"],'">
						<input type="hidden" name="id_compte" value="',$donnees_promo[$information_eleves[$i]]["id_compte"],'">
						<input type="submit" value="➔">
					</form>
				</div>
			</div>';

	}
?>
	
	<div class="row banniere" style="margin-bottom:2%;margin-top:2%;width:auto;";>Vision globale des problèmes de cette promotion</div>

	<div>
		<canvas id="radar"></canvas>
		<script>
		let graph = document.getElementById("radar").getContext("2d");

		Chart.defaults.global.defaultFontFamily = "Helvetica";
		Chart.defaults.global.defaultFontColor = "Black";
		Chart.defaults.global.defaultFontSize = 15;

		var pourcentage_en_dessous = <?php echo($pourcentage_en_dessous) ?>;
		var pourcentage_en_dessous_listening = <?php echo($pourcentage_en_dessous_listening) ?>;
		var pourcentage_en_dessous_reading = <?php echo($pourcentage_en_dessous_reading) ?>;

		let statsToeic_Chart = new Chart(graph, {
			type:'radar',
			data:{
				labels: ["Ne validant pas le barême","Lacune listening","Lacune reading"],
				datasets: [{
					label:'Pourcentage',
					backgroundColor: "rgba(220,20,60,0.2)",
					borderColor: "rgba(220,20,60,0.6)",
					data: [pourcentage_en_dessous,pourcentage_en_dessous_listening,pourcentage_en_dessous_reading]
				}]
			},
			options:{	
				responsive : true,
				title:{
					display:false,
					text: "Graphique " ,
					fontSize:30
				},
				legend:{
					display:true,
				},
			    scale:{
			    	anglelines:{
			    		display:false,
			    	},
			    	ticks:{
			    		suggestedMin:0,
			    		suggestedMax:100
			    	},
			        yAxes: [{
			        	stacked: false,
			            display: false,
			            ticks: {
			                beginAtZero: true,
			           	}
		        	}],
		        	xAxes: [{
		        		stacked:false,
		        		display:false,
		        		ticks: {
		        			beginAtZero: true,
		        		}
		        	}]	
				},	
			}	
		});
		</script>
	</div>
</div>
</body>
</html>