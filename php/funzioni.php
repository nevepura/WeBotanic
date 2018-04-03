<?php

function controllaData($m, $g, $a, $tipo){
    if(checkdate ($m, $g, $a))
        return '';
    else
        return "<li>Data ".$tipo." non valida</li>\n";
}

function ulError($err) {
    return '<ul class="errori">'.$err.'</ul>';
}

function conferma($tipo) {
    return '<p class="conferma">Inserimento '.$tipo.' avvenuto con successo.</p>';
}

function controllaAlt($alt) {
    if(!preg_match('/^[A-Za-z0-9\s&;,]{0,200}$/', $alt)) 
        return "<li>Testo alternativo non valido. Massimo 200 caratteri alfanumerici</li>\n";
    else return '';
}

function controllaNome($nome, $tipo) {
    if(!preg_match('/^[a-zA-Zàèìòù\s]{2,50}$/',$nome))
        return "<li>".$tipo." non valido. Inserire da 2 a 50 caratteri. </li> \n";
    else return '';
}

function controllaTitolo ($titolo, $tipo){
    if(strlen($titolo)<5 || strlen($titolo>100)) 
        return "<li>".$tipo." non valido </li> \n";
    else
        return '';
}

function controllaNomeMin($nome, $tipo){
   if(!preg_match('/^[A-Za-z\s]{0,20}$/', $nome))
       return "<li>".$tipo." non valido o troppo lungo</li>\n";
    else
        return '';

}

function controlloImmagine($dir) {
    
    if(isset($_FILES['immagine']) && is_uploaded_file($_FILES['immagine']['tmp_name'])) {

        $err = '';
 
        
        $img_temp = $_FILES['immagine']['tmp_name'];
        $img_nome = $_FILES['immagine']['name'];
        $img_size = $_FILES['immagine']['size'];
        $img_tipo = $_FILES['immagine']['type'];
    
        if ($img_size > 307200)  
            $err .= "<li>Il file è troppo grande!</li> \n";
       
        $file =  $dir . $img_nome;
        if (file_exists($file)) 
            $err .= "<li>Il file esiste già</li> \n";
           
            $estensioni = ['image/jpg', 'image/jpeg'];
            if (!in_array($img_tipo, $estensioni)) 
                $err .= "<li>Il file ha un estensione non ammessa!</li>\n";
     
            //controllo se e' un immagine, ulteriore controllo oltre al tipo (es cambi estensione pdf in jpg)
            if (!getimagesize($img_temp))
                $err .= "<li>Il file non è un'immagine!</li> \n";
            
            if($err == '')      
                if(!move_uploaded_file($img_temp, '../' . $dir.$img_nome)) 
                    $err .= "<li>Fallimento nel caricare l'immagine</li> \n";  
        
            $out = [$err, $img_nome];
        }
    else
        $out = ['',''];
    
    return $out;
    
}