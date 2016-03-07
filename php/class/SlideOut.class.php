<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class SlideOut {

	function callType($DBH, $callID) {
		$query = $DBH->prepare('SELECT type FROM callinfo WHERE callID = ?');
		$query->execute(array($callID));
		$result = $query->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	function bookings($DBH, $callID) {
		$query = $DBH->prepare('SELECT * FROM callinfo
									LEFT JOIN client AS client on callinfo.clientID = client.clientID
									LEFT JOIN clientname AS clientname ON callinfo.clientNameID = clientname.clientNameID
									INNER JOIN branches AS branches on callinfo.branchID = branches.branchID
									INNER JOIN bookings AS bookings on callinfo.callID = bookings.callID
									WHERE callinfo.callID = ?');
			
		$query->execute(array($callID));
		$result = $query->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	function cancellations($DBH, $callID) {
		$query = $DBH->prepare('SELECT * FROM callinfo
								LEFT JOIN client AS client on callinfo.clientID = client.clientID
								LEFT JOIN clientname AS clientname ON callinfo.clientNameID = clientname.clientNameID
								INNER JOIN branches AS branches on callinfo.branchID = branches.branchID
								INNER JOIN cancellations as cancel on callinfo.callID = cancel.callID
								WHERE callinfo.callID = ?');

		$query->execute(array($callID));
		$result = $query->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	function noShow($DBH, $callID) {
		$query = $DBH->prepare('SELECT * FROM callinfo
								LEFT JOIN client AS client ON callinfo.clientID = client.clientID
								LEFT JOIN clientname AS clientname ON callinfo.clientNameID = clientname.clientNameID
								INNER JOIN branches AS branches on callinfo.branchID = branches.branchID
								INNER JOIN tempnoshow AS tempnoshow ON callinfo.callID = tempnoshow.callID
								WHERE callinfo.callID = ?');

		$query->execute(array($callID));
		$result = $query->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	function clientOther($DBH, $callID) {
		$query = $DBH->prepare('SELECT * FROM callinfo
								LEFT JOIN client AS client ON callinfo.clientID = client.clientID
								LEFT JOIN clientname AS clientname ON callinfo.clientNameID = clientname.clientNameID
								INNER JOIN branches AS branches ON callinfo.branchID = branches.branchID
								WHERE  callinfo.callID = ?');

		$query->execute(array($callID));
		$result = $query->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	function checkin($DBH, $callID) {
		$query = $DBH->prepare('SELECT * FROM callinfo
								INNER JOIN branches AS branches ON callinfo.branchID = branches.branchID
								LEFT JOIN client AS client ON callinfo.clientID = client.clientID
								LEFT JOIN clientname AS clientname ON callinfo.clientNameID = clientname.clientNameID
								WHERE callinfo.callID = ?');

		$query->execute(array($callID));
		$result = $query->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	function sick($DBH, $callID) {
		$query = $DBH->prepare('SELECT * FROM callinfo
								LEFT JOIN clientname as clientname on callinfo.clientNameID = clientname.clientNameID
								LEFT JOIN temp as temp on callinfo.tempID = temp.tempID
								INNER JOIN sickabsent as sick on callinfo.callID = sick.callID
								INNER JOIN branches as branches on callinfo.branchID = branches.branchID
								WHERE callinfo.callID = ?');

		$query->execute(array($callID));
		$result = $query->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	function working($DBH, $callID) {
		$query = $DBH->prepare('SELECT * FROM callinfo
								LEFT JOIN temp AS temp ON callinfo.tempID = temp.tempID
								INNER JOIN working AS working ON callinfo.callID = working.callID
								INNER JOIN branches AS branches ON callinfo.branchID = branches.branchID
								WHERE callinfo.callID = ? ');

		$query->execute(array($callID));
		$result = $query->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	function pay($DBH, $callID) {
		$query = $DBH->prepare('SELECT * FROM callinfo
								LEFT JOIN temp AS temp ON callinfo.tempID = temp.tempID
								INNER JOIN branches AS branches ON callinfo.branchID = branches.branchID
								WHERE callinfo.callID = ? ');

		$query->execute(array($callID));
		$result = $query->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	function tempOther($DBH, $callID) {
		$query = $DBH->prepare('SELECT * FROM callinfo
								LEFT JOIN temp AS temp ON callinfo.tempID = temp.tempID
								INNER JOIN branches AS branches ON callinfo.branchID = branches.branchID
								WHERE callinfo.callID = ? ');

		$query->execute(array($callID));
		$result = $query->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	function advert($DBH, $callID) {
		$query = $DBH->prepare('SELECT * FROM callinfo
								INNER JOIN branches AS branches ON callinfo.branchID = branches.branchID
								LEFT JOIN temp AS temp ON callinfo.tempID = temp.tempID
								INNER JOIN advert AS advert ON callinfo.callID = advert.callID
								WHERE callinfo.callID = ? ');

		$query->execute(array($callID));
		$result = $query->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	function matalan($DBH, $callID) {
		$query = $DBH->prepare('SELECT * FROM callinfo
								INNER JOIN branches AS branches ON callinfo.branchID = branches.branchID
								LEFT JOIN temp AS temp ON callinfo.tempID = temp.tempID
								INNER JOIN advert AS advert ON callinfo.callID = advert.callID
								WHERE callinfo.callID = ? ');

		$query->execute(array($callID));
		$result = $query->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	function headOffice($DBH, $callID) {
		$query = $DBH->prepare('SELECT * FROM callinfo
								INNER JOIN branches AS branches ON callinfo.branchID = branches.branchID
								LEFT JOIN client AS client ON callinfo.clientID = client.clientID
								LEFT JOIN clientname AS clientname ON callinfo.clientNameID = clientname.clientNameID 
								LEFT JOIN temp as temp ON callinfo.tempID = temp.tempID
								WHERE callinfo.callID = ?');

		$query->execute(array($callID));
		$result = $query->fetch(PDO::FETCH_ASSOC);

		return $result;
	}
}