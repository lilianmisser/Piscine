<?php
	session_start();
	session_destroy();
	header("Location: ../index.php?erreur:Deconnection effectuée");
	exit;
?>