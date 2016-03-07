<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

function callCheck($DBH) {
	$dateToCall = date("Y-m-d");
	$time = date("H:i:s");
	$type = "checkin";
	$status = "Outstanding";
	$checkSearch = $DBH->prepare('SELECT count(callID) as count FROM callinfo WHERE type = ? AND dateToCall = ? AND timeToCall <= ? AND status = ?');
	$checkSearch->execute(array($type, $dateToCall, $time, $status));
	$CSResult = $checkSearch->fetch(PDO::FETCH_ASSOC);
	$result = $CSResult['count'];
	return $result;
}

$result = callCheck($DBH);

if ($result != "0") {
	$result = "exists";
}
else {
	$result = "empty";
}

echo json_encode($result);