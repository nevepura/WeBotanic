<?php

session_start();

require_once('funzioni.php');
$titolo = htmlentities(trim($_POST["titolo"]), ENT_QUOTES);

$giorno = $_POST['giorno'];
$mese = $_POST['mese'];
$anno = $_POST['anno'];

$alt = htmlentities(trim($_POST['alt']), ENT_QUOTES);

$testo = [htmlentities(trim($_POST['testo']), ENT_QUOTES), '<li> Il testo deve avere un numero di caratteri compreso tra 15 e 1000</li>'];

$err = '';
$err .= controllaTitolo($titolo, 'Titolo');

$err .= controllaData($mese, $giorno, $anno, 'notizia');

if(strlen($testo[0])<15 || strlen($testo[0]>1000))
    $err .= $testo[1];

$err .= controllaAlt($alt);

if(empty($err)){
    $temp = controlloImmagine('images/');
    $err .= $temp[0];
    $immagine = $temp[1];
}


if(!empty($err)) {
    $_SESSION["errori"] = ulError($err);
    header("location: ../insNotizia.php");
}
else {
    $data = $anno.'-'.$mese.'-'.$giorno;

    require "connessione.php";
    $sql = 'INSERT INTO Notizie (DataPub, Titolo, Testo, Immagine, Alt) VALUES ( "'.$data.'", "'.$titolo.'", "'.$testo[0].'", "'.$immagine.'","'.$alt.'")';

    if($result = $connessione->query($sql)) {
        $_SESSION['conferma'] = conferma('Notizia');
        header("location: ../insNotizia.php");
    }
    else {
        $_SESSION["errori"] = servError();
        header("location: ../insNotizia.php");
    }

    $connessione->close();
}
?>
