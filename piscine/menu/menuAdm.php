<?php

$page = basename($_SERVER["PHP_SELF"]);

$a='';
$b='';
$c='';
$d='';
$e='';
$f='';

switch($page) {
  case "accueil.php":
    $a=' active';
    break;
  case "gererToeic.php":
    $b=' active';
    break;
  case "gererSession.php":
    $c=' active';
    break;
  case "gererUtilisateurs.php":
    $d=' active';
    break;
  case "statistiques.php":
    $e=' active';
    break;
  case "monCompte.php":
    $f=' active';
    break;
}

echo '<ul class="nav nav-tabs nav-justified">
        <li class="nav-item">
          <a class="nav-link', $a ,'" href="accueil.php">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link', $b ,'" href="gererToeic.php#z">Gérer les Toeic</a>
        </li>
        <li class="nav-item">
          <a class="nav-link', $c ,'" href="gererSession.php#NewSession">Gérer les sessions</a>
        </li>
        <li class="nav-item">
          <a class="nav-link', $d ,'" href="gererUtilisateurs.php">Gérer les utilisateurs</a>
        </li>
        <li class="nav-item">
          <a class="nav-link', $e,'" href="statistiques.php">Statistiques</a>
        </li>
        <li class="nav-item">
          <a class="nav-link', $f ,'" href="monCompte.php">Mon compte</a>
        </li>
      </ul>'

?>