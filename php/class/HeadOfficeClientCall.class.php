<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';
require_once $root.'/assets/php/class/HeadOffice.class.php';

class HeadOfficeClientCalls extends HeadOffice
{
	function recall($DBH) {
		$query = $DBH->prepare('SELECT callinfo.callID, 
										callinfo.dateInputted, 
										callinfo.timeInputted, 
										callinfo.emailed, 
										branches.branchNameShort, 
										client.clientID,
										clientname.clientNameID,
										client.firstName, 
										client.lastName, 
										client.landline, 
										client.mobile 
									FROM callinfo
									LEFT JOIN client as client on callinfo.clientID = client.clientID
									LEFT JOIN clientname as clientname on client.clientNameID = clientname.clientNameID
									INNER JOIN branches as branches on callinfo.branchID = branches.branchID
									WHERE callinfo.type = "head office client call"
									AND callinfo.dateInputted >= (CURDATE() - INTERVAL 14 DAY)
									ORDER BY callinfo.dateInputted DESC, callinfo.timeInputted DESC');
		$query->execute();
		$result = $query->fetchALL(PDO::FETCH_ASSOC);
		return $result;
	}
}