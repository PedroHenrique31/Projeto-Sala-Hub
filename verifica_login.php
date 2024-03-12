<?php

if(!isset($_SESSION)){
	echo 'aaaa';
	session_start();
}


// Temp v
if(!isset($_SESSION['usuario'])){
	header('Location: autenticacao.php');
	exit();
}

if(!$_SESSION['usuario']) {
	header('Location: autenticacao.php');
	exit();
}

?>