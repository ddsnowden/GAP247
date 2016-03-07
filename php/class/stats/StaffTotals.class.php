<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';
require_once $root.'/assets/php/class/stats/Totals.class.php';

class StaffTotal extends Totals{

	public function staffList($DBH) {
		$query = $DBH->prepare('SELECT username, staffNameFirst, staffNameLast FROM staff WHERE branchID = 27');
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

	public function STCalls($DBH, $dates, $username) {
		$query = $DBH->prepare('SELECT count(callID) AS count 
								FROM callinfo INNER JOIN staff AS staff on callinfo.staffID = staff.staffID
								WHERE (type != "checkin" AND type != "checkinsBlank" AND type != "checkin_outstanding") 
								AND dateInputted = ? 
								AND staff.username = ? 
								AND status = "Completed"');

		foreach ($dates as $key) {
	 		$query->execute(array($key['datefield'], $username));
	 		$calls[] = $query->fetch(PDO::FETCH_ASSOC);
	 	}

	 	$combined = array();
		for ($i=0; $i < count($dates); $i++) { 
			$combined[] = array($dates[$i]['datefield'], (int)$calls[$i]['count']);
		}

		$combined = json_encode($combined);

		return $combined;
	}

	public function bookings($DBH, $username) {
		$bookfill = $DBH->prepare('SELECT sum(quantity) as booked, sum(filled) as filled 
									FROM bookings 
									INNER JOIN callinfo AS callinfo ON bookings.callID = callinfo.callID
									INNER JOIN staff AS staff ON callinfo.staffID = staff.staffID
									WHERE staff.username = ?');
		$bookfill->execute(array($username));
		$result = $bookfill->fetch(PDO::FETCH_ASSOC);

	    return $result;
	}

	public function noShows($DBH, $username) {
		$noShow = $DBH->prepare('SELECT sum(noQuantity) AS noQuant, sum(fillQuantity) AS filled 
									FROM tempnoshow 
									INNER JOIN callinfo AS callinfo ON tempnoshow.callID = callinfo.callID
									
									WHERE callinfo.callID = tempnoshow.callID 
									AND callinfo.staffID = staff.staffID 
									AND staff.staffID = ?');
		$noShow->execute(array($staffID));
		$NSTotals = $noShow->fetchAll(PDO::FETCH_ASSOC);

	    return $result;
	}

	public function type($DBH, $username) {
		$query = $DBH->prepare('SELECT count(callID) AS count, type 
								FROM `callinfo` 
								INNER JOIN staff AS staff ON callinfo.staffID = staff.staffID
								WHERE staff.username = ? 
								GROUP BY type');
		$query->execute(array($username));
		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		$type = '';
		foreach ($result as $key) {
			$type .= "'".ucwords($key['type'])."',";
		}
		$categories = rtrim($type,',');

		$c = '';
		foreach ($result as $key) {
			$c .= $key['count'].",";
		}
		$count = rtrim($c,',');

		$type = array('cat' => $categories, 'count' => $count);

		return $type;
	}
}