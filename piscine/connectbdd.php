<?php

$bdd = new mysqli('localhost', 'root', '', 'piscine');

if ($bdd->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno() . ') '
. $mysqli->connect_error());
}

?>