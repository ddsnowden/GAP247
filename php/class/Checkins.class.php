<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class Checkins
{
	function recall($DBH) {
		$query = $DBH->prepare('SELECT *
								FROM callinfo
								LEFT JOIN client AS client ON callinfo.clientID = client.clientID
								LEFT JOIN clientname AS clientname ON callinfo.clientNameID = clientname.clientNameID
								INNER JOIN branches AS branches ON callinfo.branchID = branches.branchID
								INNER JOIN staff AS staff ON callinfo.staffID = staff.staffID
								WHERE type = "checkins_complete" 
								AND callinfo.dateInputted >= (CURDATE() - INTERVAL 14 DAY)
								GROUP BY callinfo.callID
								ORDER BY callinfo.completed DESC');
		$query->execute();
		$result = $query->fetchALL(PDO::FETCH_ASSOC);
		return $result;
	}

	function runningCheckins($DBH) {
		$query = $DBH->prepare('SELECT callinfo.callID, 
										branches.branchNameShort, clientname.clientName, 
										callinfo.timeToCall, callinfo.dateToCall, 
										client.landline, client.mobile, callinfo.status, callinfo.active
									FROM callinfo
									INNER JOIN branches AS branches ON callinfo.branchID = branches.branchID
									LEFT JOIN client AS client ON callinfo.clientID = client.clientID
									LEFT JOIN clientname AS clientname ON callinfo.clientNameID = clientname.clientNameID
									WHERE type = "Checkin"
									AND callinfo.active = "Active" 
									ORDER BY callinfo.dateToCall ASC, callinfo.timeToCall ASC');
		$query->execute();
		$result = $query->fetchALL(PDO::FETCH_ASSOC);
		return $result;
	}

	function runningCheckinsBranch($DBH, $branchID) {
		$query = $DBH->prepare('SELECT callinfo.callID, 
										branches.branchNameShort, clientname.clientName, 
										callinfo.timeToCall, callinfo.dateToCall, 
										client.landline, client.mobile, callinfo.status, callinfo.active
									FROM callinfo
									INNER JOIN branches AS branches ON callinfo.branchID = branches.branchID
									LEFT JOIN client AS client ON callinfo.clientID = client.clientID
									LEFT JOIN clientname AS clientname ON callinfo.clientNameID = clientname.clientNameID
									WHERE type = "Checkin"
									AND callinfo.active = "Active" 
									AND branches.branchID = ?
									ORDER BY callinfo.dateToCall ASC, callinfo.timeToCall ASC');
		$query->execute(array($branchID));
		$result = $query->fetchALL(PDO::FETCH_ASSOC);
		return $result;
	}

	function storedCheckins($DBH, $branchID) {
		$query = $DBH->prepare('SELECT callinfo.callID, 
										callinfo.active, branches.branchName, branches.branchNameShort,
										clientname.clientName, client.firstName, 
										client.lastName, callinfo.timeToCall, 
										callinfo.dateToCall, client.landline, 
										client.mobile, callinfo.status 
									FROM callinfo
									INNER JOIN branches AS branches ON callinfo.branchID = branches.branchID
									LEFT JOIN client AS client ON callinfo.clientID = client.clientID
									LEFT JOIN clientname AS clientname ON callinfo.clientNameID = clientname.clientNameID
									WHERE type = "checkinsBlank"
									AND callinfo.active = "Inactive"
									AND branches.branchID = ?');
		$query->execute(array($branchID));
		$result = $query->fetchALL(PDO::FETCH_ASSOC);
		return $result;
	}

	function blankCheckins($DBH) {
		$query = $DBH->prepare('SELECT callinfo.callID,  
										callinfo.active, branches.branchNameShort, 
										clientname.clientName, client.firstName, 
										client.lastName, callinfo.timeToCall, 
										callinfo.dateToCall, client.landline, 
										client.mobile, callinfo.status 
									FROM callinfo, client, clientname, branches 
									WHERE callinfo.branchID = branches.branchID 
									AND callinfo.clientID = client.clientID 
									AND client.clientNameID = clientname.clientNameID 
									AND callinfo.active = "Inactive"
									AND callinfo.type = "checkinsBlank"
									GROUP BY callinfo.callID
									ORDER BY branches.branchName ASC');
		$query->execute();
		$result = $query->fetchALL(PDO::FETCH_ASSOC);
		return $result;
	}

	//Insert call details to table
	function callInsert($DBH, $clientID, $clientNameID, $tempID, $branchID, $staffID, $checkinCallID, $type, $status, $details, $further, $timeToCall, $dateToCall, $active, $currentTime, $currentDate, $compDate) {
		$query = 'INSERT INTO callinfo (clientID, 
											clientNameID,
											tempID, 
											branchID, 
											staffID, 
											checkinCallID,
											type, 
											status, 
											details,
											further,
											timeToCall, 
											dateToCall, 
											active,
											timeInputted,
											dateInputted,
											completed) 
									VALUES (:clientID, 
											:clientNameID,
											:tempID, 
											:branchID, 
											:staffID, 
											:checkinCallID,
											:type, 
											:status, 
											:details,
											:further,
											:timeToCall, 
											:dateToCall, 
											:active,
											:timeInputted,
											:dateInputted,
											:completed)';
			
		$CI = $DBH->prepare($query);
		$CI->bindParam(':clientID', $clientID);
		$CI->bindParam(':clientNameID', $clientNameID);
		$CI->bindParam(':tempID', $tempID);
		$CI->bindParam(':branchID', $branchID);
		$CI->bindParam(':staffID', $staffID);
		$CI->bindParam(':checkinCallID', $checkinCallID);
		$CI->bindParam(':type', $type);
		$CI->bindParam(':status', $status);
		$CI->bindParam(':details', $details);
		$CI->bindValue(':further', $further);
		$CI->bindValue(':timeToCall', $timeToCall);
		$CI->bindValue(':dateToCall', $dateToCall);
		$CI->bindValue(':active', $active);
		$CI->bindParam(':timeInputted', $currentTime);
		$CI->bindParam(':dateInputted', $currentDate);
		$CI->bindParam(':completed', $compDate);
		$CI->execute();
		$ID = $DBH->lastInsertId();
		return $ID;
	}

	//Update call details for nightline
	function callUpdate($DBH, $clientID, $clientNameID, $tempID, $branchID, $staffID, $type, $status, $details, $further, $active, $callID) {
		$query = 'UPDATE callinfo SET clientID = ?, 
										clientNameID = ?,
										tempID = ?, 
										branchID = ?, 
										staffID = ?,
										type = ?,
										status = ?, 
										details = ?,
										further = ?,
										active = ?
									WHERE callID = ?';
			
		$CI = $DBH->prepare($query);
		$CI->execute(array($clientID, 
							$clientNameID,
							$tempID, 
							$branchID, 
							$staffID, 
							$type,
							$status, 
							$details, 
							$further,
							$active,
							$callID));
	}

	function branchCallUpdate($DBH, $clientID, $clientNameID, $tempID, $branchID, $checkID, $type, $status, $details, $further, $timeToCall, $dateToCall, $active, $callID) {
		$callUpdate = 'UPDATE callinfo SET clientID = ?, 
											clientNameID = ?,
											tempID = ?, 
											branchID = ?, 
											checkinCallID = ?,
											type = ?,
											status = ?, 
											details = ?,
											further = ?,
											timeToCall = ?, 
											dateToCall = ?, 
											active = ?
											WHERE callID = ?';
			
		$CI = $DBH->prepare($callUpdate);
		$CI->execute(array($clientID, 
							$clientNameID,
							$tempID, 
							$branchID, 
							$checkID,
							$type, 
							$status, 
							$details, 
							$further,
							$timeToCall, 
							$dateToCall, 
							$active,
							$callID));
	}

	//Update call for branch template
	function callUpdateTemplate($DBH, $type, $active, $callID) {
		$query = 'UPDATE callinfo SET type = ?,
										active = ?
									WHERE callID = ?';
			
		$CI = $DBH->prepare($query);
		$CI->execute(array($type, $active, $callID));
	}

	function callUpdateTemplate2($DBH, $type, $status, $active, $callID) {
		$callUpdate = 'UPDATE callinfo SET type = ?,
											status = ?,
											active = ?
											WHERE callID = ?';
			
		$CI = $DBH->prepare($callUpdate);
		$CI->execute(array($type, $status, $active, $callID));
	}

	//Update call for branch template
	function callUpdateNightline($DBH, $details, $further, $completed, $callID) {
		$callUpdate = 'UPDATE callinfo SET details = ?,
											further = ?,
											completed = ?
											WHERE callID = ?';
			
		$CI = $DBH->prepare($callUpdate);
		$CI->execute(array($details, $further, $completed, $callID));
	}

	function delete($DBH, $callID) {
		$delete = $DBH->prepare('DELETE FROM callinfo WHERE callID = :callID');
		$delete->bindParam(':callID', $callID);
		$delete->execute();
	}
}