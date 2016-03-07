<?php
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';
require_once $root.'/assets/php/class/Searching.class.php';
$search = new Searching();

if(isset($_POST['type']) && ($_POST['type'] == "temp")) {
	$_SESSION['search']['results'] = '';
	$_SESSION['search']['results'] = $search->selectTemp($DBH, $_POST['id']);
	$_SESSION['search']['type'] = "temp";

	$success = 'success';
	echo json_encode($success);
}
if(isset($_POST['type']) && ($_POST['type'] == "clientname")) {
	$_SESSION['search']['results'] = '';
	$_SESSION['search']['results'] = $search->selectClientName($DBH, $_POST['id']);
	$_SESSION['search']['type'] = "clientname";

	$success = 'success';
	echo json_encode($success);
}