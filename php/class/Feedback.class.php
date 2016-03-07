<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class Feedback
{
	function recall($DBH) {
		$recall = $DBH->prepare('SELECT feedback.feedID, staff.staffNameFirst, 
										staff.staffNameLast, feedback.feedbackType, 
										feedback.complaintType, feedback.operatorID, 
										feedback.callIDRef, feedback.procType, 
										feedback.details, feedback.timeInputted,
										feedback.dateInputted, feedback.branchID,
										feedback.further, feedback.status, feedback.staffID,
										branches.branchNameShort, feedback.branchID
										FROM feedback
										LEFT JOIN staff AS staff ON staff.staffID = feedback.staffID
										INNER JOIN branches AS branches ON branches.branchID = feedback.branchID');
		$recall->execute();
		$recallResult = $recall->fetchALL(PDO::FETCH_ASSOC);
		return $recallResult;
	}

	//Insert client details to table
	function feedbackInsert($DBH, $feedbackType, $complaintType, $operatorID, $callIDRef, $procType, $details, $currentTime, $currentDate, $branchID, $further, $status, $staffID) {
		$query = 'INSERT INTO feedback (feedbackType, 
											complaintType, 
											operatorID, 
											callIDRef, 
											procType, 
											details, 
											timeInputted, 
											dateInputted, 
											branchID, 
											further, 
											status, 
											staffID) 
									VALUES (:feedbackType, 
											:complaintType, 
											:operatorID, 
											:callIDRef, 
											:procType, 
											:details, 
											:currentTime, 
											:currentDate, 
											:branchID, 
											:further, 
											:status, 
											:staffID)';

		$CTI = $DBH->prepare($query);
		$CTI->bindParam(':feedbackType', $feedbackType);
		$CTI->bindParam(':complaintType', $complaintType);
		$CTI->bindParam(':operatorID', $operatorID);
		$CTI->bindParam(':callIDRef', $callIDRef);
		$CTI->bindParam(':procType', $procType);
		$CTI->bindParam(':details', $details);
		$CTI->bindParam(':currentTime', $currentTime);
		$CTI->bindParam(':currentDate', $currentDate);
		$CTI->bindParam(':branchID', $branchID);
		$CTI->bindParam(':further', $further);
		$CTI->bindParam(':status', $status);
		$CTI->bindParam(':staffID', $staffID);

		$CTI->execute();
		$ID = $DBH->lastInsertId();
		return $ID;
	}

	function checkCallID($DBH, $callIDRef) {
		$check = $DBH->prepare('SELECT count(callID) as count FROM callinfo WHERE callID = ?');
		$check->execute(array($callIDRef));
		$result = $check->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	function staffList($DBH) {
		$query = $DBH->prepare('SELECT * FROM staff WHERE finishDate = "0000-00-00" AND staff.access < 10 ORDER BY staff.staffNameFirst ASC, staff.staffNameLast DESC');
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}
}