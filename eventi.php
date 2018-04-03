<?php

$query = "SELECT Id, DataInizio, DataFine, Nome, Descrizione, Immagine, Alt FROM Eventi WHERE DataFine > CURDATE() ORDER BY DataFine ";

require "php/connessione.php";


$output = $connessione->query($query);
$head = file_get_contents("templates/headEventi.txt");
$foot = file_get_contents("templates/footEventi.txt");
echo $head;
$stampa = "<div id=\"content\">";
if(!$output)  $stampa .= servError();
else {
    
    if($output->num_rows == 0)
        $stampa .= "<p> Nessuna evento trovato </p>";
    else
        foreach($output as $campo => $cont) {
            $oldDF = $cont['DataFine'];
            $DF = date("d-m-Y", strtotime($oldDF));
            $oldDI = $cont['DataInizio'];
            $DI = date("d-m-Y", strtotime($oldDI));
            $stampa .= "<div class=\"notizie_eventi\"> <h2 id=\"id".$cont['Id']."\">".$cont['Nome']."</h2> <span> Data Inizio: ".$DI."</span> <span> Data Fine: ".$DF."</span>\n";
            if(!empty($cont['Immagine']))
                $stampa .= "<img src=\"images/".$cont['Immagine']."\" alt=\"".$cont['Alt']."\" /> \n";
            $stampa .= "<p>".$cont['Descrizione']."</p> </div>";
        }
    $stampa .= "<p id=\"tornasu\"><a href= \"#header\">Torna a inizio pagina</a></p>";
    
}
$stampa .= "\n</div>";
echo $stampa;
echo $foot;
$connessione->close();
?>
