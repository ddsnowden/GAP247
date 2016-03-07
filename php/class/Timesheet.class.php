<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class Timesheet {
	function recall($DBH, $access, $staffID) {
		if ($access == 2) {
			$query = $DBH->prepare('SELECT *
										FROM staff, timesheet, branches
										WHERE timesheet.staffID = staff.staffID
										AND staff.branchID = branches.branchID
										GROUP BY timesheet.timeID
										ORDER BY timesheet.commence DESC');
			$query->execute();
		}
		else {
			$query = $DBH->prepare("SELECT *
										FROM staff, timesheet, branches
										WHERE timesheet.staffID = staff.staffID
										AND staff.branchID = branches.branchID
										AND staff.staffID = ?
										GROUP BY timesheet.timeID
										ORDER BY timesheet.commence DESC");
			$query->execute(array($staffID));
		}
		
		$result = $query->fetchALL(PDO::FETCH_ASSOC);
		return $result;
	}

	function removeZeros($datetime) {
		if($datetime == '0000-00-00 00:00:00') {
			$datetime = "";
		}
		else {
			$datetime = new DateTime($datetime);
			$datetime = date_format($datetime, 'Y/m/d H:i');
		}
		return $datetime;
	}

	function checkSheets($DBH, $staffID, $commence) {
		$query = $DBH->prepare('SELECT timeID FROM timesheet WHERE staffID = ? AND commence = ?');
		$query->execute(array($staffID, $commence));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	function pay($DBH, $start, $finish, $payRate) {
		$s = new DateTime("$start");
		$f = new DateTime("$finish");
		
		$i = $s->diff($f);

		$seconds = ($i->h * 60 * 60)
				+ ($i->i * 60);

		$totalPay = round((($seconds * $payRate) / 3600), 2);
		
		return $totalPay;
	}

	function timeDiff($DBH, $start, $finish) {
		$s = new DateTime("$start");
		$f = new DateTime("$finish");
		
		$i = $s->diff($f);

		$seconds = ($i->h * 60 * 60)
				+ ($i->i * 60);

		$hours = $seconds / 3600;

		return $hours;
	}

	function diff($start, $finish) {
		$start = new DateTime($start);
		$finish = new DateTime($finish);
		$difference = $start->diff($finish);
		$elapsed = (float)$difference->format('%r%Y%m%d%H%i');

		return $difference;
	}

	function update($DBH, $staffID, $commence, $monStart, $monFinish, $tueStart, $tueFinish, $wedStart, $wedFinish, $thuStart, $thuFinish, $friStart, $friFinish, $satStart, $satFinish, $sunStart, $sunFinish, $timeID) {
		$query = 'UPDATE timesheet SET monStart = ?, 
											monFinish = ?, 
											tueStart = ?, 
											tueFinish = ?, 
											wedStart = ?, 
											wedFinish = ?, 
											thuStart = ?, 
											thuFinish = ?, 
											friStart = ?, 
											friFinish = ?, 
											satStart = ?, 
											satFinish = ?, 
											sunStart = ?, 
											sunFinish = ?
											WHERE timeID = ?';
		$TSU = $DBH->prepare($query);
		$TSU->execute(array($monStart, 
							$monFinish, 
							$tueStart, 
							$tueFinish, 
							$wedStart, 
							$wedFinish, 
							$thuStart, 
							$thuFinish, 
							$friStart, 
							$friFinish, 
							$satStart, 
							$satFinish, 
							$sunStart, 
							$sunFinish,
							$timeID));
	}

	function insert($DBH, $staffID, $commence, $monStart, $monFinish, $tueStart, $tueFinish, $wedStart, $wedFinish, $thuStart, $thuFinish, $friStart, $friFinish, $satStart, $satFinish, $sunStart, $sunFinish) {
		$query = 'INSERT INTO timesheet (staffID, 
												commence, 
												monStart, 
												monFinish, 
												tueStart, 
												tueFinish, 
												wedStart, 
												wedFinish, 
												thuStart, 
												thuFinish, 
												friStart, 
												friFinish, 
												satStart, 
												satFinish, 
												sunStart, 
												sunFinish) 
										VALUES (:staffID, 
												:commence, 
												:monStart, 
												:monFinish, 
												:tueStart, 
												:tueFinish, 
												:wedStart, 
												:wedFinish, 
												:thuStart, 
												:thuFinish, 
												:friStart, 
												:friFinish, 
												:satStart, 
												:satFinish, 
												:sunStart, 
												:sunFinish)';

		$TSU = $DBH->prepare($query);

		$TSU->bindParam(':staffID', $staffID);
		$TSU->bindParam(':commence', $commence);
		$TSU->bindParam(':monStart', $monStart); 
		$TSU->bindParam(':monFinish', $monFinish); 
		$TSU->bindParam(':tueStart', $tueStart); 
		$TSU->bindParam(':tueFinish', $tueFinish); 
		$TSU->bindParam(':wedStart', $wedStart); 
		$TSU->bindParam(':wedFinish', $wedFinish); 
		$TSU->bindParam(':thuStart', $thuStart); 
		$TSU->bindParam(':thuFinish', $thuFinish); 
		$TSU->bindParam(':friStart', $friStart); 
		$TSU->bindParam(':friFinish', $friFinish); 
		$TSU->bindParam(':satStart', $satStart); 
		$TSU->bindParam(':satFinish', $satFinish); 
		$TSU->bindParam(':sunStart', $sunStart); 
		$TSU->bindParam(':sunFinish', $sunFinish); 
		$TSU->execute();
	}

	function payRate($DBH, $staffID) {
		$query = $DBH->prepare('SELECT payRate FROM staff WHERE staffID = ?');
		$query->execute(array($staffID));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}
}