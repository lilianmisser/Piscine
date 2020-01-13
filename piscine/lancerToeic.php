<?php 
	session_start();
	include("connectbdd.php");
	$show_something = false;
	include("traitement/getResult.php");
	
	if(isset($_SESSION["user_id"])){
		$session=$_SESSION["user_id"];
		if($requete = $bdd->prepare("SELECT session.id_session,date_session FROM est_de_groupe,session,participe,groupe WHERE est_de_groupe.id_compte = ? AND est_de_groupe.id_grp=groupe.id_grp AND groupe.id_grp=participe.id_grp AND participe.id_session=session.id_session AND session.est_en_cours=1")){
			$requete->bind_param("i",$_SESSION["user_id"]);
			$requete->execute();
			$sessionDispo=get_result($requete);
			$show_something=true;
		}
	}
	else{
		header("Location: index.php");
		exit;
	}
 ?>

 
<!DOCTYPE html>
<html>
<head>
	<title>Connection session toeic</title>
	<link rel=stylesheet href=css/bootstrap.css type=text/css>
	<link rel=stylesheet href=css/format.css type=text/css>
	<link rel=stylesheet href=css/lancerToeic.css type=text/css>
</head>
<body>
	<?php
		include("bandeau/bandeauUti.php");
		include("menu/menuUti.php");
		?>
		<div class="container central">
			<?php
			if($show_something){					//s'il y a au moins une session possible
				for($i=0;$i<count($sessionDispo);$i++){
				if($i%2==0){
					$color="#DF566E";
				}else{
					$color="#B12B42";
				}
				$dejaParticipe='';
				if($requete = $bdd->prepare('SELECT session.id_session FROM session,sous_partie,compte WHERE compte.id_compte = ? AND compte.id_compte = sous_partie.id_compte AND session.id_session = sous_partie.id_session AND session.id_session= ?')){
						$requete->bind_param("ii",$session,$sessionDispo[$i]["id_session"]);
           				$requete->execute();
          				$nbNoteSession=get_result($requete);
          				if(count($nbNoteSession)>0){
          					$dejaParticipe='disabled';
						}
					}
					echo '<form style="padding-top:5px;padding-bottom:5px;margin-block-end:0em;background:linear-gradient(to right,',$color,',white);" method="post" action= "reponseEleve/liste_Parties.php">
								<div style="display:flex;" class="row justify-content-between">
									<div class=col-4 style="padding-left:5%;">
										<h4>Session du ',$sessionDispo[$i]["date_session"],'</h4>
									</div>
									<div class=col-4>
										<button name="id_session" value="',$sessionDispo[$i]["id_session"],'" class="btn btn-danger" type="submit" ',$dejaParticipe,'>Rejoindre</button>
									</div>
								</div>
							</form>';
						
		}
		$bdd->close();
				
			}else{
				echo "pas de sessions";
			}
		

		?>
		</div>
	</body>
</html>

