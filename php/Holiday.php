<?php
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';


$form = $_POST;

if(isset($_POST['recallID'])) {
	// Recall all call details
	require_once $root.'/assets/php/class/Recall.class.php';
	$recall = new Recall();
	$_SESSION['form'] = $recall->holidayRecall($DBH, $_POST['recallID']);

	$success = 'success';
	echo json_encode($success);
}
elseif(isset($_POST['submit'])) {
	require_once $root.'/assets/php/class/Holiday.class.php';
	require_once $root.'/assets/php/class/Common.class.php';
	$common = new Common();
	$holiday = new Holiday();
	
	$currentDate = date('Y-m-d');
	$currentTime = date('H:i:s');
	
	//Check if holiday finish is before holiday start
	if(date('Y-m-d', strtotime($form['holStart'])) < date('Y-m-d', strtotime($form['holFinish']))) {
		if(empty($form['holidayID'])) {
			$holiday->insert($DBH, $_SESSION['login']['staffID'], date('Y-m-d', strtotime($form['holStart'])), date('Y-m-d', strtotime($form['holFinish'])), $form['additional'], $form['sanctioned'], $currentDate, $currentTime);
			$common->clearReturn($form['page']);
		}
		else {
			$holiday->update($DBH, date('Y-m-d', strtotime($form['holStart'])), date('Y-m-d', strtotime($form['holFinish'])), $form['additional'], $form['sanctioned'], $form['holidayID']);
			$common->clearReturn($form['page']);
		}
	}
	elseif(date('Y-m-d', strtotime($form['holStart'])) == date('Y-m-d', strtotime($form['holFinish']))) {
		if(empty($form['holidayID'])) {
			$holiday->insert($DBH, $_SESSION['login']['staffID'], date('Y-m-d', strtotime($form['holStart'])), date('Y-m-d', strtotime($form['holFinish'])), $form['additional'], $form['sanctioned'], $currentDate, $currentTime);
			$common->clearReturn($form['page']);
		}
		else {
			$holiday->update($DBH, date('Y-m-d', strtotime($form['holStart'])), date('Y-m-d', strtotime($form['holFinish'])), $form['additional'], $form['sanctioned'], $form['holidayID']);
			$common->clearReturn($form['page']);
		}
	}
	else {
		echo "<script>
				 alert('Your holiday can not finish before it has started, please check your dates.'); 
				 window.history.go(-1);
		 </script>";
	}
}
elseif(isset($_POST['select'])) {
	// Recall all call details
	require_once $root.'/assets/php/class/Recall.class.php';
	$recall = new Recall();
	$_SESSION['form'] = $recall->holidayRecall($DBH, $form['select']);

	$page = '/pages/Holiday.php';
	echo json_encode($page);
}