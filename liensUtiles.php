<?php
	session_start();
	if(!(isset($_SESSION['user_id']))){
		header("Location: index.php");
		exit;
	}
	?>


<html>
<head>
	<link rel=stylesheet href=css/bootstrap.css type=text/css>
	<link rel=stylesheet href=css/format.css type=text/css>
	<title>Liens utiles</title>
</head>
<body>
	<?php
		include("bandeau/bandeauUti.php");
		include("menu/menuUti.php")
		?>
</body>
</html>