<?php
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

$_SESSION['form'] = $form = $_POST;

if(isset($_POST['recallID'])) {
	// Recall all call details
	require_once $root.'/assets/php/class/Recall.class.php';
	$recall = new Recall();
	
	$_SESSION['form'] = $recall->cvRecall($DBH, $_POST['recallID']);

	$success = 'success';
	echo json_encode($success);
}
elseif(isset($_POST['select'])) {
	// Recall all call details
	require_once $root.'/assets/php/class/Recall.class.php';
	$recall = new Recall();
	$id = substr($_POST['select'], 2);
	$_SESSION['form'] = $recall->cvRecall($DBH, $id);

	$page = '/pages/BranchAdmin/Cvsearch.php';
	echo json_encode($page);
}
elseif(isset($_POST['submit'])) {
	require_once $root.'/assets/php/class/Cvsearch.class.php';
	require_once $root.'/assets/php/class/Common.class.php';
	require_once $root.'/assets/php/class/Branches.class.php';
	$cvsearch = new CVSearch();
	$common = new Common();
	$branches = new Branches();

	$form = $_POST;

	$currentDate = date('Y-m-d');
	$currentTime = date('H:i:s');


	$tempID = NULL;  //Set as this as its a booking and does not contain temp user data
	$contact = NULL;  //Does not have a head office contact

	$branch = $branches->branchDetails($DBH, $form['branchNameShort']);

	$clientID = NULL;
	$clientNameID = $common->clientNameCompare($DBH, $form['clientNameID'], $form['clientName'], $form['postcode']);

	/* ********************************************************************************  Deal with Call  ************************************************************ */
	//Check if there is a callID posted
	if(isset($form['callID']) && ($form['callID'] != '')) {  //Call Exists and needs updating
		$details = '';
		$further = '';
		$common->callUpdate($DBH, $clientID, $form['clientNameID'], $tempID, $branch['branchID'], $contact, $form['status'], $details, $further, $form['callID']);
		
		$cvsearch->cvSearchUpdate($DBH, $form['position'], $form['jobdesc'], $form['other'], $form['callID']);

		//Assign staff
		if(isset($form['staff']) && ($form['staff'] !='')) {
			$cvsearch->cvStaffAssign($DBH, $form['staff'], $form['callID']);
		}

		if($form['status'] != 'Outstanding') {
			$cvsearch->cvCallStatus($DBH, $form['status'], $form['callID']);
		}


		$common->clearReturn($form['page']);
	}
	else {  //Call does not exist and needs inserting
		/* ********************************************************************************  Deal with client details  ************************************************************ */
		$status = "Outstanding";
		$details = '';

		$further = " -- ".$_SESSION['login']['staffID']." - ".$currentTime." ".$currentDate." -- ";
		$further = $common->further($DBH, $further, $currentTime, $currentDate, $_SESSION['login']['staffID']);
		$callID = $common->callInsert($DBH, $clientID, $clientNameID, $tempID, $branch['branchID'], $contact, $_SESSION['login']['staffID'], $form['type'], $status, $details, $further, $currentTime, $currentDate);
		
		$cvID = $cvsearch->cvSearchInsert($DBH, $callID, $form['position'], $form['jobdesc'], $form['other']);
		
		//Email to inform branch
		require_once $root.'/assets/php/class/Email.class.php';
		$email = new Email();

		$_SESSION['form']['type'] = 'cvsearch';
		if (isset($cvID) && $cvID != "") {
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
}