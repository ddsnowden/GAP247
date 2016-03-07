<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class Counter
{

	function total($DBH, $staffID) {
		$contactList = $DBH->prepare('SELECT count(status) as count FROM callinfo WHERE staffID = ? AND status = "Completed"');
		$contactList->execute(array($staffID));
		$result = $contactList->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	function emailed($DBH, $staffID) {
		$contactList = $DBH->prepare('SELECT count(status) as count FROM callinfo WHERE staffID = ? AND emailed = "Not Emailed" AND (type != "" and type != "checkinsBlank" and type != "checkin")');
		$contactList->execute(array($staffID));
		$result = $contactList->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	function out($DBH, $staffID) {
		$out = $DBH->prepare('SELECT count(callID) as count FROM callinfo WHERE staffID = ? AND status = "Outstanding" AND (type != "" and type != "checkinsBlank" and type != "checkin")');
		$out->execute(array($staffID));
		$result = $out->fetch(PDO::FETCH_ASSOC);
		return $result;
	}
}