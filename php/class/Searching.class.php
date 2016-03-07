<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class Searching
{
	function selectTemp($DBH, $tempID) {
		$query = $DBH->prepare('SELECT staff.username, callinfo.*, temp.firstName, temp.lastName FROM callinfo INNER JOIN temp AS temp ON callinfo.tempID = temp.tempID INNER JOIN staff AS staff on callinfo.staffID = staff.staffID WHERE callinfo.tempID = ?');
		$query->execute(array($tempID));
		$result = $query->fetchALL(PDO::FETCH_ASSOC);
		return $result;
	}

	function selectClientName($DBH, $clientNameID) {
		$clientName = $this->collectClientName($DBH, $clientNameID);
		$query = $DBH->prepare('SELECT * FROM callinfo INNER JOIN clientname AS clientname ON callinfo.clientNameID = clientname.clientNameID INNER JOIN staff AS staff ON callinfo.staffID = staff.staffID WHERE clientname.clientName = ? ORDER BY callinfo.callID DESC');
		$query->execute(array($clientName['clientName']));
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	function collectClientName($DBH, $clientNameID) {
		$query = $DBH->prepare('SELECT clientName FROM clientname WHERE clientNameID = ?');
		$query->execute(array($clientNameID));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}
}