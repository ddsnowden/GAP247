<?php
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

require_once $root.'/assets/php/class/Email.class.php';
require_once $root.'/assets/php/class/Branches.class.php';
$email = new Email();
$branches = new Branches();

if(isset($_SESSION['form']['branchNameShort']) && $_SESSION['form']['branchNameShort'] != '') {
	$branch = $branches->branchDetails($DBH, $_SESSION['form']['branchNameShort']);
}
else {
	$branch = $branches->branchDetailsID($DBH, $_SESSION['login']['branchID']);
}

$type = ucwords($_SESSION['form']['type']);

if ($type == "Bookings") {
	include $root.'/assets/php/emails/bookings.php';
}
elseif ($type == "Cancellations") {
	include $root.'/assets/php/emails/cancellations.php';
	$to = 'branch';
}
elseif ($type == "Temp No Show") {
	include $root.'/assets/php/emails/noshow.php';
	$to = 'branch';
}
elseif ($type == "Client Other Issues") {
	include $root.'/assets/php/emails/clientOther.php';
	$to = 'branch';
}
elseif ($type == "Checkins_complete") {
	include $root.'/assets/php/emails/checkin.php';
	$to = 'branch';
}
elseif ($type == "Sickness Or Absence") {
	include $root.'/assets/php/emails/sick.php';
	$to = 'branch';
}
elseif ($type == "Working Times") {
	include $root.'/assets/php/emails/workingTimes.php';
	$to = 'branch';
}
elseif ($type == "Pay Queries") {
	include $root.'/assets/php/emails/payQuery.php';
	$to = 'branch';
}
elseif ($type == "Other Temp Issues") {
	include $root.'/assets/php/emails/tempOther.php';
	$to = 'branch';
}
elseif ($type == "Advert") {
	include $root.'/assets/php/emails/advert.php';
	$to = 'branch';
}
elseif ($type == "Matalan Advert") {
	include $root.'/assets/php/emails/matalan.php';
	$to = 'branch';
}
elseif ($type == "Head Office Client Call") {
	include $root.'/assets/php/emails/headoffice.php';
	$to = 'head_office';
}
elseif ($type == "Head Office Temp Call") {
	include $root.'/assets/php/emails/headofficetemp.php';
	$to = 'head_office';
}
elseif ($type == 'cvsearch') {
	include $root.'/assets/php/emails/cvsearch.php';
	$to = 'branch';
}

if(isset($_SESSION['form']['type']) && $_SESSION['form']['type'] == 'feedback') {
	$page = $_SESSION['form']['page'];
	if(isset($_SESSION['form']['operator']) && ($_SESSION['form']['operator'] != '')){
		$staff = '';
		$staff = $email->staffDetails($DBH, $_SESSION['form']['operator']);
	}

	include $root.'/assets/php/emails/feedback.php';

	

	$to = 'feedback';
	$branch = array("branchName" => $branch['branchName'], "branchNameShort" => $branch['branchNameShort']);
	$from = $_SESSION['login']['staffNameFirst'].'.'.$_SESSION['login']['staffNameLast'].'@gap-personnel.com';
	$bcc = 'nightline';

	$subject = $_SESSION['login']['staffNameFirst'].'.'.$_SESSION['login']['staffNameLast'].' has sent feedback.';
	$result = $email->sendEmail($DBH, $_SESSION['login']['staffID'], $to, $branch, $from, $bcc, $body, $type, $subject);

	if($result == 'success') {
		$email->updateEmail($DBH, $_SESSION['form']['callID']);
		unset($_SESSION['form']);
		$referer = $_SERVER['HTTP_REFERER'];
		echo '<script>
			alert("Your feedback has been submitted successfully and an acknowledgement email has been sent to you."); 
			window.location.href = "'.$page.'";
		</script>';
	}
	else {
		echo '<script>
			alert("Unfortunately there seems to have been an issue submitting your feedback, please try again.  Should you continue to have problems please contact Dean Langford directly at dean.langford@gap-personnel.com"); 
			window.location.href = "'.$page.'";
		</script>';
	}
}
elseif(isset($_SESSION['form']['type']) && $_SESSION['form']['type'] == 'cvsearch') { 
	include $root.'/assets/php/emails/cvsearch.php';
	$page = $_SESSION['form']['page'];

	$to = 'branch';
	$branch = array("branchName" => $branch['branchName'], "branchNameShort" => $branch['branchNameShort']);
	$from = 'dean.langford@gap-personnel.com';
	$bcc = 'nightline';
	$staffID = 4;

	$subject = $_SESSION['login']['staffNameFirst'].'.'.$_SESSION['login']['staffNameLast'].' has sent through a CV Search request.';
	$result = $email->sendEmail($DBH, $staffID, $to, $branch, $from, $bcc, $body, $type, $subject);

	if($result == 'success') {
		$email->updateEmail($DBH, $_SESSION['form']['callID']);
		unset($_SESSION['form']);
		echo '<script>
			alert("Your CV search has been submitted successfully and an acknowledgement email has been sent to you."); 
			window.location.href = "'.$page.'";
		</script>';
	}
	else {
		echo '<script>
			alert("Unfortunately there seems to have been an issue submitting your CV search, please try again.  Should you continue to have problems please contact Dean Langford directly at dean.langford@gap-personnel.com"); 
			window.location.href = "'.$page.'";
		</script>';
	}
}
elseif(isset($_SESSION['form']['type']) && (($_SESSION['form']['type'] == 'head office client call') || ($_SESSION['form']['type'] == 'head office temp call'))) { 
	// include $root.'/assets/php/emails/cvsearch.php';
	$page = $referer = $_SERVER['HTTP_REFERER'];

	$to = 'head_office';
	$branch = array("branchName" => $branch['branchName'], "branchNameShort" => $branch['branchNameShort']);
	$from = $_SESSION['login']['staffNameFirst'].'.'.$_SESSION['login']['staffNameLast'].'@gap-personnel.com';
	$bcc = 'nightline';

	$subject = 'Logged call from GAP24/7 for '.$branch['branchName'].' - '.ucwords($_SESSION['form']['type']);
	$result = $email->sendEmail($DBH, $_SESSION['login']['staffID'], $to, $branch, $from, $bcc, $body, $type, $subject);

	if($result == 'success') {
		$email->updateEmail($DBH, $_SESSION['form']['callID']);
		unset($_SESSION['form']);
		echo '<script>
			alert("Message has been sent");
			window.location.href = "'.$page.'";
		</script>';
	}
	else {
		echo '<script>
			alert("Unfortunately there seems to have been an issue submitting your CV search, please try again.  Should you continue to have problems please contact Dean Langford directly at dean.langford@gap-personnel.com"); 
			window.location.href = "'.$page.'";
		</script>';
	}
}
else {
	$to = 'branch';
	$branch = array("branchName" => $branch['branchName'], "branchNameShort" => $branch['branchNameShort']);
	$from = $_SESSION['login']['staffNameFirst'].'.'.$_SESSION['login']['staffNameLast'].'@gap-personnel.com';
	$bcc = 'nightline';

	$subject = 'Logged call from GAP24/7 for '.$branch['branchName'].' - '.ucwords($_SESSION['form']['type']);
	$result = $email->sendEmail($DBH, $_SESSION['login']['staffID'], $to, $branch, $from, $bcc, $body, $type, $subject);

	if($result == 'success') {
		$referer = $_SERVER['HTTP_REFERER'];
		$email->updateEmail($DBH, $_SESSION['form']['callID']);
		unset($_SESSION['form']);
		echo '<script>alert("Message has been sent"); window.location.href = "'.$referer.'";</script>';
	}
	else {
		echo "<script>
			alert('Unfortunately there seems to have been an issue submitting your feedback, please try again.  Should you continue to have problems please contact Dean Langford directly at dean.langford@gap-personnel.com'); 
			window.history.go(-1);
		</script>";
	}
}




