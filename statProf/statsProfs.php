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
	//Pré-conditions : date avec ce format : ('Y/m/d')
	//fonction qui retourne la date en paramètre en format français : ('d/m/Y')
	function fromUsDateToFrDate($us_date){
		return(implode('/',array_reverse(explode('-',$us_date))));
	}

	//Barême
	$tablListening=array(5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,10,15,20,25,30,35,40,45,50,55,60,70,80,85,90,95,100,105,115,125,135,140,150,160,170,175,180,190,200,205,215,220,225,230,235,245,255,260,265,275,285,290,295,300,310,320,325,330,335,340,345,350,355,360,365,370,375,385,395,400,405,415,420,425,430,435,440,445,450,455,460,465,475,480,485,490,495,495,495,495,495,495,495,495);
	$tablReading=array(5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,10,15,20,25,30,35,40,45,55,60,65,70,75,80,85,90,95,105,115,120,125,130,135,140,145,155,160,170,175,185,195,205,210,215,220,230,240,245,250,255,260,270,275,280,285,290,295,295,300,310,315,320,325,330,335,340,345,355,360,370,375,385,390,395,400,405,415,420,425,435,440,450,455,460,470,475,485,485,490,495);

	if($onlyspe){
		if($requete = $bdd->prepare('SELECT session.id_session,nom_sujet,num_sp,note_sp,date_session,compte.id_compte FROM compte,session,est_de_groupe,groupe,participe,sous_partie,sujet_toeic WHERE groupe.id_spe = ? AND est_de_groupe.id_compte = compte.id_compte AND participe.id_grp = groupe.id_grp AND session.id_session = participe.id_session AND sous_partie.id_session = session.id_session AND session.id_sujet = sujet_toeic.id_sujet AND compte.id_compte = sous_partie.id_compte ORDER BY session.id_session,id_compte,num_sp')){
			$requete->bind_param("s",$_POST["specialite_et_annee"]);
			$requete->execute();
			$donnees_promo = get_result($requete);
			$title = "Evolution des moyennes de la promotion ".$_POST["specialite_et_annee"]." par date de session";
		}
	}
	else{
		if($requete = $bdd->prepare('SELECT session.id_session,nom_sujet,num_sp,note_sp,date_session,compte.id_compte FROM compte,session,est_de_groupe,groupe,participe,sous_partie,sujet_toeic WHERE groupe.id_spe = ? AND groupe.num_grp = ? AND est_de_groupe.id_compte = compte.id_compte AND participe.id_grp = groupe.id_grp AND session.id_session = participe.id_session AND sous_partie.id_session = session.id_session AND session.id_sujet = sujet_toeic.id_sujet AND compte.id_compte = sous_partie.id_compte ORDER BY session.id_session,id_compte,num_sp')){
			$requete->bind_param("si",$_POST["specialite_et_annee"],strval($_POST["groupe_niveau"]));
			$requete->execute();
			$donnees_promo = get_result($requete);
			$title = "Evolution des moyennes du groupe ".$_POST["groupe_niveau"]." de la promotion ".$_POST["specialite_et_annee"]." par date de session";
		}
	}

	if(count($donnees_promo) == 0){ // Aucun résultat
		header("Location: ../statistiques.php?err=0");
		exit;
	}
	
	//On cherche maintenant à récupérer les moyennes d'une session pour une promo entière à une date donnée et les récupérer pour en faire des statistiques
	$verif = $donnees_promo[0]["id_session"];
	$moyenne_par_session = array();
	$stock_listening = array();
    $stock_reading = array();
	$dates = array();
	$cpt_eleve = 0;
	$dernier_indice = -1;
	for($i=0;$i<count($donnees_promo);$i+=7){ // 7 sous parties
		if($verif!=$donnees_promo[$i]["id_session"]){ //Si l'id de session change alors je calcule la moyenne et je passe à une nouvelle session
			$moyenne_par_session[$dernier_indice] = $moyenne_par_session[$dernier_indice] / $cpt_eleve;
			$stock_listening[$dernier_indice] = $stock_listening[$dernier_indice] / $cpt_eleve;
			$stock_reading[$dernier_indice] = $stock_reading[$dernier_indice] / $cpt_eleve;
			$noteListening = $tablListening[$donnees_promo[$i]["note_sp"]+$donnees_promo[$i+1]["note_sp"]+$donnees_promo[$i+2]["note_sp"]+$donnees_promo[$i+3]["note_sp"]]; 
			$noteReading = $tablReading[$donnees_promo[$i+4]["note_sp"] + $donnees_promo[$i+5]["note_sp"] + $donnees_promo[$i+6]["note_sp"]];
			array_push($moyenne_par_session,$noteListening + $noteReading);
			array_push($dates,fromUsDateToFrDate($donnees_promo[$i]["date_session"]));
			array_push($stock_listening,$noteListening);
			array_push($stock_reading,$noteReading);
			$cpt_eleve = 1;
			$dernier_indice +=1;
			$verif = $donnees_promo[$i]["id_session"];
		}
		else{
			$noteListening = $tablListening[$donnees_promo[$i]["note_sp"]+$donnees_promo[$i+1]["note_sp"]+$donnees_promo[$i+2]["note_sp"]+$donnees_promo[$i+3]["note_sp"]]; 
			$noteReading =  $tablReading[$donnees_promo[$i+4]["note_sp"] + $donnees_promo[$i+5]["note_sp"] + $donnees_promo[$i+6]["note_sp"]];
			if(empty($moyenne_par_session)){
				array_push($moyenne_par_session,$noteListening + $noteReading);
				array_push($dates,fromUsDateToFrDate($donnees_promo[$i]["date_session"]));
				array_push($stock_listening,$noteListening);
				array_push($stock_reading,$noteReading);
				$cpt_eleve += 1;
				$dernier_indice += 1;
			}
			else{
				$moyenne_par_session[$dernier_indice] += $noteListening + $noteReading;
				$stock_listening[$dernier_indice] += $noteListening;
				$stock_reading[$dernier_indice] += $noteReading;
				$cpt_eleve += 1;
			}
		}
	}
	$moyenne_par_session[$dernier_indice] = $moyenne_par_session[$dernier_indice] / $cpt_eleve; //Il faut diviser la dernière somme des notes par le nombre d'élèves
	$stock_listening[$dernier_indice] = $stock_listening[$dernier_indice] / $cpt_eleve;
	$stock_reading[$dernier_indice] = $stock_reading[$dernier_indice] / $cpt_eleve;
	
	$bdd->close();
?>

<!DOCTYPE html>
<html>
<head>
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3"></script>
	<link rel=stylesheet href=../css/bootstrap.css type=text/css>
	<link rel=stylesheet href=../css/mesNotes.css type=text/css>
	<link rel=stylesheet href=../css/format.css type=text/css>
	<title>Statistiques promotion</title>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark btn-blue">
  <a class="navbar-brand" href="../statistiques.php">Retour</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="#bar">Diagramme de barres</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#bar2">Diagramme de barres Listening/Reading</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#linegraph">Diagramme linéaire</a>
      </li>
    </ul>
  </div>
</nav>

	<div class=barre id="bar">
		<canvas id="barstats"></canvas>
		<script>
		let graph = document.getElementById("barstats").getContext("2d");

		Chart.defaults.global.defaultFontFamily = "Helvetica";
		Chart.defaults.global.defaultFontColor = "Black";
		Chart.defaults.global.defaultFontSize = 20;

		var notes_js = <?php echo json_encode($moyenne_par_session); ?>; //json_encode($arrayphp) -> arrayjs
		var dates_js = <?php echo json_encode($dates); ?>;

		var bareme_min = [];
		var border = [];

		//j'affecte une couleur différente en fonction de la note : vert si validé, orange si au dessus 685 rouge sinon
		for(var i=0 ; i< notes_js.length ; i++){
		  let ecart = notes_js[i]-785;
		  bareme_min[i] = 785;
		  if(ecart< -100){
		  	border[i] = "rgba(255,101,80,0.8)";
		  }
		  else{
			if(ecart > -1){
		  		border[i] = "rgba(0, 177, 106, 1)";
		  	}
		  	else{
		  		border[i] = "rgba(255,215,0,0.4)";
		  	}
		  }
		}

		let statsToeic_Chart = new Chart(graph, {
			type:'bar',
			data:{
				labels: dates_js,
				datasets:[{
					label:'Note',
					data: notes_js,	
					backgroundColor: border,
					hoverBorderWidth:2,
					hoverBorderColor:'black'

					},
					{
						label:"Barême validation",
						data: bareme_min,
						backgroundColor: "rgba(115, 101, 152, 1)",
						hoverBorderWidth:2,
						hoverBorderColor:'black',
					}]
			},
			options:{	
				responsive : true,
				title:{
					display:true,
					text: "<?php echo($title) ?>" ,
					fontSize:30
				},
				legend:{
					display:true
				},
			    scales:{
			        yAxes: [{
			        	stacked: false,
			            display: true,
			            ticks: {
			                beginAtZero: true,
			           	}
		        	}],
		        	xAxes: [{
		        		stacked:false,
		        		display:true,
		        		ticks: {
		        			beginAtZero: true,
		        		}
		        	}]	
				},	
			}	
		});
		</script>
	</div>
	<div class=barre2 id="bar2">
		<canvas id="barstats2"></canvas>
		<script>
		let graph3 = document.getElementById("barstats2").getContext("2d");

		var notes_reading_js = <?php echo json_encode($stock_reading); ?>; //json_encode($arrayphp) -> arrayjs
		var notes_listening_js = <?php echo json_encode($stock_listening); ?>;


		let statsToeic_Chart3 = new Chart(graph3, {
			type:'bar',
			data:{
				labels: dates_js,
				datasets:[{
					label:'Moyenne de la partie : Listening',
					data: notes_listening_js,	
					backgroundColor: "rgb(65,105,225,0.4)",
					hoverBorderWidth:2,
					hoverBorderColor:'black'

					},
					{
						label:"Moyenne de la partie : Reading",
						data: notes_reading_js,
						backgroundColor: "rgb(255,0,255,0.4)",
						hoverBorderWidth:2,
						hoverBorderColor:'black',
					}]
			},
			options:{	
				responsive : true,
				title:{
					display:true,
					text: "<?php echo($title); ?>" ,
					fontSize:25
				},
				legend:{
					display:true,
				},
			    scales:{
			        yAxes: [{
			        	stacked: true,
			            display: true,
			            ticks: {
			                beginAtZero: true,
			           	}
		        	}],
		        	xAxes: [{
		        		stacked: true,
		        		display:true,
		        		ticks: {
		        			beginAtZero: true,
		        		}
		        	}]	
				},	
			}	
		});
		</script>
	</div>
	<div class=line id="linegraph">
		<canvas id="linestats"></canvas>
		<script>
		let graph2 = document.getElementById("linestats").getContext("2d");

		let statsToeic_Chart2 = new Chart(graph2, {
			type:'line',
			data:{
				labels: dates_js,
				datasets:[{
					label:'Note',
					data: notes_js,	
					backgroundColor: 'rgba(75, 119, 190, 0.2)',
					borderColor : "rgba(75, 119, 190, 1)",
					hoverBorderWidth:2,
					hoverBorderColor:'black'

					},
					{
						label:"Barême validation",
						data: bareme_min,
						backgroundColor: "transparent",
						borderColor : "rgba(214, 69, 65, 1)",				
					}]
			},
			options:{	
				responsive : true,
				title:{
					display:true,
					text: "<?php echo($title) ?>",
					fontSize:30
				},
				legend:{
					display:true
				},
			    scales:{
			        yAxes: [{
			        	stacked: false,
			            display: true,
			            ticks: {
			                beginAtZero: true,
			           	}
		        	}],
		        	xAxes: [{
		        		stacked:false,
		        		display:true,
		        		ticks: {
		        			beginAtZero: true,
		        		}
		        	}]	
				},	
			}	
		});
		</script>
	</div>
</body>
</html>