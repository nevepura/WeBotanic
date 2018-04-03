<?php
session_start();
# se non sei loggato, errore
if( !isset($_SESSION['logged']) or $_SESSION['logged']==0)
        header("Location: errore.html");
else
{

    $sql = "SELECT Id, Titolo, DataPub FROM Notizie";

    require "php/connessione.php";

    $output = $connessione->query($sql);
    $page = file_get_contents("templates/admin/visualNotizie.txt");

    if(!$output) {
        $stampa = servError() ;
        $page = str_replace('contenuto', $stampa, $page);
    }
    else {
        $stampa = "";
        if($output->num_rows == 0) {
            $stampa .= "<p class=\"content\"> <p> Nessuna notizia trovata </p><p id=\"indietro\"><a href= \"adminPanel.php\">Torna al menu precedente</a></p> </div>";
            $page = str_replace('contenuto', $stampa, $page);
        }
        else {
             $table = file_get_contents('templates/admin/tabVisualNotizie.txt');

             foreach($output as $campo => $cont) {

                $stampa .= "<tr> \n \t";

                foreach($cont as $i => $val) {

                    $stampa .= "<td>".$val."</td> \n \t";
                }

                 $stampa .= "<td class=\"delete\" > \n \t \t
                                <a href=\"php/cancella.php?id=".$cont['Id']."&amp;tab=Notizie\" class=\"cancella\">Cancella</a> \n \t
                                </td> \n \t </tr>";
            }


            $table =str_replace('corpoTabella', $stampa, $table);
            $page = str_replace('contenuto', $table, $page);

        }
    }
    
    echo $page;
    

    $connessione->close();
}

?>
