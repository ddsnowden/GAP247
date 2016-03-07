<?php
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';


if(isset($_POST['recallID'])) {
	// Recall all call details
	require_once $root.'/assets/php/class/Recall.class.php';
	$recall = new Recall();
	$_SESSION['form'] = $recall->feedbackRecall($DBH, $_POST['recallID']);

	$success = 'success';
	echo json_encode($success);
}
elseif (isset($_GET['branch'])) {
	require_once $root.'/assets/php/class/Branches.class.php';

	// Get branch details and set call type
	$BD = new Branches();
	$_SESSION['form'] = $BD->branchDetails($DBH, $_GET['branch']);
	$_SESSION['form']['type'] = $_GET['callType'];

	// Duty Numbers
	require_once $root.'/assets/php/class/Branches.class.php';
	$duty = new Branches();
	$_SESSION['form']['duty'] = $duty->duty($DBH, $_SESSION['form']['branchID']);

	// Procedures
	$_SESSION['form']['procedure'] = $duty->procedure($DBH, $_SESSION['form']['branchNameShort'], $_GET['callType']);

	$success = 'success';
	echo json_encode($success);
}
elseif(isset($_POST['submit'])) {
	require_once $root.'/assets/php/class/Feedback.class.php';
	require_once $root.'/assets/php/class/Common.class.php';
	require_once $root.'/assets/php/class/Branches.class.php';
	$feed = new Feedback();
	$common = new Common();
	$branches = new Branches();

	$_SESSION['form'] = $form = $_POST;

	$currentDate = date('Y-m-d');
	$currentTime = date('H:i:s');

	//$branch = $branches->branchDetails($DBH, $form['branchNameShort']);

	/* ********************************************************************************  Deal with Call  ************************************************************ */
	$further = '';
	$status = '';

	if((isset($form['operator'])) && ($form['operator']) != '') {
		$operatorID = $form['operator'];
	}
	else {
		$operatorID = NULL;
	}
	
	if(!empty($form['callIDRef'])) {
		$callIDRef = $feed->checkCallID($DBH, $form['callIDRef']);
		if ($callIDRef['count'] == '0') {
			echo "<script>
					 alert('Unfortunately this call refernce number is not in the database, please check the reference number and try again'); 
					 window.history.go(-1);
			 </script>";
			 exit();
		}
	}
	else {
		$callIDRef = $form['callIDRef'];
	}

	$feedID = $feed->feedbackInsert($DBH, $form['feedbackType'], $form['complaintType'], $operatorID, $callIDRef, $form['procType'], $form['details'], $currentTime, $currentDate, $_SESSION['login']['branchID'], $further, $status, $_SESSION['login']['staffID']);
	$_SESSION['form']['type'] = 'feedback';
	if (isset($feedID) && $feedID != "") {
		echo '<script>window.location.href = "/assets/php/Email.php"</script>';
	}
	else {
		echo "<script>
					 alert('Unfortunately there seems to have been an issue submitting your feedback, please try again.  Should you continue to have problems please contact Dean Langford directly at dean.langford@gap-personnel.com'); 
					 window.history.go(-1);
			 </script>";
	}

	
	//$common->clearReturn($form['page']);
	
}