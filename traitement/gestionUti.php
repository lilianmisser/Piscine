<?php
	include("../connectbdd.php"); //connection bdd
	include("getResult.php");	//fonction get_result
	if(isset($_POST["spe"])){

		//requête qui récupère le groupe,le nom, le prenom et le mail des utisateurs pour une specialité donnée
		if($requete = $bdd->prepare("SELECT groupe.num_grp,nom,prenom,mail FROM compte,est_de_groupe,groupe,specialite WHERE compte.id_compte=est_de_groupe.id_compte AND est_de_groupe.id_grp =groupe.id_grp AND groupe.id_spe=specialite.id_spe AND specialite.id_spe= ? ORDER BY num_grp,nom")){
			$requete->bind_param("s",$_POST["spe"]);
			$requete->execute();
			$tabl=get_result($requete);
		}

		//envoi du formulaire avec les données de la requête automatique
		echo '<form method=post id=form action=../gererUtilisateurs.php>
					<input type=hidden value=',$_POST["spe"],' name=spe>
					<input type=hidden value=',count($tabl),' name=compteur>';
	
		for($i=0;$i<count($tabl);$i++){
			echo '<input type=hidden value=',$tabl[$i]["nom"],' name=nom',$i,'>
					<input type=hidden value=',$tabl[$i]["prenom"],' name=prenom',$i,'>
					<input type=hidden value=',$tabl[$i]["mail"],' name=mail',$i,'>
					<input type=hidden value=',$tabl[$i]["num_grp"],' name=grp',$i,'>';
		}
		echo '</form>';
		echo '<script type="text/JavaScript">
             		  document.getElementById("form").submit();
       		   </script>';

	?>

<?php 
}else{
	header("Location: ../accueil.php");
	exit;
}
