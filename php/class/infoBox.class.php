<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class infoPanel {

	public function pull($DBH) {
    	$query = $DBH->prepare('SELECT * FROM info ORDER BY dateTime DESC');
    	$query->execute();
    	$result = $query->fetchAll(PDO::FETCH_ASSOC);
    	return $result;
    }

    public function insert($DBH, $postType, $info, $dateTime) {
    	$query = 'INSERT INTO info (postType, info, dateTime) VALUES (:postType, :info, :dateTime)';
    	$I = $DBH->prepare($query);
    	$I->bindParam(':postType', $postType);
    	$I->bindParam(':info', $info);
    	$I->bindParam(':dateTime', $dateTime);
    	$I->execute();
    }
}