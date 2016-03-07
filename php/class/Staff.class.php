<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class Staff
{
	function details($DBH, $staffID) {
		$query = $DBH->prepare('SELECT * FROM staff WHERE staffID = ?');
		$query->execute(array($staffID));
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	function staffList($DBH) {
		$query = $DBH->prepare('SELECT * FROM staff WHERE branchID = "27" AND finishDate = "00-00-0000"');
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	function staffListAll($DBH) {
		$query = $DBH->prepare('SELECT * FROM staff INNER JOIN branches AS branches ON staff.branchID = branches.branchID WHERE staff.branchID != "27" AND finishDate = "00-00-0000"');
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	public function staffTotals($DBH) {
		$query = $DBH->prepare('SELECT staff.username, count(callID) AS count FROM callinfo 
								INNER JOIN staff AS staff ON callinfo.staffID = staff.staffID 
								INNER JOIN branches AS branches ON branches.branchID = staff.branchID 
								WHERE (type != "checkin" AND type != "checkinsBlank" AND type != "checkin_outstanding")
								AND staff.branchID = 27
								GROUP BY callinfo.staffID
								ORDER BY count DESC'); 
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		return $result;
	}
}