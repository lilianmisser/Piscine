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
  case "gererToeic.php":
    $b=' active';
    break;
  case "gererUtilisateurs.php":
    $c=' active';
    break;
  case "statistiques.php":
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
          <a class="nav-link', $b ,'" href="gererToeic.php#a">Gérer les Toeic</a>
        </li>
        <li class="nav-item">
          <a class="nav-link', $c ,'" href="gererUtilisateurs.php">Gérer les utilisateurs</a>
        </li>
        <li class="nav-item">
          <a class="nav-link', $d ,'" href="statistiques.php">Statistiques</a>
        </li>
        <li class="nav-item">
          <a class="nav-link', $e ,'" href="monCompte.php">Mon compte</a>
        </li>
      </ul>'

?>