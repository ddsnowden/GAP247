<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class Totals {

	public function collectDates($DBH) {
		$days = $DBH->prepare('SELECT datefield FROM calendar WHERE (datefield BETWEEN "2015-04-01" and now()) ORDER BY datefield ASC');
	    $days->execute();
	    $days = $days->fetchAll(PDO::FETCH_ASSOC);

	    return $days;
	}

	public function calls($DBH, $dates) {
		$query = $DBH->prepare("SELECT count(callID) AS count FROM callinfo WHERE dateInputted = ?");
		
	 	foreach ($dates as $key) {
	 		$query->execute(array($key['datefield']));
	 		$calls[] = $query->fetch(PDO::FETCH_ASSOC);
	 	}

	 	$combined = array();
		for ($i=0; $i < count($dates); $i++) { 
			$combined[] = array($dates[$i]['datefield'], (int)$calls[$i]['count']);
		}

		$combined = json_encode($combined);

		return $combined;
	}

	public function tempCalls($DBH, $dates) {
		$query = $DBH->prepare('SELECT count(callID) AS count FROM callinfo WHERE (type = "advert" or type = "Matalan Advert" or type = "sickness or absence" or type = "other temp issues" or type = "pay queries") AND dateInputted = ?');
		
	 	foreach ($dates as $key) {
	 		$query->execute(array($key['datefield']));
	 		$calls[] = $query->fetch(PDO::FETCH_ASSOC);
	 	}

	 	$combined = array();
		for ($i=0; $i < count($dates); $i++) { 
			$combined[] = array($dates[$i]['datefield'], (int)$calls[$i]['count']);
		}

	 	$combined = json_encode($combined);

		return $combined;
	}

	public function clientCalls($DBH, $dates) {
		$query = $DBH->prepare('SELECT count(callID) AS count FROM callinfo WHERE (type = "cvsearch" or type = "head office client call" or type = "checkins_complete" or type = "Bookings" or type = "cancellations" or type = "Temp No Show" or type = "client other issues") AND dateInputted = ?');
		
	 	foreach ($dates as $key) {
	 		$query->execute(array($key['datefield']));
	 		$calls[] = $query->fetch(PDO::FETCH_ASSOC);
	 	}

	 	$combined = array();
		for ($i=0; $i < count($dates); $i++) { 
			$combined[] = array($dates[$i]['datefield'], (int)$calls[$i]['count']);
		}

		$combined = json_encode($combined);

		return $combined;
	}

	public function hourlyTotals($DBH) {
		$query = $DBH->prepare('SELECT HOUR(timeInputted) AS hour, COUNT(callID) AS count
								FROM callinfo
								WHERE (type != "checkin" AND type != "checkinsBlank" AND type != "checkin_outstanding")
								GROUP BY hour');
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		return $result;
	}

	public function serverRunning($DBH) {
		$query = $DBH->prepare('SELECT DATEDIFF(CURDATE(), (select dateInputted from callinfo limit 1)) AS days');
		$query->execute();
		$result = $query->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	public function months($DBH) {
		$months = $DBH->prepare("SELECT DISTINCT DATE_FORMAT(datefield, '%Y-%m') AS yearMonth FROM calendar WHERE datefield BETWEEN DATE_SUB(NOW(), INTERVAL 2 YEAR) and CURDATE() ORDER BY yearMonth");
	    $months->execute();
	    $months = $months->fetchAll(PDO::FETCH_ASSOC);
	    return $months;
	}

	public function monthlyTotals($DBH, $months) {
		$twoYear = $DBH->prepare('SELECT count(callID) FROM callinfo WHERE DATE_FORMAT(dateInputted, "%Y-%m") = ?');
	    foreach ($months as $key) {
	      $twoYear->execute(array($key['yearMonth']));
	      $twoYearResult[] = $twoYear->fetchAll(PDO::FETCH_ASSOC);
	    }

	    foreach ($twoYearResult as $key) {
	      $TYResults[] = $key[0]['count(callID)'];
	    }

	    $result = join(', ', $TYResults);

	    return $result;
	}

	public function clientMonthlyTotals($DBH, $months) {
		$twoYearClient = $DBH->prepare('SELECT count(callID) FROM callinfo WHERE DATE_FORMAT(dateInputted, "%Y-%m") = ? AND (type = "Bookings" or type = "cancellations" or type = "Temp No Show" or type = "client other issues")');
	    foreach ($months as $key) {
	      $twoYearClient->execute(array($key['yearMonth']));
	      $twoYearClientresult[] = $twoYearClient->fetchAll(PDO::FETCH_ASSOC);
	    }

	    foreach ($twoYearClientresult as $key) {
	      $TYCResults[] = $key[0]['count(callID)'];
	    }

	    $result = join(', ', $TYCResults);

	    return $result;
	}

	public function tempMonthlyTotals($DBH, $months) {
		$twoYearTemp = $DBH->prepare('SELECT count(callID) FROM callinfo WHERE DATE_FORMAT(dateInputted, "%Y-%m") = ?  AND (type = "Matalan Advert" or type = "sickness or absence" or type = "other temp issues" or type = "pay queries")');
	    foreach ($months as $key) {
	      $twoYearTemp->execute(array($key['yearMonth']));
	      $twoYearTempresult[] = $twoYearTemp->fetchAll(PDO::FETCH_ASSOC);
	    }

	    foreach ($twoYearTempresult as $key) {
	      $TYTResults[] = $key[0]['count(callID)'];
	    }

	    $result = join(', ', $TYTResults);

	    return $result;
	}

	public function booked($DBH) {
		$bookfill = $DBH->prepare('SELECT sum(quantity) as booked, sum(filled) as filled FROM bookings');
		$bookfill->execute();
		$result = $bookfill->fetchAll(PDO::FETCH_ASSOC);

	    return $result;
	}

	public function noShow($DBH) {
		$noShow = $DBH->prepare('SELECT sum(noQuantity) as noQuant, sum(fillQuantity) as filled FROM tempnoshow');
		$noShow->execute();
		$result = $noShow->fetchAll(PDO::FETCH_ASSOC);

		return $result;
	}
}