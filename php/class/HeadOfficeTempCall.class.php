<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';
require_once $root.'/assets/php/class/HeadOffice.class.php';

class HeadOfficeTempCalls extends HeadOffice
{
	function recall($DBH) {
		$query = $DBH->prepare('SELECT callinfo.callID, 
										callinfo.dateInputted, 
										callinfo.timeInputted, 
										callinfo.emailed, 
										branches.branchNameShort, 
										temp.tempID,
										temp.firstName, 
										temp.lastName, 
										temp.landline, 
										temp.mobile 
									FROM callinfo
									LEFT JOIN temp as temp on callinfo.tempID = temp.tempID
									INNER JOIN branches as branches on callinfo.branchID = branches.branchID
									WHERE callinfo.type = "head office temp call"
									AND callinfo.dateInputted >= (CURDATE() - INTERVAL 14 DAY)
									ORDER BY callinfo.dateInputted DESC, callinfo.timeInputted DESC');
		$query->execute();
		$result = $query->fetchALL(PDO::FETCH_ASSOC);
		return $result;
	}
}