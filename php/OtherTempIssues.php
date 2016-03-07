<?php
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';


if(isset($_POST['recallID'])) {
	// Recall all call details
	require_once $root.'/assets/php/class/Recall.class.php';
	$recall = new Recall();
	$_SESSION['form'] = $recall->otherRecall($DBH, $_POST['recallID']);

	// Duty Numbers
	require_once $root.'/assets/php/class/Branches.class.php';
	$duty = new Branches();
	$_SESSION['form']['duty'] = $duty->duty($DBH, $_SESSION['form']['branchID']);

	// Procedures
	$_SESSION['form']['procedure'] = $duty->procedure($DBH, $_SESSION['form']['branchNameShort'], $_POST['callType']);

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
	require_once $root.'/assets/php/class/Common.class.php';
	require_once $root.'/assets/php/class/Branches.class.php';
	$common = new Common();
	$branches = new Branches();

	$form = $_POST;

	$currentDate = date('Y-m-d');
	$currentTime = date('H:i:s');

	if(empty($postcode)) {
		$form['postcode'] = NULL;
	}

	$contact = NULL;  //Does not have a head office contact

	$branch = $branches->branchDetails($DBH, $form['branchNameShort']);

	/* ********************************************************************************  Deal with client details  ************************************************************ */
	//Check Client
	$clientID = NULL;
	//Check Client Name
	$clientNameID = NULL;
	
	$tempID = $common->tempCompare($DBH, $form['title'], $form['firstName'], $form['lastName'], $form['landline'], $form['mobile'], $branch['branchID'], $form['tempID']);
	/* ********************************************************************************  Deal with Call  ************************************************************ */
	//Check if there is a callID posted
	if(isset($form['callID']) && ($form['callID'] != '')) {
		//Call Exists and needs updating
		$further = $common->furtherExtra($DBH, $form['callID'], $form['further'], $currentTime, $currentDate, $_SESSION['login']['staffID']);
		$common->callUpdate($DBH, $clientID, $form['clientNameID'], $tempID, $branch['branchID'], $contact, $form['status'], $form['details'], $further, $form['callID']);

		$common->clearReturn($form['page']);
	}
	else {
		//Call does not exist and needs inserting
		$further = $common->further($DBH, $form['further'], $currentTime, $currentDate, $_SESSION['login']['staffID']);
		$callID = $common->callInsert($DBH, $clientID, $clientNameID, $tempID, $branch['branchID'], $contact, $_SESSION['login']['staffID'], $form['type'], $form['status'], $form['details'], $further, $currentTime, $currentDate);
		
		$common->clearReturn($form['page']);
	}
}