<?php
    session_start();
    if(isset($_GET['nome'])){
        $nome = strip_tags(trim($_GET['nome']));
        
       #se la stringa contiene un '_', lo rimpiazzo con uno spazio per permettere la ricerca nel database
       if(strstr($nome,"_")) #se trova la sottostr, ritorna true
           $nome= str_replace("_", " ", $nome);


        $value = 'SELECT NomeScientifico FROM Piante WHERE NomeScientifico = "'.$nome.'"';
        require "php/connessione.php";
        $head = file_get_contents('templates/headPiante.txt');
        $foot = file_get_contents('templates/footPiante.txt');
        
        if(!($f = $connessione->query($value)))
            echo $head.servError().$foot;
        elseif($f->num_rows == 0) {
            require "php/elencoPiante.php";
            
            echo $head;
            elencoPiante($f);
            $connessione->close();
            echo $foot;
        }
        else { //num_rows>0

         $pianta = [
        'Generale' => "SELECT NomeScientifico as Nome_Scientifico, NomeComune as Nome_Comune, NumEsemplari as Numero_Esemplari, AltezzaCm as Altezza_in_cm, Fusto, Radice FROM Piante WHERE NomeScientifico = '$nome'",

        'Immagine' => "SELECT Immagine FROM Piante WHERE NomeScientifico = '$nome'",

        'Foglie' => "SELECT Forma, Composizione, Margine, Superficie FROM Foglie WHERE Pianta = '$nome'",

        'Fiori' => "SELECT NomeFiore as Nome, NumPetali as Numero_Petali, ColoreFiore as Colore FROM Fiori WHERE Pianta = '$nome'",

        'Frutti' => "SELECT NomeFrutto as Nome, ColoreFrutto as Colore FROM Frutti WHERE Pianta = '$nome'",

        'Utilizzi' => "SELECT Utilizzo FROM UtilizziPiante WHERE Pianta = '$nome'",

        'Principi' => "SELECT Principio, Beneficio FROM Principi PR, PrincipiPiante PP where PR.NomePrincipio = PP.Principio AND PP.Pianta = '$nome'",

        'Gruppo' => "SELECT G.Gruppo, G.Divisione, G.Sottodivisione FROM Gruppi G, Piante WHERE G.Id = Piante.Gruppo AND Piante.NomeScientifico = '$nome'",

        'Bioma_terrestre' => "SELECT Nome, Clima, Precipitazioni as Precipitazioni_in_mm, Terreno, SezioneOrto as Sezione_Orto FROM PianteBiomiT, BiomiTerrestri WHERE Pianta = '$nome' AND BiomaT = Nome GROUP BY BiomaT",

        'Bioma_acquatico' => "SELECT Nome, Temperatura, Salinita as 'Salinit&agrave;', SezioneOrto as Sezione_Orto FROM BiomiAcquatici, PianteBiomiA WHERE Pianta = '$nome' AND BiomaA = Nome GROUP BY BiomaA",

        'Provenienza' => "SELECT Stato FROM PianteStati A WHERE A.Pianta = '$nome' ",

        'Descrizione' => "SELECT Descrizione FROM Piante WHERE NomeScientifico = '$nome'",
        ];

        $out = '';
    
        
        foreach($pianta as $key => $sql){
            $result = $connessione->query($sql);
            try{ if(!$result) throw new Exception('errore'); }
            catch(Exception $e){ header('location: errore.html'); }
        
            $title = $key;
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                if($title != ' ') {
                    $out .= "\t<dt class=\"dtesterno\">" . $title . " </dt>\n";  //Stampo il titolo (Es. Generale) una volta sola
                    $title = ' ';
                }

                foreach($row as $indice => $valore) {   //Es Nome scientifico => Eucalyptus
                    if(!empty($valore)){
                        $out .= "\t<dt class=\"dtinterno\">" .$indice. ": </dt>\n";
                        $out .= "\t <dd>" . $valore."</dd> \n" ;
                    }
                }
            }

        }
    $out = "<h2>" . $nome . "</h2> \n <dl id =\"pianta\">\n".$out."</dl> \n";

    if(isset($_SESSION['query'])) //avevo effettuato una ricerca e ritorno ad essa
        $out .= " <p id=\"tornasu\"> <a href='".$_SERVER['HTTP_REFERER']."' >Torna ai risultati della ricerca</a> </p>" ; //torno alla pagina chiamante
    else   // sono arrivato da una delle piante di esempio e voglio rimandare a piante.php per non visualizzare vecchi errori
        $out .=" \n <p  id=\"indietro\"> <a href=\"piante.php\"> Torna alla pagina di ricerca principale </a> </p>";

    $result = ($connessione->query($pianta['Immagine']));
    $img = $result->fetch_array(MYSQLI_ASSOC);
    $sql = 'SELECT Alt FROM Piante WHERE NomeScientifico="'.$nome.'"';
    $result = ($connessione->query($sql));
    $alt = $result->fetch_array(MYSQLI_ASSOC);
    $tag = '<dd id="immaginePianta"><img src="images/piante/' . $img['Immagine'] . '" alt="'.$alt['Alt'].'"/></dd>';
    $out = str_replace("<dd>".$img['Immagine']."</dd>", $tag, $out);
    $out = str_replace('_', ' ', $out);
    $out = str_replace('<dt class="dtinterno">Immagine: </dt>', ' ', $out);
    $result->close();
    $connessione->close();

    $head = file_get_contents("templates/headPiante.txt");
    $foot = file_get_contents("templates/footPiante.txt");

    echo $head;
    echo $out;
    echo $foot;

    }
}
else //GET is not set
    header ('location: errore.html');




?>
