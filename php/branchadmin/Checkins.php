<?php
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';
//require_once $root.'/kint/Kint.class.php';

if(isset($_POST['type'])) {
	require_once $root.'/assets/php/class/Checkins.class.php';
	$checkin = new Checkins();

	$checkin->delete($DBH, $_POST['id']);
	

	$success = 'success';
	echo json_encode($success);
}
elseif (isset($_POST['select'])) {
	$callID = $_POST['select'];

	require_once $root.'/assets/php/class/Branches.class.php';
	require_once $root.'/assets/php/class/SlideOut.class.php';

	$branch = new Branches();
	$recall = new SlideOut();

	unset($_SESSION['form']);

	// find out call type from ID
	$callType = $recall->callType($DBH, $callID);


	$_SESSION['form'] = $recall->checkin($DBH, $callID);
	$_SESSION['form']['duty'] = $branch->duty($DBH, $_SESSION['form']['branchID']);

	//Join the date and time needed and store
	$date = date('Y-m-d', strtotime($_SESSION['form']['dateToCall']));
	$time = date('H:i', strtotime($_SESSION['form']['timeToCall']));
	$datetime = date('d-m-Y H:i', strtotime("$date $time"));

	$_SESSION['form']['datetime'] = $datetime;

	$page = '/pages/BranchAdmin/ClientCheckins.php';
	
	echo json_encode($page);
}
elseif(isset($_POST['nightSubmit'])) {  //Nightline side of call
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

	/* ********************************************************************************  Deal with Nightline side of call  ************************************************************ */
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
elseif(isset($_POST['nightAdd'])) {  //Nightline side of call
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

/* ********************************************************************************  Deal with branch submit  ************************************************************ */
elseif (isset($_POST['branchAdd'])) {
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

	$type = "checkinsBlank";

	if(($form['callID'] != "") && ($result == $form['callID']) && ($form['type'] != "checkin")) { //Update from submission	
        if ($form['further'] == "") {
			$further = $common->further($DBH, $form['further'], $currentTime, $currentDate, $_SESSION['login']['staffID']);
		}
		else {
			$further = $common->furtherExtra($DBH, $form['callID'], $form['further'], $currentTime, $currentDate, $_SESSION['login']['staffID']);
		}
        
        $checkID = "0";
		updateExtras($DBH, $form['branchNameShort'], $clientID, $clientNameID, $tempID, $checkID, $form['status'], $form['details'], $further, $form['ID']);
	}
	else {
		$status = "Outstanding";
		$tempID = NULL;
		$type = "checkinsBlank";
		$active = "Inactive";
		$further = "";

       	$checkID = "0"; 
       	$form['dateToCall'] = NULL;
		inputExtras($DBH,  $clientID, $clientNameID, $tempID, $form['branchNameShort'], $_SESSION['login']['staffID'], $checkID, $type, $status, $form['details'], $further, $form['timeToCall'], $form['dateToCall'], $active, $currentTime, $currentDate);
	}
}
elseif (isset($form['branchUpdate'])) {
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


	//Deal with process
	if ($form['active'] == "Active") {
		//Loop through date range to insert checkins.
		$begin = new DateTime($form['dateToStart']);
	    $end = new DateTime($form['dateToFinish']);
	    $end = $end->modify('+1 day');
	    $diff = $begin->diff($end);

	    $diff = $diff->days;

	    if ($diff > 7) { //Check if the user is inserting more than a weeks worth of checkins
		    echo '<script>
						 alert("The checkins you are inserting span a period greater then 7 days"); 
						 window.history.go(-1);
				 </script>';
		}
		else {
		    $interval = DateInterval::createFromDateString('1 day');
		    $period = new DatePeriod($begin, $interval, $end);

			$further = "";
			$type = "checkin_outstanding";
			$status = "Outstanding";
			$checkID = "0"; 

			$form['dateToCall'] = NULL;
			updateExtras($DBH, $form['branchNameShort'], $clientID, $clientNameID, $tempID, $checkID, $type, $status, $form['details'], $further, $form['timeToCall'], $form['dateToCall'], $form['active'], $form['ID']);

			$status = "Outstanding";
			$type = "checkin";
			$checkID = $form['ID'];

		    foreach ( $period as $dt ) {
		    	$newDate = $dt->format( "Y-m-d" );
				inputExtras($DBH, $clientID, $clientNameID, $tempID, $form['branchNameShort'], $_SESSION['login']['staffID'], $checkID, $type, $status, $form['details'], $further, $form['timeToCall'], $newDate, $form['active'], $currentTime, $currentDate);
			}
			echo "Here";
		}
	}
	else {
		$tempID = NULL;
		$further = "";
		$status = "Outstanding";

		$result = callCheck($DBH, $timeInputted, $dateInputted);
	
		$branchID = findBranch($DBH, $form['branchNameShort']);
		
		$checkID = "0"; 
		updateExtras($DBH, $form['branchNameShort'], $clientID, $clientNameID, $tempID, $checkID, $form['type'], $status, $form['details'], $further, $form['timeToCall'], $form['dateToCall'], $form['active'], $form['ID']);	
	}
}
else {
	echo "oops";
}