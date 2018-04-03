<?php 

function servError() {
    return '<p class="errori"> Servizio momentaneamente non disponibile. Riprovare pi&ugrave; tardi</p>';
}

$hostname = "localhost";
$username = "fcaldart";
$password = "iebaemo3Lee4yiwu";
$database = "fcaldart";

//creazione connessione
$connessione = new mysqli($hostname, $username, $password, $database);
    
//controllo connessione

if ($connessione->connect_error)
     die("Connessione fallita: Servizio momentaneamente non disponibile. Riprovare pi&ugrave; tardi");
?>
