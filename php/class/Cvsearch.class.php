<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class CVSearch
{
	function recall($DBH) {
		$recall = $DBH->prepare('SELECT *
								FROM callinfo
								INNER JOIN cvsearch as cvsearch ON callinfo.callID = cvsearch.callID
								INNER JOIN clientname as clientname ON callinfo.clientNameID = clientname.clientNameID
								INNER JOIN branches as branches ON callinfo.branchID = branches.branchID
								WHERE callinfo.type = "cvsearch"
								ORDER BY callinfo.dateInputted DESC, callinfo.timeInputted DESC');
		$recall->execute();
		$recallResult = $recall->fetchALL(PDO::FETCH_ASSOC);
		return $recallResult;
	}

	function cvList($DBH, $branchID) {
		$cvlist = $DBH->prepare('SELECT callinfo.callID, callinfo.status, branches.branchNameShort, clientname.clientName, cvsearch.position, cvsearch.assign
								FROM callinfo
								INNER JOIN cvsearch AS cvsearch ON callinfo.callID = cvsearch.callID
								INNER JOIN branches AS branches ON callinfo.branchID = branches.branchID
								INNER JOIN clientname AS clientname ON callinfo.clientNameID = clientname.clientNameID
								WHERE branches.branchID = ?
								ORDER BY callinfo.callID DESC');
		$cvlist->execute(array($branchID));
		$result = $cvlist->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	function cvListAll($DBH) {
		$cvlist = $DBH->prepare('SELECT callinfo.callID, callinfo.status, branches.branchNameShort, clientname.clientName, cvsearch.position, cvsearch.assign
								FROM callinfo
								INNER JOIN cvsearch AS cvsearch ON callinfo.callID = cvsearch.callID
								INNER JOIN branches AS branches ON callinfo.branchID = branches.branchID
								LEFT JOIN clientname AS clientname ON callinfo.clientNameID = clientname.clientNameID
								ORDER BY callinfo.callID DESC');
		$cvlist->execute();
		$result = $cvlist->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	function cvSearchInsert($DBH, $callID, $position, $jobdesc, $other) {
		$cvInput = 'INSERT INTO cvsearch (callID, position, jobdesc, other) 
								VALUES (:callID, :position, :jobdesc, :other)';
				
		$BI = $DBH->prepare($cvInput);
		$BI->bindParam(':callID', $callID);
		$BI->bindParam(':position', $position);
		$BI->bindParam(':jobdesc', $jobdesc);
		$BI->bindParam(':other', $other);
		$BI->execute();
		$ID = $DBH->lastInsertId();
		return $ID;
	}

	function cvSearchUpdate($DBH, $position, $jobdesc, $other, $callID) {
		$cvUpdate = 'UPDATE cvsearch SET
									position = ?,
									jobdesc = ?,
									other = ?
									WHERE callID = ?';
				
		$BI = $DBH->prepare($cvUpdate);
		$BI->execute(array($position,
							$jobdesc,
							$other,
							$callID));
		$BI->execute();
		$ID = $DBH->lastInsertId();
		return $ID;
	}

	//Insert call details to table
	function callInsertcv($DBH, $clientNameID, $branchID, $staffID, $type, $status, $further, $currentTime, $currentDate, $emailed) {
		$callInput = 'INSERT INTO callinfo (clientNameID,
											branchID,
											staffID,
											type,
											status,
											further,
											timeInputted,
											dateInputted,
											emailed) 
									VALUES (:clientNameID,
											:branchID,
											:staffID,
											:type,
											:status,
											:further,
											:timeInputted,
											:dateInputted,
											:emailed)';
		
		$CI = $DBH->prepare($callInput);
		$CI->bindParam(':clientNameID', $clientNameID);
		$CI->bindParam(':branchID', $branchID);
		$CI->bindParam(':staffID', $staffID);
		$CI->bindParam(':type', $type);
		$CI->bindParam(':status', $status);
		$CI->bindParam(':further', $further);
		$CI->bindParam(':timeInputted', $currentTime);
		$CI->bindParam(':dateInputted', $currentDate);
		$CI->bindParam(':emailed', $emailed);
		$CI->execute();
		$ID = $DBH->lastInsertId();
		return $ID;
		}

	//Update call details
	function callUpdatecv($DBH, $clientNameID, $further, $callID) {
		$callUpdate = 'UPDATE callinfo SET clientNameID = ?,
											further = ?
											WHERE callID = ?';
			
		$CI = $DBH->prepare($callUpdate);
		$CI->execute(array($clientNameID,
							$further,
							$callID));
		}

	//Update call details
	function cvStaffAssign($DBH, $staffName, $callID) {
		$callUpdate = 'UPDATE cvsearch SET assign = ? WHERE callID = ?';
		$CI = $DBH->prepare($callUpdate);
		$CI->execute(array($staffName, $callID));
		}

	//Update CV call status
	function cvCallStatus($DBH, $status, $callID) {
		$callUpdate = 'UPDATE callinfo SET status = ? WHERE callID = ?';
		$CI = $DBH->prepare($callUpdate);
		$CI->execute(array($status, $callID));
	}
}