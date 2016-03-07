<?php	
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';


$client = $DBH->prepare('SELECT * FROM branches 
							WHERE branchNameShort = ?');
$clientName = $_GET['recallGet'];
$client->execute(array($clientName));
$resultsArray = $client->fetchAll(PDO::FETCH_ASSOC);

$_SESSION['form']['procEdit'] = $resultsArray[0];

echo json_encode('success');

?>