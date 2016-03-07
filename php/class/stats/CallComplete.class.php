<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';
require_once $root.'/assets/php/class/stats/CallsEmail.class.php';
require_once $root.'/assets/php/class/Staff.class.php';


class Calls extends CallsEmail {

	function callStats($DBH) {
		$query = $DBH->prepare("SELECT callinfo.completed, STR_TO_DATE(CONCAT(callinfo.dateInputted, ' ', callinfo.timeInputted), '%Y-%m-%d %H:%i:%s'), TIMESTAMPDIFF(SECOND, STR_TO_DATE(CONCAT(callinfo.dateInputted, ' ', callinfo.timeInputted), '%Y-%m-%d %H:%i:%s'), callinfo.completed) AS diff, staff.username, staff.staffID FROM callinfo 
			INNER JOIN staff AS staff ON callinfo.staffID = staff.staffID
			WHERE callinfo.callID > 22629
			AND staff.branchID = 27
			AND (type != 'checkin' AND type != 'checkinsBlank' AND type != 'checkin_outstanding' AND type != 'checkins_complete')
			AND TIMESTAMPDIFF(SECOND, STR_TO_DATE(CONCAT(callinfo.dateInputted, ' ', callinfo.timeInputted), '%Y-%m-%d %H:%i:%s'), callinfo.completed) >= 0
			AND callinfo.completed IS NOT NULL
			ORDER BY diff ASC");
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	function callStatsPerPerson($DBH, $staffID) {
		$query = $DBH->prepare("SELECT callinfo.completed, STR_TO_DATE(CONCAT(callinfo.dateInputted, ' ', callinfo.timeInputted), '%Y-%m-%d %H:%i:%s'), TIMESTAMPDIFF(SECOND, STR_TO_DATE(CONCAT(callinfo.dateInputted, ' ', callinfo.timeInputted), '%Y-%m-%d %H:%i:%s'), callinfo.completed) AS diff, staff.username, staff.staffID FROM callinfo 
			INNER JOIN staff AS staff ON callinfo.staffID = staff.staffID
			WHERE callinfo.callID > 22629
			AND callinfo.staffID = ?
			AND (type != 'checkin' AND type != 'checkinsBlank' AND type != 'checkin_outstanding' AND type != 'checkins_complete')
			AND TIMESTAMPDIFF(SECOND, STR_TO_DATE(CONCAT(callinfo.dateInputted, ' ', callinfo.timeInputted), '%Y-%m-%d %H:%i:%s'), callinfo.completed) >= 0
			AND callinfo.completed IS NOT NULL
			ORDER BY diff ASC");
		$query->execute(array($staffID));
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	function callStatsPerBranch($DBH, $branchID) {
		$query = $DBH->prepare("SELECT callinfo.branchID, callinfo.completed, STR_TO_DATE(CONCAT(callinfo.dateInputted, ' ', callinfo.timeInputted), '%Y-%m-%d %H:%i:%s'), TIMESTAMPDIFF(SECOND, STR_TO_DATE(CONCAT(callinfo.dateInputted, ' ', callinfo.timeInputted), '%Y-%m-%d %H:%i:%s'), callinfo.completed) AS diff, staff.username, staff.staffID FROM callinfo 
		INNER JOIN staff AS staff ON callinfo.staffID = staff.staffID
		WHERE callinfo.callID > 22629
		AND staff.branchID = 27
		AND (type != 'checkin' AND type != 'checkinsBlank' AND type != 'checkin_outstanding' AND type != 'checkins_complete')
		AND TIMESTAMPDIFF(SECOND, STR_TO_DATE(CONCAT(callinfo.dateInputted, ' ', callinfo.timeInputted), '%Y-%m-%d %H:%i:%s'), callinfo.completed) >= 0
		AND callinfo.completed IS NOT NULL
	        AND callinfo.branchID = ?
		ORDER BY diff ASC");
		$query->execute(array($branchID));
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	function nonCompleted($DBH) {
		$query = $DBH->prepare('SELECT count(callID) as count FROM callinfo 
								INNER JOIN staff AS staff ON callinfo.staffID = staff.staffID
								WHERE callinfo.callID > 22629
								AND staff.branchID = 27
								AND callinfo.completed IS NULL');
		$query->execute();
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	function nonCompletedIndiv($DBH, $staffID) {
		$query = $DBH->prepare('SELECT count(callID) as count FROM callinfo 
								INNER JOIN staff AS staff ON callinfo.staffID = staff.staffID
								WHERE callinfo.callID > 22629
								AND staff.staffID = ?
								AND callinfo.completed IS NULL');
		$query->execute(array($staffID));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	function perBranch($DBH) {
		$branchList = $this->branchList($DBH);

		foreach ($branchList as $key) {
			if($key['branchID'] == 27) {
				continue;
			}
			else {
				$data = $this->callStatsPerBranch($DBH, $key['branchID']);
				
				$branchResult = $this->format($DBH, $data);
			}
			$combined[] = array($key['branchNameShort'], ((int)$branchResult['diff'])*1000);
		}
		
		//$combined = json_encode($combined);

		return $combined;
	}

	function perPerson($DBH) {
		$staff = new Staff();
		$staffList = $staff->staffList($DBH);

		foreach ($staffList as $key) {
			$data = $this->callStatsPerPerson($DBH, $key['staffID']);

			$result = $this->format($DBH, $data);

			$combined[] = array($key['username'], ((int)$result['diff'])*1000);
		}

		return $combined;
	}
}