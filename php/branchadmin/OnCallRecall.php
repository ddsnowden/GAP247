<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

if(isset($_POST['branchGet'])) {
	require_once $root.'/assets/php/class/OnCall.class.php';
	$oncall = new OnCall();
	$_SESSION['form']['OnCallRecall'] = $oncall->oncallList($DBH, $_POST['branchGet']);

	$page = '/pages/BranchAdmin/OnCall.php';
	
	echo json_encode($page);
}