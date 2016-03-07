<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

if(isset($_POST['msg'])) {

	$sent_on = date('Y-m-d H:i:s');
	$username = $_SESSION['login']['username'];
	$query = 'INSERT INTO chat (username, message, sent_on) VALUES (:username, :msg, :sent_on)';
	$Q = $DBH->prepare($query);
	$Q->bindParam('username', $username);
	$Q->bindParam('msg', $_POST['msg']);
	$Q->bindParam('sent_on', $sent_on);
	$Q->execute();

	$success = 'success';
	echo json_encode($success);
}