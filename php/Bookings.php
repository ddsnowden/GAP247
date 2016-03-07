<?php
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';


if(isset($_POST['recallID'])) {
	// Recall all call details
	require_once $root.'/assets/php/class/Recall.class.php';
	$recall = new Recall();
	$_SESSION['form'] = $recall->bookingRecall($DBH, $_POST['recallID']);

	//Join the date and time needed and store
	$date = date('Y-m-d', strtotime($_SESSION['form']['dateNeeded']));
	$time = date('H:i', strtotime($_SESSION['form']['timeNeeded']));
	$datetime = date('d-m-Y H:i', strtotime("$date $time"));

	$_SESSION['form']['datetime'] = $datetime;
	
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
	require_once $root.'/assets/php/class/Bookings.class.php';
	require_once $root.'/assets/php/class/Common.class.php';
	require_once $root.'/assets/php/class/Branches.class.php';
	$booking = new Bookings();
	$common = new Common();
	$branches = new Branches();

	$form = $_POST;

	$currentDate = date('Y-m-d');
	$currentTime = date('H:i:s');

	if(empty($postcode)) {
		$form['postcode'] = NULL;
	}

	$tempID = NULL;  //Set as this as its a booking and does not contain temp user data
	$contact = NULL;  //Does not have a head office contact

	$branch = $branches->branchDetails($DBH, $form['branchNameShort']);

	//Split date time
	$reqDate = date('Y-m-d', strtotime($form['datetime']));
	$reqTime = date('H:i', strtotime($form['datetime']));

	$clientNameID = $common->clientNameCompare($DBH, $form['clientNameID'], $form['clientName'], $form['postcode']);
	//Check Client
	$clientID = $common->clientCompare($DBH, $form['clientID'], $clientNameID, $form['title'], $form['firstName'], $form['lastName'], $form['landline'], $form['mobile']);
	//Check Client Name
	
	/* ********************************************************************************  Deal with Call  ************************************************************ */
	//Check if there is a callID posted
	if(isset($form['callID']) && ($form['callID'] != '')) {
		//Call Exists and needs updating
		$further = $common->furtherExtra($DBH, $form['callID'], $form['further'], $currentTime, $currentDate, $_SESSION['login']['staffID']);
		$common->callUpdate($DBH, $form['clientID'], $form['clientNameID'], $tempID, $branch['branchID'], $contact, $form['status'], $form['details'], $further, $form['callID']);
		$booking->bookingUpdate($DBH, $form['quantity'], $form['workerType'], $reqDate, $reqTime, $form['filled'], $form['callID']);

		$common->clearReturn($form['page']);
	}
	else {
		/* ********************************************************************************  Deal with client details  ************************************************************ */
		//Call does not exist and needs inserting
		$further = $common->further($DBH, $form['further'], $currentTime, $currentDate, $_SESSION['login']['staffID']);
		$callID = $common->callInsert($DBH, $clientID, $clientNameID, $tempID, $branch['branchID'], $contact, $_SESSION['login']['staffID'], $form['type'], $form['status'], $form['details'], $further, $currentTime, $currentDate);
		$booking->bookingInput($DBH, $callID, $form['quantity'], $form['workerType'], $reqDate, $reqTime, $form['filled']);

		$common->clearReturn($form['page']);
	}
}