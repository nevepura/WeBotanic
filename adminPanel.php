<?php
	session_start();
	# se non sono loggato, vai alla pagina di errore. Questo può accadere scrivendo  un URL della parte di amministrazione senza entrare dalla pagina di login
	if( !isset($_SESSION['logged']) or $_SESSION['logged']==0)
		header("Location: errore.html");
	else
	{
		// ($_SESSION['logged']==1) 
		$page= file_get_contents("templates/admin/adminPanel.txt");
		echo $page;
	}	
?>