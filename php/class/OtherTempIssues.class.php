<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class TempOther {

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
									FROM callinfo, temp, branches 
									WHERE branches.branchID = callinfo.branchID
									AND temp.tempID = callinfo.tempID
									AND callinfo.type = "other temp issues"
									AND callinfo.dateInputted >= (CURDATE() - INTERVAL 14 DAY)
									GROUP BY callinfo.callID
									ORDER BY callinfo.dateInputted DESC, callinfo.timeInputted DESC');
		$query->execute();
		$result = $query->fetchALL(PDO::FETCH_ASSOC);
		return $result;
	}

	
}