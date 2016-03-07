<?php
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';


if(isset($_POST['recallID'])) {

	// Recall all call details
	require_once $root.'/assets/php/class/Recall.class.php';
	$recall = new Recall();
	$_SESSION['form'] = $recall->matalanRecall($DBH, $_POST['recallID']);

	// Duty Numbers
	//require_once $root.'/assets/php/class/Branches.class.php';
	//$duty = new Branches();
	//$_SESSION['form']['duty'] = $duty->duty($DBH, $_SESSION['form']['branchID']);

	// Procedures
	//$_SESSION['form']['procedure'] = $duty->procedure($DBH, $_SESSION['form']['branchNameShort'], $_POST['callType']);

	$success = 'success';
	echo json_encode($success);
}
elseif (isset($_GET['branch'])) {
	require_once $root.'/assets/php/class/Branches.class.php';

	// Get branch details and set call type
	$BD = new Branches();
	$_SESSION['form'] = $BD->branchDetails($DBH, $_GET['branch']);
	$_SESSION['form']['type'] = $_GET['callType'];

	require_once $root.'/assets/php/class/Branches.class.php';
	$duty = new Branches();
	$_SESSION['form']['duty'] = $duty->duty($DBH, $_SESSION['form']['branchID']);

	// Procedures
	$_SESSION['form']['procedure'] = $duty->procedure($DBH, $_SESSION['form']['branchNameShort'], $_GET['callType']);

	$success = 'success';
	echo json_encode($success);
}
elseif(isset($_POST['submit'])) {
	require_once $root.'/assets/php/class/Advert.class.php';
	require_once $root.'/assets/php/class/Common.class.php';
	require_once $root.'/assets/php/class/Branches.class.php';
	$advert = new Advert();
	$common = new Common();
	$branches = new Branches();

	$form = $_POST;

	$currentDate = date('Y-m-d');
	$currentTime = date('H:i:s');

	if(empty($form['postcode'])) {
		$form['postcode'] = NULL;
	}

	
	$contact = NULL;  //Does not have a head office contact

	$branch = $branches->branchDetails($DBH, $form['branchNameShort']);

	//$jobType = "Industrial";

	//Split date time
	//$reqDate = date('Y-m-d', strtotime($form['datetime']));
	//$reqTime = date('H:i', strtotime($form['datetime']));

	/* ********************************************************************************  Deal with client details  ************************************************************ */
	//Check Client
	$clientID = NULL;
	//Check Client Name
	$clientNameID = NULL;

	//Job advert temp control
	//Check if address is already there so as not to keep adding a comma to the front on update
	if(strpos($form['addressOne'], ',') !== false) {
		$addressOne = $form['addressOne'];
	}
	else {
		$addressOne = $form['nameNumber'].', '.$form['addressOne'];
	}

	$tempID = $common->tempCompareAddress($DBH, $form['title'], $form['firstName'], $form['lastName'], $form['landline'], $form['mobile'], $addressOne, $form['addressTwo'], $form['city'], $form['postcode'], $branch['branchID'], $form['tempID']);  //Set as this as its a booking and does not contain temp user data
	/* ********************************************************************************  Deal with Call  ************************************************************ */
	//Check if there is a callID posted
	if(isset($form['callID']) && ($form['callID'] != '')) {
		//Call Exists and needs updating
		$further = $common->furtherExtra($DBH, $form['callID'], $form['further'], $currentTime, $currentDate, $_SESSION['login']['staffID']);
		$common->callUpdate($DBH, $clientID, $clientNameID, $tempID, $branch['branchID'], $contact, $form['status'], $form['details'], $further, $form['callID']);

		$advert->update($DBH, $form['jobType'], $form['position'], $form['advertLocation'], $form['disqual'],
							$form['disqualDetails'], $form['tacho'], $form['other'], $form['employed'],
							$form['currentPos'], $form['previousPos1'], $form['previousPos2'],
							$form['currentCompany'], $form['previousCompany1'], $form['previousCompany2'],
							$form['agency1'], $form['agency2'], $form['agency3'],
							$form['agencyName1'], $form['agencyName2'], $form['agencyName3'],
							$form['supervisorName1'], $form['supervisorName2'], $form['supervisorName3'],
							$form['transport'], $form['preferHours'], $form['travel'], $form['salary'], $form['age'],
							$form['twelveMonths'], $form['media'], $form['licence'], $form['callID']);
		$common->clearReturn($form['page']);
	}
	else {
		//Call does not exist and needs inserting
		$further = $common->further($DBH, $form['further'], $currentTime, $currentDate, $_SESSION['login']['staffID']);
		$callID = $common->callInsert($DBH, $clientID, $clientNameID, $tempID, $branch['branchID'], $contact, $_SESSION['login']['staffID'], $form['type'], $form['status'], $form['details'], $further, $currentTime, $currentDate);

		$advert->insert($DBH, $callID, $form['jobType'], $form['position'], $form['advertLocation'],
								$form['disqual'], $form['disqualDetails'], $form['other'], $form['tacho'], $form['employed'],
								$form['currentPos'], $form['previousPos1'], $form['previousPos2'],
								$form['currentCompany'], $form['previousCompany1'], $form['previousCompany2'],
								$form['agency1'], $form['agency2'], $form['agency3'],
								$form['agencyName1'], $form['agencyName2'], $form['agencyName3'],
								$form['supervisorName1'], $form['supervisorName2'], $form['supervisorName3'],
								$form['transport'], $form['preferHours'], $form['travel'], $form['salary'], $form['age'],
								$form['twelveMonths'], $form['media'], $form['licence']);
		$common->clearReturn($form['page']);
	}
}