<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class HeadOffice
{
	function contacts($DBH) {
		$query = $DBH->prepare('SELECT firstName, lastName, position FROM headContacts ORDER BY firstName ASC');
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

}