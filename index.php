<?php

$eventi = "SELECT Id, DataInizio, DataFine, Nome FROM Eventi WHERE DataFine > CURDATE() ORDER BY DataFine LIMIT 3";
$notizie = "SELECT Id, Titolo, DataPub FROM Notizie ORDER BY DataPub DESC LIMIT 3";

require "php/connessione.php";


$output = $connessione->query($eventi);

if(!$output)
    $stampa = servError();
else {

    if($output->num_rows == 0)
        $stampa = "<p> Nessun evento </p>";
    else {
         $stampa = '<ul>';

        while($row = $output -> fetch_array(MYSQLI_ASSOC)) {
            $stampa .= "<li><a href=\"eventi.php#id".$row['Id']."\">".$row['Nome']."</a></li>\n";
        }
        $stampa .= "</ul>";
    }

    
}
$index = str_replace('listaEventi', $stampa, file_get_contents('templates/index.txt'));
$output = $connessione->query($notizie);

if(!$output)
    $stampa = "<p class=\"errori\"> Servizio momentaneamente non disponibile. Riprovare pi&ugrave; tardi</p>";
else {

    if($output->num_rows == 0)
        $stampa = "<p> Nessuna notizia</p>";
    else {
        $stampa = '<ul>';
        while($row = $output -> fetch_array(MYSQLI_ASSOC)) {
            $stampa .= "<li><a href=\"notizie.php#id".$row['Id']."\">".$row['Titolo']."</a></li>\n";
        }
        $stampa .='</ul>';
    }
}

$index = str_replace('listaNotizie', $stampa, $index);

echo $index;
