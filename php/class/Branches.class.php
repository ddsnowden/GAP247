<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class Branches
{
	function branchDetails($DBH, $branchNameShort) {
		$query = $DBH->prepare('SELECT * FROM branches WHERE branchNameShort = ?');
		$query->execute(array($branchNameShort));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	function branchDetailsID($DBH, $branchID) {
		$database = $DBH->prepare('SELECT * FROM branches WHERE branchID = ?');
		$database->execute(array($branchID));
		$branchNameShort = $database->fetch(PDO::FETCH_ASSOC);
		return $branchNameShort;
	}

	function branchList($DBH) {
		$query = 'SELECT branchID, branchNameShort, branchName FROM branches ORDER BY branchName ASC';
		$result = $DBH->prepare($query);
		$result->execute();
		$result = $result->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	function procedure($DBH, $branch, $type) {
		$branchInfo = $DBH->prepare('SELECT branches.*, callinfo.type FROM branches
										INNER JOIN callinfo as callinfo on branches.branchID = callinfo.branchID
										WHERE (branches.branchNameShort, callinfo.type) = (?, ?)
										GROUP BY branches.branchID');
		$branchInfo->execute(array($branch, $type));
		$branchResult = $branchInfo->fetch(PDO::FETCH_ASSOC);
		return $branchResult;
	}

	function duty($DBH, $branchID) {
		$duty = $DBH->prepare('SELECT contacts.contactNameFirst, contacts.contactNameLast, contacts.contactTelephone, contacts.inUse 
									FROM contacts, branches 
									WHERE branches.branchID = contacts.branchID 
									AND branches.branchID = ? 
									AND contacts.inUse >= 1 
									ORDER BY contacts.inUse');
		$duty->execute(array($branchID));
		$result = $duty->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}
}