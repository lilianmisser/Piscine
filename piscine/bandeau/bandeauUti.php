<!--div class=container-fluid style="padding-top:1%;padding-bottom:2.5%;height:5%;text-align:right">
	<span><?php echo '<p class=text-uppercase>',$_SESSION["user_firstname"],'</p>'?></span>
	<a class="btn btn-dark" href=deconnection.php>Deconnection</a>
</div-->
<div class="row justify-content-between" style="height:auto;padding-top: 0.5%;margin-left: 0;margin-right: 0;padding-bottom:0.5%;">
	<div class=col-4 style><?php echo '<p class=text-uppercase>',$_SESSION['user_firstname'],' ',$_SESSION['user_lastname'],'</p>'?></div>
	<div class="col-4" style="text-align:right"><a class="btn btn-blue" href=traitement/deconnection.php>Deconnection</a></div>
</div>