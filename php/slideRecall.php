<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';
require_once $root.'/assets/php/class/Branches.class.php';
require_once $root.'/assets/php/class/SlideOut.class.php';

$branch = new Branches();
$recall = new SlideOut();

unset($_SESSION['form']);

// Process:
// Collect callID
$callID = $_GET['select'];

// find out call type from ID
$callType = $recall->callType($DBH, $callID);

/***************************************************************** Bookings *****************************************************************/
if ($callType['type'] == "bookings") {
	$_SESSION['form'] = $recall->bookings($DBH, $callID);
	$_SESSION['form']['duty'] = $branch->duty($DBH, $_SESSION['form']['branchID']);
	$_SESSION['form']['procedure'] = $branch->procedure($DBH, $_SESSION['form']['branchNameShort'], $callType['type']);

	//Join the date and time needed and store
	$date = date('Y-m-d', strtotime($_SESSION['form']['dateNeeded']));
	$time = date('H:i', strtotime($_SESSION['form']['timeNeeded']));
	$datetime = date('d-m-Y H:i', strtotime("$date $time"));

	$_SESSION['form']['datetime'] = $datetime;

	$page = '/pages/Bookings.php';
	
	echo json_encode($page);
	
	exit();
}

/***************************************************************** Cancellations *****************************************************************/
elseif ($callType['type'] == "cancellations") {
	$_SESSION['form'] = $recall->cancellations($DBH, $callID);
	$_SESSION['form']['duty'] = $branch->duty($DBH, $_SESSION['form']['branchID']);
	$_SESSION['form']['procedure'] = $branch->procedure($DBH, $_SESSION['form']['branchNameShort'], $callType['type']);

	//Join the date and time needed and store
	$date = date('Y-m-d', strtotime($_SESSION['form']['dateNeeded']));
	$time = date('H:i', strtotime($_SESSION['form']['timeNeeded']));
	$datetime = date('d-m-Y H:i', strtotime("$date $time"));

	$_SESSION['form']['datetime'] = $datetime;
	
	$page = '/pages/Cancellations.php';
	
	echo json_encode($page);
	
	exit();
}

/***************************************************************** Temp No Show *****************************************************************/
elseif ($callType['type'] == "Temp No Show") {
	$_SESSION['form'] = $recall->noShow($DBH, $callID);
	$_SESSION['form']['duty'] = $branch->duty($DBH, $_SESSION['form']['branchID']);
	$_SESSION['form']['procedure'] = $branch->procedure($DBH, $_SESSION['form']['branchNameShort'], $callType['type']);

	//Join the date and time needed and store
	$date = date('Y-m-d', strtotime($_SESSION['form']['dateNeeded']));
	$time = date('H:i', strtotime($_SESSION['form']['timeNeeded']));
	$datetime = date('d-m-Y H:i', strtotime("$date $time"));

	$_SESSION['form']['datetime'] = $datetime;

	$page = '/pages/TempNoShow.php';
	
	echo json_encode($page);

	exit();
}

/***************************************************************** Client Other Issues *****************************************************************/
elseif ($callType['type'] == "client other issues") {
	$_SESSION['form'] = $recall->clientOther($DBH, $callID);
	$_SESSION['form']['duty'] = $branch->duty($DBH, $_SESSION['form']['branchID']);
	$_SESSION['form']['procedure'] = $branch->procedure($DBH, $_SESSION['form']['branchNameShort'], $callType['type']);

	$page = '/pages/ClientOtherIssues.php';
	
	echo json_encode($page);

	exit();
}

/***************************************************************** Checkins *****************************************************************/
elseif (($callType['type'] == "checkin") OR ($callType['type'] == "Checkin") OR ($callType['type'] == "checkins_complete") OR ($callType['type'] == "checkinsBlank")) {
	$_SESSION['form'] = $recall->checkin($DBH, $callID);
	$_SESSION['form']['duty'] = $branch->duty($DBH, $_SESSION['form']['branchID']);

	//Join the date and time needed and store
	$date = date('Y-m-d', strtotime($_SESSION['form']['dateToCall']));
	$time = date('H:i', strtotime($_SESSION['form']['timeToCall']));
	$datetime = date('d-m-Y H:i', strtotime("$date $time"));

	$_SESSION['form']['datetime'] = $datetime;

	$page = '/pages/Checkins.php';
	
	echo json_encode($page);
}

/***************************************************************** Sick Absence *****************************************************************/
elseif ($callType['type'] == "sickness or absence") {
	$_SESSION['form'] = $recall->sick($DBH, $callID);
	$_SESSION['form']['duty'] = $branch->duty($DBH, $_SESSION['form']['branchID']);
	$_SESSION['form']['procedure'] = $branch->procedure($DBH, $_SESSION['form']['branchNameShort'], $callType['type']);

	//Join the date and time needed and store
	$date = date('Y-m-d', strtotime($_SESSION['form']['dateNeeded']));
	$time = date('H:i', strtotime($_SESSION['form']['timeNeeded']));
	$datetime = date('d-m-Y H:i', strtotime("$date $time"));

	$_SESSION['form']['datetime'] = $datetime;

	$page = '/pages/SicknessOrAbsence.php';
		
	echo json_encode($page);

	exit();
}

/***************************************************************** Working Times *****************************************************************/
elseif ($callType['type'] == "working times") {
	$_SESSION['form'] = $recall->working($DBH, $callID);
	$_SESSION['form']['duty'] = $branch->duty($DBH, $_SESSION['form']['branchID']);
	$_SESSION['form']['procedure'] = $branch->procedure($DBH, $_SESSION['form']['branchNameShort'], $callType['type']);

	$page = '/pages/WorkingTimes.php';
		
	echo json_encode($page);

	exit();
}

/***************************************************************** Pay Queries *****************************************************************/
elseif ($callType['type'] == "pay queries") {
	$_SESSION['form'] = $recall->pay($DBH, $callID);
	$_SESSION['form']['duty'] = $branch->duty($DBH, $_SESSION['form']['branchID']);
	$_SESSION['form']['procedure'] = $branch->procedure($DBH, $_SESSION['form']['branchNameShort'], $callType['type']);

	$page = '/pages/PayQueries.php';
		
	echo json_encode($page);

	exit();
}

/***************************************************************** Other Temp Issues *****************************************************************/
elseif ($callType['type'] == "other temp issues") {
	$_SESSION['form'] = $recall->tempOther($DBH, $callID);
	$_SESSION['form']['duty'] = $branch->duty($DBH, $_SESSION['form']['branchID']);
	$_SESSION['form']['procedure'] = $branch->procedure($DBH, $_SESSION['form']['branchNameShort'], $callType['type']);

	$page = '/pages/OtherTempIssues.php';
		
	echo json_encode($page);

	exit();
}

/***************************************************************** Advert *****************************************************************/
elseif ($callType['type'] == "advert") {
	$_SESSION['form'] = $recall->advert($DBH, $callID);
	$_SESSION['form']['duty'] = $branch->duty($DBH, $_SESSION['form']['branchID']);
	// $_SESSION['form']['procedure'] = $_SESSION['form']['advert'];

	$page = '/pages/Advert.php';
	
	echo json_encode($page);

	exit();
}

/***************************************************************** Advert *****************************************************************/
elseif ($callType['type'] == "Matalan Advert") {
	$_SESSION['form'] = $recall->matalan($DBH, $callID);
	$_SESSION['form']['duty'] = $branch->duty($DBH, $_SESSION['form']['branchID']);
	$_SESSION['form']['procedure'] = $branch->procedure($DBH, $_SESSION['form']['branchNameShort'], $callType['type']);

	$page = '/pages/Matalan.php';
	
	echo json_encode($page);

	exit();
}
elseif ($callType['type'] == "head office temp call") {
	$_SESSION['form'] = $recall->headOffice($DBH, $callID);
	$_SESSION['form']['duty'] = $branch->duty($DBH, $_SESSION['form']['branchID']);
	$_SESSION['form']['procedure'] = $branch->procedure($DBH, $_SESSION['form']['branchNameShort'], $callType['type']);

	$page = '/pages/HeadOfficeTempCall.php';
	
	echo json_encode($page);

	exit();
}
elseif ($callType['type'] == "head office client call") {
	$_SESSION['form'] = $recall->headOffice($DBH, $callID);
	$_SESSION['form']['duty'] = $branch->duty($DBH, $_SESSION['form']['branchID']);
	$_SESSION['form']['procedure'] = $branch->procedure($DBH, $_SESSION['form']['branchNameShort'], $callType['type']);

	$page = '/pages/HeadOfficeClientCall.php';
	
	echo json_encode($page);

	exit();
}