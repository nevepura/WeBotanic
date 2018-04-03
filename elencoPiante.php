<?php

//stampa la lista dell'elenco piante che soddisfano la ricerca

function elencoPiante($elem) { //ho l'elenco con nome, immagine e descrizione delle piante. Per ogni riga devo stampare
    $stampa = "<p> Risultato della ricerca: </p> \t ";

    if($elem->num_rows == 0) {
        if(isset($_SESSION['query']))  //se SESSION = set ho salvato i valori prima di uscire dalla pagina e li elimino per evitare di ricaricare ricerche precedenti
            unset($_SESSION['query']);

        $content = file_get_contents("templates/contentPiante.txt");
        $content = str_replace('RicercaFallita', ' <p id="noresults"> <strong> Nessun risultato trovato. Si prega di usare nuovi parametri. </strong></p>', $content);
        $stampa .= $content;
    }
    else {
        $stampa .= "<ul id =\"piante\">\n";

        foreach($elem as $campo => $valore) {
            $stampa .= "\t<li> <a href='stampaPianta.php?nome=". $valore['NomeScientifico'] . "'>".$valore['NomeScientifico']."
            <img src=\"images/piante/".$valore['Immagine'] . "\" alt=\"pianta di ".$valore["NomeScientifico"]."\"/> </a> </li>\n";
        }
        $stampa .= "</ul> \n  \n

			             <p id=\"tornasu\"><a href= '#header'>Torna a inizio pagina</a></p>";
    }
        $stampa .= "\n ";
        echo $stampa;

}

//permette di rimuovere dalla stringa input il valore value
function rimuovi($input, $value) {
    $pos = strrpos($input, $value);
    return substr_replace($input, '', $pos, strlen($value));
}

?>
