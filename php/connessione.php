<?php 

function servError() {
    return '<p class="errori"> Servizio momentaneamente non disponibile. Riprovare pi&ugrave; tardi</p>';
}

#$hostname = "localhost";
#$username = "fcaldart";
#$password = "iebaemo3Lee4yiwu";
#$database = "fcaldart";

$hostname = "localhost";
$username = "id11225235_webotanic_user";
$password = "webotanic_password";
$database = "id11225235_webotanic";


//creazione connessione
$connessione = new mysqli($hostname, $username, $password, $database);
    
//controllo connessione

if ($connessione->connect_error)
     die("Connessione fallita: Servizio momentaneamente non disponibile. Riprovare pi&ugrave; tardi");
?>
