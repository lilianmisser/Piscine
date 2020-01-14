<?php
	include("connectbdd.php");
	session_start();
	if(!(isset($_SESSION['user_id']))){
		header("Location: index.php");
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
		header("Location: accueil.php");
		exit;
	}

	if(!isset($_POST["id_compte"])){
		header("Location: demandeStatsProfs.php");
		exit;
	}

	include("traitement/getResult.php");
	//Pré-conditions : date avec ce format : ('Y/m/d')
	//fonction qui retourne la date en paramètre en format français : ('d/m/Y')
	function fromUsDateToFrDate($us_date){
		return(implode('/',array_reverse(explode('-',$us_date))));
	}

	$tablListening=array(5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,10,15,20,25,30,35,40,45,50,55,60,70,80,85,90,95,100,105,115,125,135,140,150,160,170,175,180,190,200,205,215,220,225,230,235,245,255,260,265,275,285,290,295,300,310,320,325,330,335,340,345,350,355,360,365,370,375,385,395,400,405,415,420,425,430,435,440,445,450,455,460,465,475,480,485,490,495,495,495,495,495,495,495,495);
		$tablReading=array(5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,10,15,20,25,30,35,40,45,55,60,65,70,75,80,85,90,95,105,115,120,125,130,135,140,145,155,160,170,175,185,195,205,210,215,220,230,240,245,250,255,260,270,275,280,285,290,295,295,300,310,315,320,325,330,335,340,345,355,360,370,375,385,390,395,400,405,415,420,425,435,440,450,455,460,470,475,485,485,490,495);
	
	if($requete = $bdd->prepare('SELECT session.id_session,nom_sujet,num_sp,note_sp,date_session FROM session,sous_partie,compte,sujet_toeic WHERE compte.id_compte = ? AND compte.id_compte = sous_partie.id_compte AND session.id_session = sous_partie.id_session AND session.id_sujet = sujet_toeic.id_sujet ORDER BY id_session,num_sp')){
		$requete->bind_param("i",$_POST["id_compte"]);
        $requete->execute();
        $note=get_result($requete);
        $stock_notes = array();
        $stock_dates_et_sujets = array();
        $stock_listening = array();
        $stock_reading = array();

        for($i=0;$i<count($note);$i+=7){
        	$listening=$note[$i]["note_sp"]+$note[$i+1]["note_sp"]+$note[$i+2]["note_sp"]+$note[$i+3]["note_sp"];
			$reading=$note[$i+4]["note_sp"]+$note[$i+5]["note_sp"]+$note[$i+6]["note_sp"];
			array_push($stock_notes,$tablReading[$reading]+$tablListening[$listening]);
			array_push($stock_dates_et_sujets,fromUsDateToFrDate($note[$i]["date_session"])." ".$note[$i]["nom_sujet"]);
			array_push($stock_listening,$tablListening[$listening]);
			array_push($stock_reading,$tablReading[$reading]);
        }
	}

?>

<!DOCTYPE html>
<html>
<head>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
	<title>Statistiques</title>
</head>
<body>
<link rel=stylesheet href=stats.css type=text/css>
	Voici les statistiques de  
<?php
	echo ($_POST["nom"]);
	echo(" ");
	echo ($_POST["prenom"]);
	echo(" qui appartient à la promotion : ");
	echo ($_POST["promo"]);
?>
	<a href=#bar>Diagramme de barres</a>
	<a href=#bar2>Diagramme de barres Listening/Reading</a>
	<a href=#linegraph>Diagramme linéaire</a>
	<div class=barre id="bar">
		<canvas id="barstats"></canvas>
		<script>
		let graph = document.getElementById("barstats").getContext("2d");

		Chart.defaults.global.defaultFontFamily = "Helvetica";
		Chart.defaults.global.defaultFontColor = "Black";
		Chart.defaults.global.defaultFontSize = 15;

		var notes_js = <?php echo json_encode($stock_notes); ?>; //json_encode($arrayphp) -> arrayjs
		var dates_js = <?php echo json_encode($stock_dates_et_sujets); ?>;

		var bareme_min = [];
		var border = [];

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
					text: "Notes élève pour chaque date de session" ,
					fontSize:25
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
					label:'Note de la partie : Listening',
					data: notes_listening_js,	
					backgroundColor: "rgb(65,105,225,0.4)",
					hoverBorderWidth:2,
					hoverBorderColor:'black'

					},
					{
						label:"Note de la partie : Reading",
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
					text: "Notes élève pour chaque date de session" ,
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

		var bareme_min = [];

		for(var i=0 ; i< notes_js.length ; i++){
		  bareme_min[i] = 785;
		}

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
					text: "Notes élève pour chaque session",
					fontSize:25
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