<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';
require_once $root.'/assets/php/class/stats/Totals.class.php';

class TypeTotals extends Totals {

	public function typeTotal($DBH, $dates, $type) {
		$query = $DBH->prepare('SELECT count(callID) AS count 
								FROM callinfo 
								WHERE (type != "checkin" AND type != "checkinsBlank" AND type != "checkin_outstanding") 
								AND dateInputted = ? 
								AND type = ?');

		foreach ($dates as $key) {
	 		$query->execute(array($key['datefield'], $type));
	 		$calls[] = $query->fetch(PDO::FETCH_ASSOC);
	 	}

	 	$combined = array();
		for ($i=0; $i < count($dates); $i++) { 
			$combined[] = array($dates[$i]['datefield'], (int)$calls[$i]['count']);
		}

		$combined = json_encode($combined);

		return $combined;
	}

	public function types($DBH) {
		$query = $DBH->prepare('SELECT type, count(callID) AS count 
									FROM callinfo INNER JOIN branches AS branches ON callinfo.branchID = branches.branchID 
									WHERE (type != "checkin" AND type != "checkinsBlank" AND type != "checkin_outstanding")
									GROUP BY type
									ORDER BY count DESC');
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		return $result;
	}

	public function branchType($DBH, $branch) {
		$query = $DBH->prepare('SELECT type, count(callID) AS count 
								FROM callinfo INNER JOIN branches AS branches ON callinfo.branchID = branches.branchID 
								WHERE (type != "checkin" AND type != "checkinsBlank" AND type != "checkin_outstanding") 
								AND branches.branchName = ? 
								GROUP BY type');
		foreach($branch as $key) {
			$query->execute(array($key['branchName']));
			$result = $query->fetchAll(PDO::FETCH_ASSOC);
			
			$joined = "{name: '".ucwords($key['branchName'])."', id: '".ucwords($key['branchName'])."', data: [";
			$data = '';
			foreach ($result as $key2) {
				$data .= "['".ucwords($key2['type'])."', ".$key2['count']."],";
			}
			$data = rtrim($data,',');
			$joined .= $data;
			$joined .= "]},\n";
			$totalData[] = $joined;
		}

		$joined = implode('', $totalData);
		$trimmed = rtrim($joined,',');

		return $joined;
	}

	public function hourlyType($DBH, $hour) {
		$query = $DBH->prepare('SELECT type, COUNT(callID) AS count
								FROM callinfo
								WHERE (type != "checkin" AND type != "checkinsBlank" AND type != "checkin_outstanding")
								and HOUR(timeInputted) = ?
								GROUP BY type');
		$data = '';
		$joined = '';
		foreach ($hour as $key) {
			$query->execute(array($key['hour']));
			$result = $query->fetchAll(PDO::FETCH_ASSOC);

			$data = "{name: '".$key['hour']."', id: '".$key['hour']."', data: [";
			foreach ($result as $key2) {
				$data .= "['".ucwords($key2['type'])."', ".$key2['count']."],";
			}
			$data = rtrim($data,',');
			$data .= "]}\n,";
			$joined .= $data;
		}
		$joined = rtrim($joined,',');


	return $joined;
	}
}
