<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class Sick {

	function recall($DBH) {
		$query = $DBH->prepare('SELECT callinfo.callID, 
										callinfo.dateInputted, 
										callinfo.timeInputted, 
										callinfo.emailed, 
										branches.branchNameShort, 
										temp.firstName, 
										temp.lastName, 
										temp.landline, 
										temp.mobile 
									FROM callinfo, temp, sickabsent, branches 
									WHERE branches.branchID = callinfo.branchID
									AND sickabsent.callID = callinfo.callID
									AND temp.tempID = callinfo.tempID
									AND callinfo.type = "sickness or absence"
									AND callinfo.dateInputted >= (CURDATE() - INTERVAL 14 DAY)
									GROUP BY callinfo.callID
									ORDER BY callinfo.dateInputted DESC, callinfo.timeInputted DESC
									');
		$query->execute();
		$result = $query->fetchALL(PDO::FETCH_ASSOC);
		return $result;
	}

	function sickInsert($DBH, $callID, $reason, $date, $time) {
		$query = 'INSERT INTO sickabsent (callID, 
									reason,
									dateNeeded,
									timeNeeded) 
								VALUES (:callID, 
									:reason,
									:dateNeeded,
									:timeNeeded)';
				
					$BI = $DBH->prepare($query);
					$BI->bindParam(':callID', $callID);
					$BI->bindParam(':reason', $reason);
					$BI->bindParam(':dateNeeded', $date);
					$BI->bindParam(':timeNeeded', $time);
					$BI->execute();
	}

	function sickUpdate($DBH, $reason, $date, $time, $callID) {
		$query = 'UPDATE sickabsent SET
									reason = ?,
									dateNeeded = ?,
									timeNeeded = ?
									WHERE callID = ?';
				
					$BI = $DBH->prepare($query);
					$BI->execute(array($reason,
										$date,
										$time,
										$callID));
					$BI->execute();
	}
}