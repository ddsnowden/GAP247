<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

/**
* 
*/
class Chat
{
	function show($DBH) {
		$query = $DBH->prepare('SELECT * FROM chat ORDER BY sent_on DESC');
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	function insert() {

	}
}