<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class Holiday
{
	function recall($DBH, $access, $staffID) {
		if($access == 2) {
			$query = $DBH->prepare('SELECT * FROM holidays, staff WHERE staff.staffID = holidays.staffID ORDER BY holidayID DESC;');
			$query->execute();
			$result = $query->fetchALL(PDO::FETCH_ASSOC);
		}
		else {
			$query = $DBH->prepare('SELECT * FROM holidays WHERE holidays.staffID = ? ORDER BY holidayID DESC;');
			$query->execute(array($staffID));
			$result = $query->fetchALL(PDO::FETCH_ASSOC);
		}
		return $result;
	}

	//Insert holiday
	function insert($DBH, $staffID, $holStart, $holFinish, $additional, $sanctioned, $currentDate, $currentTime) {
		$query = 'INSERT INTO holidays (staffID,
											holStart,
											holFinish,
											additional,
											sanctioned,
											dateInputted,
											timeInputted) 
									VALUES (:staffID,
											:holStart,
											:holFinish,
											:additional,
											:sanctioned,
											:dateInputted,
											:timeInputted)';

		$HTI = $DBH->prepare($query);
		$HTI->bindParam(':staffID', $staffID);
		$HTI->bindParam(':holStart', $holStart);
		$HTI->bindParam(':holFinish', $holFinish);
		$HTI->bindParam(':additional', $additional);
		$HTI->bindParam(':sanctioned', $sanctioned);
		$HTI->bindParam(':dateInputted', $currentDate);
		$HTI->bindParam(':timeInputted', $currentTime);
		$HTI->execute();
	}

	//Update Holidays
	function update($DBH, $holStart, $holFinish, $additional, $sanctioned, $holidayID) {
		$query = 'UPDATE holidays SET
									holStart = ?,
									holFinish = ?,
									additional = ?,
									sanctioned = ?
									WHERE holidayID = ?';
				
					$BI = $DBH->prepare($query);
					$BI->execute(array($holStart,
										$holFinish,
										$additional,
										$sanctioned,
										$holidayID));
					$BI->execute();
	}

	function remaining($DBH, $staffID) {
		$query = $DBH->prepare('SELECT remainingHoliday FROM staffTimesheets WHERE staffID = ? ORDER BY weekStarting DESC LIMIT 1');
		$query->execute(array($staffID));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		$result = $result['remainingHoliday'];
		return $result;
	}
}