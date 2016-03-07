<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class TempNoShow {

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
									INNER JOIN tempnoshow as tempnoshow on callinfo.callID = tempnoshow.callID
									INNER JOIN branches as branches on callinfo.branchID = branches.branchID
									WHERE callinfo.type = "Temp No Show"
									AND callinfo.dateInputted >= (CURDATE() - INTERVAL 14 DAY)
									GROUP BY callinfo.callID
									ORDER BY callinfo.dateInputted DESC, callinfo.timeInputted DESC');
		$query->execute();
		$result = $query->fetchALL(PDO::FETCH_ASSOC);

		return $result;
	}

	function noShowInput($DBH, $callID, $noQuantity, $fillQuantity, $date, $time) {
		$noShowInput = 'INSERT INTO tempnoshow (callID, 
										noQuantity,
										fillQuantity, 
										dateNeeded,
										timeNeeded) 
									VALUES (:callID, 
										:noQuantity, 
										:fillQuantity, 
										:dateNeeded,
										:timeNeeded)';
					
						$BI = $DBH->prepare($noShowInput);
						$BI->bindParam(':callID', $callID);
						$BI->bindParam(':noQuantity', $noQuantity);
						$BI->bindParam(':fillQuantity', $fillQuantity);
						$BI->bindParam(':dateNeeded', $date);
						$BI->bindParam(':timeNeeded', $time);
						$BI->execute();
		}

		function noShowUpdate($DBH, $noQuantity, $fillQuantity, $date, $time, $callID) {
			$noShowUpdate = 'UPDATE tempnoshow SET
										noQuantity = ?,
										fillQuantity = ?, 
										dateNeeded = ?,
										timeNeeded = ?
										WHERE callID = ?';
					
						$BI = $DBH->prepare($noShowUpdate);
						$BI->execute(array($noQuantity,
											$fillQuantity, 
											$date,
											$time,
											$callID));
		}
}