<?php
session_start();

$head = file_get_contents("templates/headPrenotazione.txt");
$form = file_get_contents("templates/formPrenotazione.txt");
$foot = file_get_contents("templates/footPrenotazione.txt");

$errori = "";

if(isset($_SESSION["errori"])){ 
    $errori = $_SESSION["errori"];
    unset($_SESSION["errori"]);
}

$form = str_replace("replaceErrori", $errori, $form);

echo $head;
echo $form;
echo $foot;

?>