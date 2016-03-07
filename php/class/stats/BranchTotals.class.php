<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';
require_once $root.'/assets/php/class/stats/Totals.class.php';

class BranchTotals extends Totals {

	public function branches($DBH) {
		$query = $DBH->prepare('SELECT branchName from branches');
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		return $result;
	}

	public function bTotals($DBH, $dates, $branches) {
		$query = $DBH->prepare('SELECT count(callID) AS count 
								FROM callinfo INNER JOIN branches AS branches on callinfo.branchID = branches.branchID 
								WHERE (type != "checkin" AND type != "checkinsBlank" AND type != "checkin_outstanding") 
								AND dateInputted = ? 
								AND branches.branchName = ? 
								AND status = "Completed"');

		foreach ($dates as $key) {
	 		$query->execute(array($key['datefield'], $branches));
	 		$calls[] = $query->fetch(PDO::FETCH_ASSOC);
	 	}

	 	$combined = array();
		for ($i=0; $i < count($dates); $i++) { 
			$combined[] = array($dates[$i]['datefield'], (int)$calls[$i]['count']);
		}

		$combined = json_encode($combined);

		return $combined;
	}

	public function percentTotals($DBH) {
		$query = $DBH->prepare('SELECT branchName, count(callID) as count 
								FROM callinfo INNER JOIN branches AS branches ON callinfo.branchID = branches.branchID 
								WHERE (type != "checkin" AND type != "checkinsBlank" AND type != "checkin_outstanding") 
								GROUP BY callinfo.branchID 
								ORDER BY count DESC');
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		return $result;
	}
}