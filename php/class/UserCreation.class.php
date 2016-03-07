<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class User
{
	function insertUser($DBH, $username, $password, $staffNameFirst, $staffNameLast, $DoB, $access, $emailPassword, $address, $payrollNumber, $startDate, $branchID, $payRate, $fulltime) {
		$hashed = password_hash($password, PASSWORD_DEFAULT);
		$query = 'INSERT INTO staff (username,
									password,
									staffNameFirst,
									staffNameLast,
									DoB,
									access,
									emailPassword,
									address,
									payrollNumber,
									startDate,
									branchID,
									payRate,
									fulltime
									)
							VALUES (:username,
									:password,
									:staffNameFirst,
									:staffNameLast,
									:DoB,
									:access,
									:emailPassword,
									:address,
									:payrollNumber,
									:startDate,
									:branchID,
									:payRate,
									:fulltime)';
		$database = $DBH->prepare($query);
		$database->bindParam(':username', $username);
		$database->bindParam(':password', $hashed);
		$database->bindParam(':staffNameFirst', $staffNameFirst);
		$database->bindParam(':staffNameLast', $staffNameLast);
		$database->bindParam(':DoB', date('Y-h-m', strtotime($DoB)));
		$database->bindParam(':access', $access);
		$database->bindParam(':emailPassword', $password);
		$database->bindParam(':address', $address);
		$database->bindParam(':payrollNumber', $payrollNumber);
		$database->bindParam(':startDate', date('Y-h-m', strtotime($startDate)));
		$database->bindParam(':branchID', $branchID);
		$database->bindParam(':payRate', $payRate);
		$database->bindParam(':fulltime', $fulltime);

		$database->execute();

		$staffID = $DBH->lastInsertId();

		return $staffID;
	}

	function updateUserWithPassword($DBH, $username, $password, $staffNameFirst, $staffNameLast, $access, $DoB, $emailPassword, $address, $payrollNumber, $startDate, $finishDate, $branchID, $payRate, $fulltime, $staffID) {
		$query = 'UPDATE staff SET username = ?,
										password = ?,
										staffNameFirst = ?,
										staffNameLast = ?,
										access = ?,
										DoB = ?,
										emailPassword = ?,
										address = ?,
										payrollNumber = ?,
										startDate = ?,
										finishDate = ?,
										branchID = ?,
										payRate = ?,
										fulltime = ?
										WHERE staffID = ?';
		
		$hashed = password_hash($password, PASSWORD_DEFAULT);
		$database = $DBH->prepare($query);
		$database->execute(array($username, $hashed, $staffNameFirst, $staffNameLast, $access, date('Y-m-d', strtotime($DoB)), $password, $address, $payrollNumber, date('Y-m-d', strtotime($startDate)), $finishDate, $branchID, $payRate, $fulltime, $staffID));
	}
			
	function updateUserWithoutPassword($DBH, $username, $staffNameFirst, $staffNameLast, $access, $DoB, $address, $payrollNumber, $startDate, $finishDate, $branchID, $payRate, $fulltime, $staffID) {
		$query = 'UPDATE staff SET username = ?,
										staffNameFirst = ?,
										staffNameLast = ?,
										access = ?,
										DoB = ?,
										address = ?,
										payrollNumber = ?,
										startDate = ?,
										finishDate = ?,
										branchID = ?,
										payRate = ?,
										fulltime = ?
										WHERE staffID = ?';
		$database = $DBH->prepare($query);
		$database->execute(array($username, $staffNameFirst, $staffNameLast, $access, date('Y-m-d', strtotime($DoB)), $address, $payrollNumber, date('Y-m-d', strtotime($startDate)), date('Y-m-d', strtotime($finishDate)), $branchID, $payRate, $fulltime, $staffID));
	}

	function holiday($DBH, $staffID, $holidays) {

		$query = $DBH->prepare('SELECT stID, weekStarting, remainingHoliday FROM staffTimesheets WHERE staffID = ? ORDER BY weekStarting DESC LIMIT 1');
		$query->execute(array($staffID));
		$result = $query->fetch(PDO::FETCH_ASSOC);

		if($result['remainingHoliday'] == $holidays) {
			/*$query = 'UPDATE staffTimesheets SET remainingHoliday = ? WHERE stID = ?';
			$update = $DBH->prepare($query);
			$update->execute(array($result['remainingHoliday'], $result['stID']));*/
		}
		else {
			$last_monday = $this->lastMonday(date('Y-m-d'));
			$query = 'INSERT INTO staffTimesheets (staffID, weekStarting, remainingHoliday) VALUES (:staffID, :weekStarting, :remainingHoliday)';
			$q = $DBH->prepare($query);
			$q->bindParam(':staffID', $staffID);
			$q->bindParam(':weekStarting', $last_monday);
			$q->bindParam(':remainingHoliday', $holidays);
			$q->execute();
		}
	}

	function lastMonday($date) {
		$result = date('Y-m-d', strtotime("last monday", strtotime($date)));

		return $result;
	}

	function find($DBH, $first, $last, $branch) {
		$query = $DBH->prepare('SELECT staff.*, st.remainingHoliday FROM staff
									LEFT JOIN staffTimesheets AS st on staff.staffID = st.staffID
									INNER JOIN branches AS branches ON staff.branchID = branches.branchID
									WHERE (staff.staffNameFirst, staff.staffNameLast, branches.branchNameShort) = (?, ?, ?) 
									ORDER BY weekStarting DESC LIMIT 1');
		$query->execute(array($first, $last, $branch));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}
}