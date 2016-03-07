<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class Recall
{
	function bookingRecall($DBH, $callID) {
		$query = $DBH->prepare('SELECT * FROM callinfo
									INNER JOIN branches AS branches ON callinfo.branchID = branches.branchID
									INNER JOIN bookings AS bookings ON callinfo.callID = bookings.callID
									LEFT JOIN client AS client ON callinfo.clientID = client.clientID
									LEFT JOIN clientname AS clientname ON callinfo.clientNameID = clientname.clientNameID
									WHERE callinfo.callID = ?');
		$query->execute(array($callID));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	function cancelRecall($DBH, $callID) {
		$query = $DBH->prepare('SELECT * FROM callinfo
									INNER JOIN branches AS branches ON callinfo.branchID = branches.branchID
									INNER JOIN cancellations AS cancellations ON callinfo.callID = cancellations.callID
									LEFT JOIN client AS client ON callinfo.clientID = client.clientID
									LEFT JOIN clientname AS clientname ON callinfo.clientNameID = clientname.clientNameID
									WHERE callinfo.callID = ?');
		$query->execute(array($callID));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	function TempNoShowRecall($DBH, $callID) {
		$query = $DBH->prepare('SELECT * FROM callinfo
									LEFT JOIN client as client on callinfo.clientID = client.clientID
									LEFT JOIN clientname as clientname on callinfo.clientNameID = clientname.clientNameID
									INNER JOIN tempnoshow as tempnoshow on callinfo.callID = tempnoshow.callID
									INNER JOIN branches as branches on callinfo.branchID = branches.branchID
									WHERE callinfo.callID = ?');
		$query->execute(array($callID));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	function clientIssuesRecall($DBH, $callID) {
		$query = $DBH->prepare('SELECT * FROM callinfo
									INNER JOIN branches AS branches ON callinfo.branchID = branches.branchID
									LEFT JOIN client AS client ON callinfo.clientID = client.clientID
									LEFT JOIN clientname AS clientname ON callinfo.clientNameID = clientname.clientNameID
									WHERE callinfo.callID = ?');
		$query->execute(array($callID));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	function checkinRecall($DBH, $callID) {
		$query = $DBH->prepare('SELECT * FROM callinfo
									INNER JOIN branches AS branches ON callinfo.branchID = branches.branchID
									LEFT JOIN client AS client ON callinfo.clientID = client.clientID
									LEFT JOIN clientname AS clientname ON callinfo.clientNameID = clientname.clientNameID
									WHERE callinfo.callID = ?');
		$query->execute(array($callID));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	function sickRecall($DBH, $callID) {
		$query = $DBH->prepare('SELECT * FROM callinfo
									LEFT JOIN clientname as clientname on callinfo.clientNameID = clientname.clientNameID
									INNER JOIN temp as temp on callinfo.tempID = temp.tempID
									INNER JOIN sickabsent as sickabsent on callinfo.callID = sickabsent.callID
									INNER JOIN branches as branches on callinfo.branchID = branches.branchID
									WHERE callinfo.callID = ?');
		$query->execute(array($callID));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	function payRecall($DBH, $callID) {
		$query = $DBH->prepare('SELECT * FROM callinfo
								INNER JOIN branches AS branches ON callinfo.branchID = branches.branchID
								INNER JOIN temp AS temp ON callinfo.tempID = temp.tempID
								WHERE callinfo.callID = ?');
		$query->execute(array($callID));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	function otherRecall($DBH, $callID) {
		$recall = $DBH->prepare('SELECT * FROM callinfo
								INNER JOIN branches AS branches ON callinfo.branchID = branches.branchID
								INNER JOIN temp AS temp ON callinfo.tempID = temp.tempID
								WHERE callinfo.callID = ?');
		$recall->execute(array($callID));
		$result = $recall->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	function workingRecall($DBH, $callID) {
		$query = $DBH->prepare('SELECT * FROM callinfo
									INNER JOIN temp AS temp ON callinfo.tempID = temp.tempID
									INNER JOIN branches AS branches ON callinfo.branchID = branches.branchID
									INNER JOIN working AS working ON callinfo.callID = working.callID
									WHERE callinfo.callID = ?');
		$query->execute(array($callID));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	function matalanRecall($DBH, $callID) {
		$query = $DBH->prepare('SELECT * FROM callinfo
									LEFT JOIN temp AS temp ON callinfo.tempID = temp.tempID
									INNER JOIN advert AS advert on callinfo.callID = advert.callID
									INNER JOIN branches AS branches on callinfo.branchID = branches.branchID
									WHERE callinfo.callID = ? ');
		$query->execute(array($callID));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	function advertRecall($DBH, $callID) {
		$query = $DBH->prepare('SELECT * FROM callinfo
									LEFT JOIN temp AS temp ON callinfo.tempID = temp.tempID
									INNER JOIN advert AS advert on callinfo.callID = advert.callID
									INNER JOIN branches AS branches on callinfo.branchID = branches.branchID
									WHERE callinfo.callID = ? ');
		$query->execute(array($callID));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	function headClientRecall($DBH, $callID) {
		$query = $DBH->prepare('SELECT * FROM callinfo
								LEFT JOIN client as client on callinfo.clientID = client.clientID
								LEFT JOIN clientname as clientname on callinfo.clientNameID = clientname.clientNameID
								INNER JOIN branches as branches on callinfo.branchID = branches.branchID
								WHERE callinfo.callID = ?');
		$query->execute(array($callID));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	function headTempRecall($DBH, $callID) {
		$query = $DBH->prepare('SELECT * FROM callinfo
								LEFT JOIN temp as temp on callinfo.tempID = temp.tempID
								INNER JOIN branches as branches on callinfo.branchID = branches.branchID
								WHERE callinfo.callID = ?');
		$query->execute(array($callID));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	function feedbackRecall($DBH, $feedID) {
		$query = $DBH->prepare('SELECT * FROM feedback
								INNER JOIN branches AS branches ON feedback.branchID = branches.branchID
								LEFT JOIN staff AS staff ON feedback.staffID = staff.staffID
								WHERE feedback.feedID = ?');
		$query->execute(array($feedID));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	function timeRecall($DBH, $timeID) {
		$query = $DBH->prepare('SELECT *
									FROM staff, timesheet, branches
									WHERE branches.branchID = staff.branchID
									AND staff.staffID = timesheet.staffID
									AND timeID = ?');
		$query->execute(array($timeID));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	function holidayRecall($DBH, $holidayID) {
		$query = $DBH->prepare('SELECT * FROM holidays, staff 
									WHERE holidays.staffID = staff.staffID
									AND holidays.holidayID = ?');
		$query->execute(array($holidayID));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	function cvRecall($DBH, $callID) {
		$query = $DBH->prepare('SELECT * FROM callinfo AS callinfo
									LEFT JOIN clientname AS clientname ON callinfo.clientNameID = clientname.clientNameID
									LEFT JOIN cvsearch as cvsearch ON callinfo.callID = cvsearch.callID
									LEFT JOIN staff as staff ON callinfo.staffID = staff.staffID
									LEFT JOIN branches as branches ON callinfo.branchID = branches.branchID
									WHERE callinfo.callID = ?');
		$query->execute(array($callID));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}
}