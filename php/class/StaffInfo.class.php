<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';;

class StaffInfo {

	public function payrollDetails($DBH, $username) {
		$query = $DBH->prepare('SELECT staff.staffID, staff.payrollNumber, staff.staffNameFirst, staff.staffNameLast, staff.payRate, staffTimesheets.hoursWorked, staffTimesheets.holidayTaken, staffTimesheets.remainingHoliday
									FROM staff
									LEFT JOIN staffTimesheets AS staffTimesheets ON staffTimesheets.staffID = staff.staffID
									WHERE staff.username = ?');
		
	    $query->execute(array($username));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		
		return $result;
	}

	public function payrollHistory($DBH, $username) {
		$query = $DBH->prepare('SELECT staff.fulltime, weekStarting, hoursWorked, holidayTaken, remainingHoliday
									FROM staffTimesheets
									INNER JOIN staff AS staff ON staffTimesheets.staffID = staff.staffID
									WHERE staff.username = ?
									ORDER BY weekStarting DESC');
		$query->execute(array($username));
		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		return $result;
	}

	function holiday($DBH, $staffID, $holidayTaken, $hoursWorked) {
		$contract = $this->contractCheck($DBH, $staffID);

		$holidays = $this->remaining($DBH, $staffID);

		if($contract['fulltime'] == '1') {
			$remaining = $holidays - $holidayTaken;
		}
		else {
			$rate = '0.1207';

			$remaining = $holidays - $holidayTaken;
			$remaining = ((float)$hoursWorked * (float)$rate) + (float)$remaining;
		}

		return $remaining;
	}
	function insert($DBH, $staffID, $weekStarting, $hoursWorked, $holidayTaken) {

		$query = $DBH->prepare('SELECT stID, weekStarting, remainingHoliday FROM staffTimesheets WHERE staffID = ? ORDER BY weekStarting DESC LIMIT 1');
		$query->execute(array($staffID));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		
		$remainingHoliday = $this->holiday($DBH, $staffID, $holidayTaken, $hoursWorked);

		if(date('Y-m-d', strtotime($weekStarting)) == date('Y-m-d', strtotime($result['weekStarting']))) {
			$query = 'UPDATE staffTimesheets SET hoursWorked = ?, holidayTaken = ?, remainingHoliday = ? WHERE stID = ?';
			$update = $DBH->prepare($query);
			$update->execute(array($hoursWorked, $holidayTaken, $remainingHoliday, $result['stID']));
		}
		else {
			$insert = 'INSERT INTO staffTimesheets (staffID,
										weekStarting,
										hoursWorked,
										holidayTaken,
										remainingHoliday
										) 
								VALUES (:staffID,
										:weekStarting,
										:hoursWorked,
										:holidayTaken,
										:remainingHoliday)';
			$TTI = $DBH->prepare($insert);
			$TTI->bindParam(':staffID', $staffID);
			$TTI->bindParam(':weekStarting', $weekStarting);
			$TTI->bindParam(':hoursWorked', $hoursWorked);
			$TTI->bindParam(':holidayTaken', $holidayTaken);
			$TTI->bindParam(':remainingHoliday', $remainingHoliday);
			$TTI->execute();
			}
	}

	function contractCheck($DBH, $staffID) {
		$query = $DBH->prepare('SELECT fulltime FROM staff WHERE staffID = ?');
		$query->execute(array($staffID));
		$result = $query->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	function remaining($DBH, $staffID) {
		$query = $DBH->prepare('SELECT remainingHoliday FROM `staffTimesheets` WHERE staffID = ? ORDER BY stID DESC LIMIT 1');
		$query->execute(array($staffID));
		$result = $query->fetch(PDO::FETCH_ASSOC);

		return $result['remainingHoliday'];
	}

	function emailPayroll($DBH, $date) {
		$query = $DBH->prepare('SELECT staff.staffNameFirst, staff.staffNameLast, staff.fulltime, staff.payrollNumber, staffTimesheets.hoursWorked, staffTimesheets.holidayTaken, staffTimesheets.remainingHoliday
									FROM staffTimesheets
									INNER JOIN staff AS staff ON staffTimesheets.staffID = staff.staffID
									WHERE staffTimesheets.weekStarting = ?
									ORDER BY staff.fulltime DESC, staff.staffNameFirst ASC');
		$query->execute(array($date));
		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		return $result;
	}

	//Clear session array are return to referring page
	function clearReturn($page) {
		unset($_SESSION['form']);
		$_SESSION['form']['status'] = '';
		$_SESSION['form']['branchNameShort'] = '';
		header('location: '.$page);
	}

	function lastMonday($date) {
		$result = date('Y-m-d', strtotime("last monday", strtotime($date)));

		return $result;
	}
}