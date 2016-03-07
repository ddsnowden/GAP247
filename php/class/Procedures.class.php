<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class Procedures
{
	function update($DBH, $advert, $bookings, $cancellations, $checkins, $sick, $tempnoshow, $working, $otherclient, $pay, $othertemp, $branch) {
		$query = 'UPDATE branches SET advert = ?,
									 bookings = ?,
									 cancellations = ?,
									 checkins = ?,
									 sick = ?,
									 tempnoshow = ?,
									 working = ?,
									 otherclient = ?,
									 pay = ?,
									 othertemp = ? 
								WHERE branchNameShort = ?';
		$U = $DBH->prepare($query);
		$U->execute(array($advert, $bookings, $cancellations, $checkins, $sick, $tempnoshow, $working, $otherclient, $pay, $othertemp, $branch));
	}
}