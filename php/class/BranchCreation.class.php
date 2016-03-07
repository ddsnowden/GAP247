<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class BranchCreation
{
	function insert($DBH, $branchNameShort, $branchName, $branchAddressOne, $branchAddressTwo, $branchAddressThree, $branchCity, $branchPostcode, $branchTelephone, $branchEmail, $divertNumber) {
		$query = 'INSERT INTO branches (branchNameShort, branchName, branchAddressOne, branchAddressTwo, branchAddressThree, branchCity, branchPostcode, branchTelephone, branchEmail, divertNumber) 
					VALUES
					(:branchNameShort, :branchName, :branchAddressOne, :branchAddressTwo, :branchAddressThree, :branchCity, :branchPostcode, :branchTelephone, :branchEmail, :divertNumber)';
		$IN = $DBH->prepare($query);
		$IN->bindParam('branchNameShort', $branchNameShort);
		$IN->bindParam('branchName', $branchName);
		$IN->bindParam('branchAddressOne', $branchAddressOne);
		$IN->bindParam('branchAddressTwo', $branchAddressTwo);
		$IN->bindParam('branchAddressThree', $branchAddressThree);
		$IN->bindParam('branchCity', $branchCity);
		$IN->bindParam('branchPostcode', $branchPostcode);
		$IN->bindParam('branchTelephone', $branchTelephone);
		$IN->bindParam('branchEmail', $branchEmail);
		$IN->bindParam('divertNumber', $divertNumber);
		$IN->execute();
	}
}