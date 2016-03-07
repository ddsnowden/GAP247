<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class ClientOtherIssues
{
	function recall($DBH) {
		$query = $DBH->prepare('SELECT callinfo.callID, 
										callinfo.dateInputted, 
										callinfo.timeInputted, 
										callinfo.emailed,
										branches.branchNameShort, 
										clientname.clientName, 
										clientname.clientNameID,
										client.firstName, 
										client.lastName, 
										client.landline, 
										client.mobile
									FROM callinfo
									INNER JOIN client as client on callinfo.clientID = client.clientID
									INNER JOIN clientname as clientname on client.clientNameID = clientname.clientNameID
									INNER JOIN branches as branches on callinfo.branchID = branches.branchID
									WHERE callinfo.type = "client other issues"
									AND callinfo.dateInputted >= (CURDATE() - INTERVAL 14 DAY)
									GROUP BY callinfo.callID
									ORDER BY callinfo.dateInputted DESC, callinfo.timeInputted DESC');
		$query->execute();
		$result = $query->fetchALL(PDO::FETCH_ASSOC);
		return $result;
	}

	//Insert cancellation details to table
	function cancelInput($DBH, $callID, $workerName, $date, $time) {
		$cancelInput = 'INSERT INTO cancellations (callID, 
									workerName, 
									dateNeeded,
									timeNeeded) 
								VALUES (:callID, 
									:workerName,
									:dateNeeded,
									:timeNeeded)';
				
					$BI = $DBH->prepare($cancelInput);
					$BI->bindParam(':callID', $callID);
					$BI->bindParam(':workerName', $workerName);
					$BI->bindParam(':dateNeeded', $date);
					$BI->bindParam(':timeNeeded', $time);
					$BI->execute();
	}

	function cancelUpdate($DBH, $workerName, $date, $time, $callID) {
		$cancelUpdate = 'UPDATE cancellations SET 
												workerName =?, 
												dateNeeded = ?, 
												timeNeeded = ?
												WHERE callID = ?';

					$BI = $DBH->prepare($cancelUpdate);
					$BI->execute(array(	$workerName, 
										$date, 
										$time,  
										$callID));	
	}
}