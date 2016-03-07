<?php
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';
require_once $root.'/assets/php/class/UserCreation.class.php';
require_once $root.'/assets/php/class/Branches.class.php';

$user = new User();
$branch = new Branches();

$form = $_POST;


if(isset($form['find'])) {
	$userDetails = $user->find($DBH, $form['staffNameFirst'], $form['staffNameLast'], $form['branchNameShort']);
	if ($userDetails != NULL) {
		// Store all details into session
		$_SESSION['form']['user'] = $userDetails;
		$_SESSION['form']['branchNameShort'] = $form['branchNameShort'];
		header('location: '.$form['page']);
	}
	else {
		echo "<script>
				 alert('User could not be found, please check the details and try again'); 
				 window.history.go(-1);
		 </script>";
	}
}
elseif(isset($form['update'])) {
	if ($form['staffID'] != "") {

		$branchID = $branch->branchDetails($DBH, $form['branchNameShort']);

		if ($form['password'] != "") {
			if ($form['finishDate'] == "") {
				$finishDate = "0000-00-00";
			}
			else{
				$finishDate = $form['finishDate'];
			}
			$user->updateUserWithPassword($DBH, $form['username'], $form['password'], $form['staffNameFirst'], $form['staffNameLast'], $form['access'], $form['DoB'], $form['password'], $form['address'], $form['payrollNumber'], $form['startDate'], $form['finishDate'], $branchID['branchID'], $form['payRate'], $form['fulltime'], $form['staffID']);
			if(isset($form['holidays']) && ($form['holidays'] != '')){
				$user->holiday($DBH, $form['staffID'], $form['holidays']);
			}
			
			unset($_SESSION['form']);
			header('location: '.$form['page']);
		}
		else {
			if ($form['finishDate'] == "") {
				$finishDate = "0000-00-00";
			}
			else{
				$finishDate = $form['finishDate'];
			}
			$user->updateUserWithoutPassword($DBH, $form['username'], $form['staffNameFirst'], $form['staffNameLast'], $form['access'], $form['DoB'], $form['address'], $form['payrollNumber'], $form['startDate'], $finishDate, $branchID['branchID'], $form['payRate'], $form['fulltime'], $form['staffID']);
			
			if(isset($form['holidays']) && ($form['holidays'] != '')){
				$user->holiday($DBH, $form['staffID'], $form['holidays']);
			}
			
			unset($_SESSION['form']);
			header('location: '.$form['page']);
		}
	}
	else {
		echo "<script>
				 alert('User does not exist within the database, please please use the insert function'); 
				 window.history.go(-1);
		 </script>";
	}
}
elseif(isset($form['insert'])) {
	$userDetails = $user->find($DBH, $form['staffNameFirst'], $form['staffNameLast'], $form['branchNameShort']);	
		if ($userDetails != NULL) {
			$_SESSION['form']['user'] = $userDetails;
			$_SESSION['form']['branchNameShort'] = $form['branchNameShort'];
			echo "<script>
					 alert('User already exists within the database, please update existing details'); 
					 window.history.go(-1);
			 </script>";
		}
		else {
			$branchID = $branch->branchDetails($DBH, $form['branchNameShort']);
			$staffID = $user->insertUser($DBH, $form['username'], $form['password'], $form['staffNameFirst'], $form['staffNameLast'], $form['DoB'], $form['access'], $form['password'], $form['address'], $form['payrollNumber'], $form['startDate'], $branchID['branchID'], $form['payRate'], $form['fulltime']);
			if(isset($form['holidays']) && ($form['holidays'] != '')){
				$user->holiday($DBH, $staffID, $form['holidays']);	
			}
			
			unset($_SESSION['form']);
			header('location: '.$form['page']);
		}
}