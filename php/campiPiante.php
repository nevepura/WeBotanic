<?php
$generale = ['NomeScientifico' => '', 
             'NomeComune' => '', 
             'NumEsemplari' => '', 
             'AltezzaCm' => '', 
             'Descrizione' => '', 
             'Gruppo' => '', 
             'Fusto' => '', 
             'Radice'=> '',
             'Descrizione' => '',
             'Immagine' => '',
             'Alt' => '',
            ];

$foglia = ['Forma' => '', 
           'Composizione' => '', 
           'Margine' => '', 
           'Superficie' => '',
          ]; 

$fiore = [  'NomeFiore' => '',
            'NumPetali' => '',  
            'ColoreFiore' => '',
            
         ];

$frutto = [ 'NomeFrutto' => '',
           'ColoreFrutto' => '',
          ];

function insPost (&$array) {
    foreach($array as $col => $val)
        if($val == '' && isset($_POST[$col])){
               $array[$col] = $_POST[$col];
        }
 }

function insDB_single($array, $tab, $con) {
    $ins = "INSERT INTO ".$tab." VALUES (";
    foreach($array as $col => $val){
        if($val=='')
            $ins .= "NULL, ";
        else
            $ins .= "'".$val."', ";
        
    }
    
    $pos = strrpos($ins, ',');
    $ins = substr_replace($ins, ')', $pos);
    echo $ins;
    if(!$con->query($ins))
        return $con->error;
    else
        return '';
}

function insDB_multiple($array, $tab, $key, $con) {
    $ins = "INSERT INTO ".$tab." VALUES ";
    foreach($array as $value)
        $ins .= "('".$key."', '".$value."'),";
        
    $pos = strrpos($ins, ',');
    $ins = substr_replace($ins, ';', $pos);
    if(!$con->query($ins))
         return $con->error;
    else
        return '';
}
?>
