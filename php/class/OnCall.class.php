<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class OnCall
{
	function oncallList($DBH, $branchID) {
		//Find the information for the contact and store to array
		$query = $DBH->prepare('SELECT contactID, contactNameFirst, contactNameLast, contactTelephone, inUse, branchNameShort, lastChanged
											FROM contacts, branches 
											WHERE contacts.branchID = branches.branchID 
											AND branches.branchID = ? 
											GROUP BY contacts.contactID');
		$query->execute(array($branchID));
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	function update($DBH, $contactNameFirst, 
									$contactNameLast, 
									$contactTelephone, 
									$inUse,
									$lastChanged,
									$contactID,
									$staffID) {
		//Update script if the arrays are different
		$contactsUpdate = 'UPDATE contacts SET contactNameFirst = ?, 
											contactNameLast = ?, 
											contactTelephone = ?, 
											inUse = ?,
											lastChanged = ?,
											staffID = ?
											WHERE contactID = ?';
		$BI = $DBH->prepare($contactsUpdate);
		$BI->execute(array($contactNameFirst, 
									$contactNameLast, 
									$contactTelephone, 
									$inUse,
									$lastChanged,
									$staffID,
									$contactID));
	}

	function insert($DBH, $newFirst, $newLast, $newTele, $branchID, $lastChanged, $staffID) {
		$insert = 'INSERT INTO contacts (contactNameFirst, contactNameLast, contactTelephone, branchID, lastChanged, staffID) VALUES (:contactNameFirst, :contactNameLast, :contactTelephone, :branchID, :lastChanged, :staffID)';
		$INS = $DBH->prepare($insert);
		$INS->bindParam(':contactNameFirst', $newFirst);
		$INS->bindParam(':contactNameLast', $newLast);
		$INS->bindParam(':contactTelephone', $newTele);
		$INS->bindParam(':branchID', $branchID);
		$INS->bindParam(':lastChanged', $lastChanged);
		$INS->bindParam(':staffID', $staffID);
		$INS->execute();
	}

	function delete($DBH, $contactID) {
		$delete = $DBH->prepare('DELETE FROM contacts WHERE contactID = :contactID');
		$delete->bindParam(':contactID', $contactID);
		$delete->execute();
	}
}