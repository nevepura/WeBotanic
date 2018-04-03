<?php

session_start();
require_once 'funzioni.php';

$intestatario = strip_tags(trim($_POST["intestatario"]));
$giorno = $_POST["giorno"];
$mese = $_POST["mese"];
$anno = $_POST["anno"];
$tipo = $_POST["tipo"];


$err = '';

$err .= controllaNome($intestatario, 'Intestatario');

$err .= controllaData($mese, $giorno, $anno, 'prenotazione');


if(!empty($err)) {
    $_SESSION["errori"] = ulError($err);
    header("location: ../prenotazioni.php");
}
else {
    $data = $anno.'-'.$mese.'-'.$giorno;

    require "connessione.php";
    $sql = "INSERT INTO Prenotazioni (DataP, Tipo, Intestatario) VALUES ( '".$data."', '".$tipo."', '".$intestatario."')";

    if($result = $connessione->query($sql)) {
        header("location: ../confermaPrenotazione.html");
    }
    else {
        $_SESSION["errori"] = servError();
        header("location: ../prenotazioni.php");
    }

    $connessione->close();
}
?>
