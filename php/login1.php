<?php
	//crea o attiva la sessione
	session_start();
	
	// user e pwd corretti => entro
	if ($_POST['username']=='admin' and $_POST['password']=='admin')
	{
		$_SESSION['wrong_login']=0;
		$_SESSION['logged']= 1;
		header("Location: ../adminPanel.php");
	}
	
	// user || pwd errati => resto nella pagina e lo segnalo
	else 
	{
		$_SESSION['wrong_login']= 1; // flag degli errori: sbaglio le credenziali, ricarico la pagina adminLogin.php con il mess di errore.
		header("Location: ../adminLogin.php");
	}

?>