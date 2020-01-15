<?php

$page = basename($_SERVER["PHP_SELF"]);

$a='';
$b='';
$c='';
$d='';
$e='';

switch($page) {
  case "accueil.php":
    $a=' active';
    break;
  case "lancerToeic.php":
    $b=' active';
    break;
  case "mesNotes.php":
    $c=' active';
    break;
  case "liensUtiles.php":
    $d=' active';
    break;
  case "monCompte.php":
    $e=' active';
    break;
}

echo '<ul class="nav nav-tabs nav-justified">
        <li class="nav-item">
          <a class="nav-link', $a ,'" href="accueil.php">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link', $b ,'" href="lancerToeic.php">Lancer TOEIC</a>
        </li>
        <li class="nav-item">
          <a class="nav-link', $c ,'" href="mesNotes.php#mesNotes">Mes notes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link', $d ,'" href="liensUtiles.php">Liens utiles</a>
        </li>
        <li class="nav-item">
          <a class="nav-link', $e ,'" href="monCompte.php">Mon compte</a>
        </li>
      </ul>'

?>