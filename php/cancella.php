<?php

$id = $_GET['id'];
$tab = $_GET['tab'];

$sqlImg = 'SELECT Immagine FROM '.$tab." WHERE Id = ".$id;
$sqlDel = 'DELETE FROM '.$tab.' WHERE Id = '.$id;

require "connessione.php";

$img = $connessione->query($sqlImg);

if(!$img) 
    echo $connessione->error;
else {
        $row = $img->fetch_array(MYSQLI_ASSOC);
        
        if(!$connessione->query($sqlDel)) 
            echo $connessione->error;
        else             
            if(!unlink('images/'.$row["Immagine"]))
                echo "Impossibile cancellare l'immagine";
}

$connessione->close();
    
header("location: ".$_SERVER['HTTP_REFERER']);       


?>