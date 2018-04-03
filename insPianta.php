<?php
session_start();

# se non sei loggato, errore
if( !isset($_SESSION['logged']) or $_SESSION['logged']==0)
		header("Location: errore.html");
else
{
	$pagina = file_get_contents('templates/admin/insPianta.txt');
    
	if(isset($_SESSION['errori'])) {
	    $pagina = str_replace('{messaggio}', $_SESSION['errori'], $pagina);
	    unset($_SESSION['errori']);
	}
	else{
	   if(isset($_SESSION['conferma'])) {
	       $pagina = str_replace('{messaggio}', $_SESSION['conferma'], $pagina);
	       unset($_SESSION['conferma']);
	   }
	   else
	       $pagina = str_replace('{messaggio}', '', $pagina);
	  }
	   
	echo $pagina;
}

?>