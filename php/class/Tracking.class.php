<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class Tracking
{
	function track($DBH, $staffID, $currentDate, $currentTime) {
	    $trackInput = 'INSERT INTO tracking (staffID,
	                    dateIn,
	                    timeIn) 
	                VALUES (:staffID,
	                        :dateIn,
	                        :timeIn)';

	    $CTI = $DBH->prepare($trackInput);
	    $CTI->bindParam(':staffID', $staffID);
	    $CTI->bindParam(':dateIn', $currentDate);
	    $CTI->bindParam(':timeIn', $currentTime);
	    $CTI->execute();
	}
}