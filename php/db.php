<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}


	$user = '';
	$pass = '';

	$DBH = new PDO('mysql:host=localhost;dbname=nightline;', 
		$user, $pass, 
		array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false));
?>
