<?php
session_start();

$head = file_get_contents("templates/headPiante.txt");
$foot = file_get_contents("templates/footPiante.txt");
$cont = file_get_contents("templates/contentPiante.txt");

$cont = str_replace("RicercaFallita","<h2> WeBotanic, un ricco orto botanico da visitare, e un grande database di piante da esplorare</h2>", $cont);

echo $head;
echo $cont;
echo $foot;

?>
