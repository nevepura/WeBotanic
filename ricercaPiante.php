<?php

session_start();
require "elencoPiante.php";
if(empty($_POST)){              //se POST e' vuoto indica che sono arrivato a questa pagina senza cliccare sul form (es Torna indietro)
    if(isset($_SESSION['query'])) { //se SESSION = set ho salvato i valori prima di uscire dalla pagina e li ricarico.
        $query = $_SESSION['query'];
        unset($_SESSION['query']);
    }
}
else {

    $campo = [
        // campo => tabella

        'Bioma' => 'PianteBiomi',
        'Utilizzo' => 'UtilizziPiante',
        'Principio' => 'PrincipiPiante',
    ];


    $query = '';


    $i = 0;
    foreach($campo as $col => $tab){       //$col contiene il nome della colonna $tab della tabella

        if(isset($_POST[$col])) {            //controllo se nel form e' stato impostato il check relativo ad un nome colonna
            $query .= '( SELECT DISTINCT Pianta FROM '.$tab.' WHERE ' ;    //Indico la tabella dove cercare

            foreach($_POST[$col] as $richiesta)   //POST[col] indica il valore della checkbox da ricercare nel database
                $query .= $col.' = "'.$richiesta.'" OR '; //imposto la clausola WHERE con OR alla fine nel caso piu checkbox fossero state impostate

            $query = rimuovi($query, 'OR');

            if($i == 0)
                $query .= ') T'.$i.' ON (NomeScientifico = Pianta) JOIN ' ; //faccio JOIN con le successive query
            else
                $query .= ') T'.$i.' USING (Pianta) JOIN ' ; //faccio JOIN con le successive query
            $i++;
        }
    }

    if(!empty($_POST['ricerca'])){
        $ricerca = strip_tags(trim($_POST['ricerca']));

        $query .= " WHERE (NomeScientifico LIKE '%".$ricerca."%' OR NomeComune LIKE '%".$ricerca."%')";
    }

    if(!empty($query))
        $query = 'SELECT NomeScientifico, Immagine, Descrizione FROM Piante JOIN'.$query;

    $query = rimuovi($query, ' JOIN'); //rimuovo il join finale

}

$head = file_get_contents("templates/headPiante.txt");
$foot = file_get_contents("templates/footPiante.txt");
echo $head;
if(!empty($query)) {

    require "php/connessione.php";

    $output = $connessione->query($query);

    if(!$output) echo servError();
    else {
        $_SESSION['query'] = $query;
        elencoPiante($output);
    }
    $connessione->close();
}
else {
     if(isset($_SESSION['query']))  //se SESSION = set ho salvato i valori prima di uscire dalla pagina e li elimino per evitare di ricaricare ricerche precedenti
        unset($_SESSION['query']);

    $error = " <p id=\"noresults\"> <strong >ATTENZIONE: Devi selezionare almeno un filtro o indicare un nome da ricercare </strong></p>";
    $cont = file_get_contents("templates/contentPiante.txt");
    $cont = str_replace("RicercaFallita", $error, $cont);
    echo $cont;
}

echo $foot;


?>
