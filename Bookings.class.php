<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class Bookings
{
	function recall($DBH) {
		$recall = $DBH->prepare('SELECT callinfo.callID, 
										callinfo.emailed,
										callinfo.dateInputted,
										callinfo.timeInputted,
										branches.branchNameShort, 
										clientname.clientName,
										client.firstName, 
										client.lastName, 
										client.landline, 
										client.mobile
									FROM callinfo
									LEFT JOIN client as client on callinfo.clientID = client.clientID
									LEFT JOIN clientname as clientname on client.clientNameID = clientname.clientNameID
									INNER JOIN bookings as bookings on callinfo.callID = bookings.callID
									INNER JOIN branches as branches on callinfo.branchID = branches.branchID
									WHERE callinfo.type = "bookings"
									AND callinfo.dateInputted >= (CURDATE() - INTERVAL 14 DAY)
									GROUP BY callinfo.callID
									ORDER BY callinfo.dateInputted DESC, callinfo.timeInputted DESC');
		$recall->execute();
		$result = $recall->fetchALL(PDO::FETCH_ASSOC);
		return $result;
	}

	//Insert booking details to table
	function bookingInput($DBH, $callID, $quantity, $workerType, $date, $time, $filled) {
		//insert into bookings table and collect last insert id
		$bookingInput = 'INSERT INTO bookings (callID, 
												quantity, 
												workerType, 
												dateNeeded,
												timeNeeded, 
												filled) 
											VALUES (:callID, 
												:quantity, 
												:workerType,
												:dateNeeded,
												:timeNeeded, 
												:filled)';

		$BI = $DBH->prepare($bookingInput);
		$BI->bindParam('callID', $callID);
		$BI->bindParam(':quantity', $quantity);
		$BI->bindParam(':workerType', $workerType);
		$BI->bindParam(':dateNeeded', $date);
		$BI->bindParam(':timeNeeded', $time);
		$BI->bindParam(':filled', $filled);
		$BI->execute();
	}

	//Update booking details
	function bookingUpdate($DBH, $quantity, $workerType, $date, $time, $filled, $callID) {
		$bookingUpdate = 'UPDATE bookings SET 
										quantity = ?, 
										workerType = ?, 
										dateNeeded = ?, 
										timeNeeded = ?, 
										filled = ? 
										WHERE callID = ?';

		$BI = $DBH->prepare($bookingUpdate);
		$BI->execute(array(	$quantity, 
							$workerType, 
							$date, 
							$time, 
							$filled, 
							$callID));
	}
}