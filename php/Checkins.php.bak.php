<?php
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';
require_once $root.'/kint/Kint.class.php';

if(isset($_POST['recallID'])) {

	// Recall all call details
	require_once $root.'/assets/php/class/Recall.class.php';
	$recall = new Recall();
	$_SESSION['form'] = $recall->checkinRecall($DBH, $_POST['recallID']);

	// Duty Numbers
	require_once $root.'/assets/php/class/Branches.class.php';
	$duty = new Branches();
	$_SESSION['form']['duty'] = $duty->duty($DBH, $_SESSION['form']['branchID']);

	// Procedures
	$_SESSION['form']['procedure'] = $duty->procedure($DBH, $_SESSION['form']['branchNameShort'], $_POST['callType']);

	//Join the date and time needed and store
	$date = date('Y-m-d', strtotime($_SESSION['form']['dateToCall']));
	$time = date('H:i', strtotime($_SESSION['form']['timeToCall']));
	$datetime = date('d-m-Y H:i', strtotime("$date $time"));

	$_SESSION['form']['datetime'] = $datetime;

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
	require_once $root.'/assets/php/class/Checkins.class.php';
	require_once $root.'/assets/php/class/Common.class.php';
	require_once $root.'/assets/php/class/Branches.class.php';
	$checkin = new Checkins();
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

	$compDate = date('Y-m-d H:i:s');

	/* ********************************************************************************  Deal with client details  ************************************************************ */
	//Check Client
	$clientID = $common->clientCompare($DBH, $form['clientID'], $form['clientNameID'], $form['title'], $form['firstName'], $form['lastName'], $form['landline'], $form['mobile']);
	//Check Client Name
	$clientNameID = $common->clientNameCompare($DBH, $form['clientNameID'], $form['clientName'], $form['postcode']);

	/*********************************************************************************************/
	//Deal with the remote checkin form
			
	//Alter the existing call and send back to branch
	if ($form['status'] != "Completed") {

		if ($form['checkCall'] == "0") {
			//Update template to checkin_outstanding
			$type = "checkin_outstanding";
			$active = "Active";
			$checkin->callUpdateTemplate($DBH, $type, $active, $form['callID']);
			
			//Work on the new call
			$type = "Checkin";

			//Create new call and insert using template ID for checkinCallID
			$further = $common->further($DBH, $form['further'], $currentTime, $currentDate, $_SESSION['login']['staffID']);
			$compDate = '';
			$checkin->callInsert($DBH, $clientID, $clientNameID, $tempID, $branch['branchID'], $_SESSION['login']['staffID'], $form['callID'], $type, $form['status'], $form['details'], $further, $reqTime, $reqDate, $active, $currentTime, $currentDate, $compDate);
		}
		else {
			echo "Not Here";
			$further = $common->furtherExtra($DBH, $form['callID'], $form['further'], $currentTime, $currentDate, $_SESSION['login']['staffID']);
			$checkin->callUpdate($DBH, $clientID, $clientNameID, $tempID, $branch['branchID'], $_SESSION['login']['staffID'], $form['type'], $form['status'], $form['details'], $further, $form['active'], $form['callID']);
		}
	}
	elseif ($form['status'] == "Completed") {  //Post Status Completed elseif
		//Update template to checkinsBlank

		$type = "checkinsBlank";
		$active = "Inactive";
		$status = "Outstanding";

		$checkin->callUpdateTemplate2($DBH, $type, $status, $active, $form['checkCall']);

		if ($form['further'] == "") {
			$further = $common->further($DBH, $form['further'], $currentTime, $currentDate, $_SESSION['login']['staffID']);
		}
		else {
			$further = $common->furtherExtra($DBH, $form['callID'], $form['further'], $currentTime, $currentDate, $_SESSION['login']['staffID']);
		}
		//Check for a value in checkCall, if a value exists then a nightline call exists
		if ($form['checkCall'] == "0") {

			//Work on the new call
			//Create new call and insert using template ID for checkinCallID
			$type = "checkins_complete";
			$active = "Inactive";
			$checkin->callInsert($DBH, $clientID, $clientNameID, $tempID, $branch['branchID'], $_SESSION['login']['staffID'], $form['checkCall'], $type, $form['status'], $form['details'], $further, $reqTime, $reqDate, $active, $currentTime, $currentDate, $compDate);
			
			$type = "checkinsBlank";
			$checkin->callUpdateTemplate($DBH, $type, $active, $form['callID']);
		}
		elseif ($form['checkCall'] != "0") {
			$type = "checkins_complete";
			$status = "Completed";
			$checkin->callUpdateNightline($DBH, $form['details'], $further, $compDate, $form['callID']);
			$checkin->callUpdateTemplate2($DBH, $type, $status, $active, $form['callID']);
		}
	} //End Post Status Completed elseif
	$common->clearReturn($form['page']);
}
elseif(isset($_POST['add'])) {
	require_once $root.'/assets/php/class/Checkins.class.php';
	require_once $root.'/assets/php/class/Common.class.php';
	require_once $root.'/assets/php/class/Branches.class.php';
	$checkin = new Checkins();
	$common = new Common();
	$branches = new Branches();

	$form = $_POST;

	$currentDate = date('Y-m-d');
	$currentTime = date('H:i:s');

	$compDate = date('Y-m-d H:i:s');

	if(empty($postcode)) {
		$form['postcode'] = NULL;
	}

	$tempID = NULL;  //Set as this as its a booking and does not contain temp user data
	$contact = NULL;  //Does not have a head office contact

	$branch = $branches->branchDetails($DBH, $form['branchNameShort']);

	//Split date time
	$reqDate = date('Y-m-d', strtotime($form['datetime']));
	$reqTime = date('H:i', strtotime($form['datetime']));

	/* ********************************************************************************  Deal with client details  ************************************************************ */
	//Check Client
	$clientID = $common->clientCompare($DBH, $form['clientID'], $form['clientNameID'], $form['title'], $form['firstName'], $form['lastName'], $form['landline'], $form['mobile']);
	//Check Client Name
	$clientNameID = $common->clientNameCompare($DBH, $form['clientNameID'], $form['clientName'], $form['postcode']);

	$status = "Outstanding";
	$tempID = NULL;
	$type = "Checkin";
	$active = "Active";
	$further = "";
	
	$compDate = '';

	$checkin->callInsert($DBH, $clientID, $clientNameID, $tempID, $branch['branchID'], $_SESSION['login']['staffID'], $form['checkCall'], $type, $form['status'], $form['details'], $further, $reqTime, $reqDate, $active, $currentTime, $currentDate, $compDate);

	$common->clearReturn($form['page']);
}