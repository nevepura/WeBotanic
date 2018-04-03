<?php
session_start();

require_once('campiPiante.php');
require_once('funzioni.php');

insPost($generale);

$err = '';
$err .= controllaNome($generale['NomeScientifico'], 'Nome Scientifico');

$err .= controllaNome($generale['NomeComune'], 'Nome Comune');

if(empty($generale['Gruppo'])){
    $err.= "<li>Gruppo obbligatorio</li>\n";
}
else{
    if( ($generale['Gruppo'] =='A' || $generale['Gruppo'] == 'B') && (!empty($generale['Radice']) || !empty($generale['Fusto'])) ) {
        $err .= "<li>I gruppi A e B non possono avere Fusto e/o Radice</li>\n";
    }     
}

if(!preg_match('/^(?:[1-9]\d{0,3}|0)$/', $generale['AltezzaCm'])){
    $err .= "<li>Altezza non valida</li>\n";
}

if(!preg_match('/^(?:[1-9]\d{0,2}|0)$/',$generale['NumEsemplari'])) {
    $err .= "<li>Numero esemplari non valido</li>\n";
}

if(!preg_match('/^(\w|[àèìòù\s,\'.\-;:]?)*$/',$generale['Descrizione'])) {
    $err .= "<li>Descrizione non valida</li>\n";
}

if($generale['Alt'] == '')
    $err .= '<li>Il testo alternativo non pu&ograve essere vuoto</li>';
else
    $err .= controllaAlt($generale['Alt']);

insPost($foglia);
$foglia = ['Pianta' => $generale['NomeScientifico']] + $foglia;

if(($generale['Gruppo'] =='A' || $generale['Gruppo'] == 'B') && (!empty($foglia['Forma']) || !empty($foglia['Composizione']) || !empty($foglia['Margine']) || !empty($foglia['Superficie']))) {
    $err .= "<li>I gruppi A e B non possono avere foglie</li>\n";
}

insPost($fiore);
$fiore = ['Pianta' => $generale['NomeScientifico']] + $fiore;

if( $generale['Gruppo'] != 'TSA' && (!empty($fiore['NomeFiore']) || !empty($fiore['ColoreFiore']) || !empty($fiore['NumPetali'])) ) {
    $err .= "<li>Gruppi diversi da TSA non possono avere fiori</li>\n";
}

$err .= controllaNomeMin($fiore['NomeFiore'], 'Nome fiore');
$err .= controllaNomeMin($fiore['ColoreFiore'], 'Colore fiore');

if(!preg_match('/^(?:[1-9]\d{0,1}|0){0,1}$/', $fiore['NumPetali'])) {
    $err .= "<li>Numero petali non valido</li>\n";
}   
   
insPost($frutto);
$frutto = ['Pianta' => $generale['NomeScientifico']] + $frutto;

if( $generale['Gruppo'] != 'TSA' && (!empty($frutto['NomeFrutto']) || !empty($frutto['ColoreFrutto']))){
    $err .= "<li>Gruppi diversi da TSA non possono avere frutto </li>";
}

$err .= controllaNomeMin($frutto['NomeFrutto'], 'Nome Frutto');
$err .= controllaNomeMin($frutto['ColoreFrutto'], 'Colore frutto');

if(!isset($_POST['Utilizzo'])){
    $err .= "<li>Seleziona almeno un utilizzo</li>\n";
}

if(!isset($_POST['Stato'])){
    $err .= "<li>Seleziona almeno uno stato</li>\n";
}

if(!isset($_POST['BiomaT']))
    if(!isset($_POST['BiomaA']))
        $err .= "<li>Seleziona almeno un bioma</li>\n";

if(empty($err)){
    $temp = controlloImmagine('images/piante/');
    $err .= $temp[0];
    $immagine = $temp[1];
    if(empty($immagine))
        $err .= "<li> Immagine obbligatoria </li> \n";
}
                               
if(empty($err)){
    
    $generale['Immagine'] = $immagine;    
    require('connessione.php');
    $msg = '';
    $msg .= insDB_single($generale, 'Piante',$connessione);
    $msg .= insDB_single($foglia, 'Foglie',$connessione);
    $msg .= insDB_single($fiore, 'Fiori',$connessione);
    $msg .= insDB_single($frutto, 'Frutti',$connessione);
    $msg .= insDB_multiple($_POST['Utilizzo'], 'UtilizziPiante', $generale['NomeScientifico'],$connessione);
    $msg .= insDB_multiple($_POST['Stato'], 'PianteStati', $generale['NomeScientifico'],$connessione);
    if(isset($_POST['BiomaA']))
        $msg .= insDB_multiple($_POST['BiomaA'], 'PianteBiomiA', $generale['NomeScientifico'],$connessione);
    if(isset($_POST['BiomaT']))
        $msg .= insDB_multiple($_POST['BiomaT'], 'PianteBiomiT', $generale['NomeScientifico'],$connessione);
    if(isset($_POST['Principio']))
          $msg .= insDB_multiple($_POST['Principio'], 'PrincipiPiante', $generale['NomeScientifico'],$connessione);
    
    $connessione->close();
    
   if($msg=='') {    
        $_SESSION['conferma'] = conferma('Pianta');
        header("location: ../insPianta.php");
   }
    else {
        $_SESSION["errori"] = servError();
        header("location: ../insPianta.php");
    }
} //se ci sono errori
else { 
      $_SESSION["errori"] = ulError($err);
      header("location: ../insPianta.php");
}
?>
