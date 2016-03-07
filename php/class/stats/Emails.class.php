<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';
require_once $root.'/assets/php/class/stats/CallsEmail.class.php';

class Email extends CallsEmail {
	//collect all completed and emailedDateTimes for all calls in database
	function emailStats($DBH) {
		$query = $DBH->prepare('SELECT callinfo.completed, callinfo.emailDateTime, TIMESTAMPDIFF(SECOND, callinfo.completed, callinfo.emailDateTime) AS diff, staff.username, staff.staffID FROM callinfo 
								INNER JOIN staff AS staff ON callinfo.staffID = staff.staffID
								WHERE callinfo.callID > 22629
								AND staff.branchID = 27
								AND TIMESTAMPDIFF(SECOND, callinfo.completed, callinfo.emailDateTime) >= 0
								AND callinfo.emailDateTime IS NOT NULL
								ORDER BY diff ASC');
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	function nonEmailed($DBH) {
		$query = $DBH->prepare('SELECT count(callID) as count FROM callinfo 
								INNER JOIN staff AS staff ON callinfo.staffID = staff.staffID
								WHERE callinfo.callID > 22629
								AND staff.branchID = 27
								AND callinfo.emailDateTime IS NULL');
		$query->execute();
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	function emailStatsIndiv($DBH, $staffID) {
		$query = $DBH->prepare('SELECT callinfo.completed, callinfo.emailDateTime, TIMESTAMPDIFF(SECOND, callinfo.completed, callinfo.emailDateTime) AS diff, staff.username, staff.staffID FROM callinfo 
								INNER JOIN staff AS staff ON callinfo.staffID = staff.staffID
								WHERE callinfo.callID > 22629
								AND staff.staffID = ?
								AND TIMESTAMPDIFF(SECOND, callinfo.completed, callinfo.emailDateTime) >= 0
								AND callinfo.emailDateTime IS NOT NULL
								ORDER BY diff ASC');
		$query->execute(array($staffID));
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	function nonEmailedIndiv($DBH, $staffID) {
		$query = $DBH->prepare('SELECT count(callID) as count FROM callinfo 
								INNER JOIN staff AS staff ON callinfo.staffID = staff.staffID
								WHERE callinfo.callID > 22629
								AND staff.staffID = ?
								AND callinfo.emailDateTime IS NULL');
		$query->execute(array($staffID));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}
}