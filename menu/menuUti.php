<?php

//Récupère le bout du lien de la page sur laquelle on se situe
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
  case "monCompte.php":
    $e=' active';
    break;
}


// Change la couleur du menu de la page active
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
          <a class="nav-link', $e ,'" href="monCompte.php">Mon compte</a>
        </li>
      </ul>'

?>