<?php
	if(isset($_POST["redi"])){
		
		if($_POST["redi"]=="statPart"){
			$page="statsProfs.php";
		}elseif($_POST["redi"]=="promo"){
			$page="statsProfs2.php";

		}

		echo '<form id=form action=',$page,' method=post>
				<input name=specialite_et_annee type=hidden value=',$_POST["specialite_et_annee"],'>
				<input name=groupe_niveau type=hidden value=',$_POST["groupe_niveau"],'>
			</form>
			<script type="text/JavaScript">
	       		document.getElementById("form").submit();
	        </script>';
	}else{
		header("Location: ../accueil.php");
		exit;
	}
?>