<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

function callCheck($DBH) {
	$emailed = 'Not Emailed';
	$checkSearch = $DBH->prepare('SELECT count(callID) as count FROM callinfo, staff WHERE callinfo.staffID = staff.staffID AND staff.branchID = 27 AND emailed = ? AND (type !=  "checkin" AND type !=  "checkinsBlank" AND type !=  "checkin_outstanding") ');
	$checkSearch->execute(array($emailed));
	$CSResult = $checkSearch->fetch(PDO::FETCH_ASSOC);
	$result = $CSResult['count'];
	return $result;
}

function callCheckIndiv($DBH) {
	$emailed = 'Not Emailed';
	$staffID = $_SESSION['login']['staffID'];
	$checkSearch = $DBH->prepare('SELECT count(callID) as count FROM callinfo WHERE callinfo.staffID = staff.staffID AND staff.branchID = 27 AND emailed = ? and staffID = ? AND (type !=  "checkin" AND type !=  "checkinsBlank" AND type !=  "checkin_outstanding")');
	$checkSearch->execute(array($emailed, $staffID));
	$CSResult = $checkSearch->fetch(PDO::FETCH_ASSOC);
	$result = $CSResult['count'];
	return $result;
}


if($_SESSION['login']['access'] == '2') {
	$result = callCheck($DBH);
}
else {
	$result = callCheckIndiv($DBH);
}


if ($result != "0") {
	$result = "exists";
}
else {
	$result = "empty";
}

echo json_encode($result);