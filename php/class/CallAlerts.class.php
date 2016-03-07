<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class CallAlerts {
	//Collect all the data regarding the outstanding calls for everyone
	function outstanding($DBH) {
	  $outstanding = $DBH->prepare("SELECT
	                  callinfo.callID,
	                  callinfo.type,
	                  callinfo.dateInputted,
	                  branches.branchName,
	                  clientname.clientName,
	                  client.firstName as clientFirst,
	                  client.lastName as clientLast,
	                  temp.firstName,
	                  temp.lastName,
	                  staff.staffNameFirst,
	                  staff.staffNameLast,
	                  callinfo.branchID
	                FROM
	                  callinfo Left Outer Join branches On callinfo.branchID = branches.branchID 
	                      Left Outer Join clientname on callinfo.clientNameID = clientname.clientNameID
	                      Left Outer Join client on callinfo.clientID = client.clientID
	                      Left Outer Join temp on callinfo.tempID = temp.tempID
	                      Left Outer Join staff on callinfo.staffID = staff.staffID
	                WHERE callinfo.status = 'Outstanding'
	                AND (callinfo.type != '' and callinfo.type != 'checkinsBlank' and callinfo.type != 'checkin_outstanding')
	                AND staff.branchID = '27'
	                ORDER BY dateInputted DESC");
	  
	  $outstanding->execute();
	  $count = $outstanding->fetchAll(PDO::FETCH_ASSOC);

	  return $count;
	}

	//Collect all the data regarding the outstanding calls for individuals
	function outstandingIndiv($DBH, $staffID) {
	  $outstanding = $DBH->prepare("SELECT
	                  callinfo.callID,
	                  callinfo.type,
	                  branches.branchName,
	                  clientname.clientName,
	                  client.firstName as clientFirst,
	                  client.lastName as clientLast,
	                  temp.firstName,
	                  temp.lastName,
	                  callinfo.branchID
	                FROM
	                  callinfo 
	                Left Outer Join branches On callinfo.branchID = branches.branchID 
	                Left Outer Join clientname on callinfo.clientNameID = clientname.clientNameID
	                Left Outer Join client on callinfo.clientID = client.clientID
	                Left Outer Join temp on callinfo.tempID = temp.tempID
	                Left Outer Join staff on callinfo.staffID = staff.staffID
	                WHERE callinfo.status = 'Outstanding'
	                AND (callinfo.type != '' and callinfo.type != 'checkinsBlank' and callinfo.type != 'checkin_outstanding')
	                AND staff.branchID = '27'
	                and callinfo.staffID = ?");
	  
	  $outstanding->execute(array($staffID));

	  $count = $outstanding->fetchAll(PDO::FETCH_ASSOC);

	  return $count;
	}

	//All non-emailed calls for the branch
	function notEmailed($DBH) {
	  $notEmailed = $DBH->prepare("SELECT * FROM callinfo 
	                                  INNER JOIN staff AS staff ON callinfo.staffID = staff.staffID
	                                  INNER JOIN branches AS branches ON callinfo.branchID = branches.branchID
	                                  WHERE emailed = 'Not Emailed'
	                                  AND (callinfo.type != '' and callinfo.type != 'checkinsBlank' and callinfo.type != 'checkin_outstanding')
	                                  AND staff.branchID = '27'
	                                  ORDER BY dateInputted DESC");
	  
	  $notEmailed->execute();
	  $results = $notEmailed->fetchAll(PDO::FETCH_ASSOC);

	  return $results;
	}

	//Non-emailed calls for the individual
	function notEmailedIndiv($DBH, $staffID) {
	  $notEmailed = $DBH->prepare("SELECT * FROM callinfo 
	                                  INNER JOIN staff AS staff ON callinfo.staffID = staff.staffID
	                                  INNER JOIN branches AS branches ON callinfo.branchID = branches.branchID
	                                  WHERE emailed = 'Not Emailed'
	                                  AND (callinfo.type != '' and callinfo.type != 'checkinsBlank' and callinfo.type != 'checkin_outstanding')
	                                  AND staff.staffID = ?
	                                  AND staff.branchID = '27'
	                                  ORDER BY dateInputted DESC");
	  
	  $notEmailed->execute(array($staffID));
	  $results = $notEmailed->fetchAll(PDO::FETCH_ASSOC);

	  return $results;
	}

	function branches($DBH) {
	  $branches = $DBH->prepare('SELECT branchName FROM branches WHERE ((branchName != "Head Office"))');
	  //$branches = $DBH->prepare('SELECT branchName FROM branches WHERE (branchName != "Head Office")'); AND (branchName != "Nightline Wrexham")
	  $branches->execute();
	  $result = $branches->fetchAll(PDO::FETCH_ASSOC);

	  return $result;
	}

	function avail($DBH, $branchName) {
	  $avail = $DBH->prepare('SELECT * FROM availability 
	                            INNER JOIN branches AS branches ON availability.branchID = branches.branchID
	                            LEFT JOIN clientname AS clientname ON availability.clientNameID = clientname.clientNameID
	                            WHERE date(dateTime) = CURDATE()
	                            AND branches.branchName = ?
	                            ORDER BY availability.dateTime ASC');
	  $avail->execute(array($branchName));
	  $result = $avail->fetchAll(PDO::FETCH_ASSOC);

	  return $result;
	}
}