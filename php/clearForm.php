<?php
	$referer = htmlentities($_SERVER['HTTP_REFERER']);
	session_start();
	unset($_SESSION['form']);
	unset($_SESSION['call']);
	if(isset($_SESSION['tempCall'])){
		unset($_SESSION['tempCall']);
	}
	if(isset($_SESSION['clientCall'])){
		unset($_SESSION['clientCall']);
	}
	if(isset($_SESSION['tempCallDetails'])){
		unset($_SESSION['tempCallDetails']);
	}
	if(isset($_SESSION['clientCallDetails'])){
		unset($_SESSION['clientCallDetails']);
	}
	if(isset($_SESSION['callIDDetails'])){
		unset($_SESSION['callIDDetails']);
	}
	echo '<script>window.location.href = "'.$referer.'";</script>';