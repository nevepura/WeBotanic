<?php

session_start();

require_once('funzioni.php');

$nome = htmlentities(trim($_POST["nome"]), ENT_QUOTES);
$giornoi = $_POST['giorno_inizio'];
$mesei = $_POST['mese_inizio'];
$annoi = $_POST['anno_inizio'];
$giornof = $_POST['giorno_fine'];
$mesef = $_POST['mese_fine'];
$annof = $_POST['anno_fine'];
$testo = [htmlentities(trim($_POST['testo']), ENT_QUOTES), '<li> Il testo deve avere un numero di caratteri compreso tra 15 e 1000'];
$alt = htmlentities(trim($_POST['alt']), ENT_QUOTES);

$err = '';

$err .= controllaData($mesei, $giornoi, $annoi, 'inizio');
$err .= controllaData($mesef, $giornof, $annof, 'fine');

if($err==''){
    
    $datai = $annoi.'-'.$mesei.'-'.$giornoi;
    $dataf = $annof.'-'.$mesef.'-'.$giornof;
    if($datai > $dataf) 
        $err .= "<li>Data inizio non deve essere maggiore di data fine</li> \n";  
}
    
$err .= controllaTitolo($nome, 'Nome');

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
    header("location: ../insEvento.php");
}
else {
    require "connessione.php";
    $sql = 'INSERT INTO Eventi (DataInizio, DataFine, Nome, Descrizione, Immagine, Alt) VALUES ( "'.$datai.'", "'.$dataf.'", "'.$nome.'", "'.$testo[0].'", "'.$immagine.'","'.$alt.'")';

    if($result = $connessione->query($sql)) {
        $_SESSION['conferma'] = conferma('Evento');
        header("location: ../insEvento.php");
    }
    else {
        $_SESSION["errori"] = servError();
        header("location: ../insEvento.php");
    }

    $connessione->close();
}
?>
