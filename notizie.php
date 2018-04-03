<?php

$query = "SELECT Id, DataPub, Titolo, Testo, Immagine, Alt FROM Notizie WHERE DATEDIFF(CURDATE(), DataPub) < 200 ORDER BY DataPub DESC";

require "php/connessione.php";

$output = $connessione->query($query);
$head = file_get_contents("templates/headNotizie.txt");
$foot = file_get_contents("templates/footNotizie.txt");
echo $head;
$stampa = "<div id=\"content\">";
if(!$output) $stampa .= servError();
else {
    
    if($output->num_rows == 0)
        $stampa .= "<p> Nessuna notizia trovata </p>";
    else
        foreach($output as $campo => $cont) {
            $oldDP = $cont['DataPub'];
            $DP = date("d-m-Y", strtotime($oldDP));
            $stampa .= "<div class=\"notizie_eventi\"> <h2 id=\"id".$cont['Id']."\">".$cont['Titolo']."</h2> <span> Data: ".$DP."</span>\n";
            if(!empty($cont['Immagine']))
                $stampa .= "<img src=\"images/".$cont['Immagine']."\" alt=\"".$cont['Alt']."\" /> \n";
            $stampa .= "<p>".$cont['Testo']."</p> </div>";
        }
        $stampa .= "<p id=\"tornasu\"><a href= \"#header\">Torna a inizio pagina</a></p>";
        
}
$stampa .= "</div>";
echo $stampa;
echo $foot;
$connessione->close();

?>
