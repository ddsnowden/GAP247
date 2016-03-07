<?php
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';
require_once $root.'/assets/php/class/Timesheet.class.php';
// require_once $root.'/kint/Kint.class.php';
$form = $_POST;

if(isset($_POST['recallID'])) {
	require_once $root.'/assets/php/class/Recall.class.php';
	$recall = new Recall();
	$time = new Timesheet();

	//Get staff pay rate and store
	$payRate = $time->payRate($DBH, $_SESSION['login']['staffID']);
	$_SESSION['login']['payRate'] = $payRate['payRate'];

	//Recall timesheet
	$_SESSION['form'] = $recall->timeRecall($DBH, $form['recallID']);

	//Create start and finish array for each day
	$days = array(
		array('day' => 'monPay', 'start' => $_SESSION['form']['monStart'], 'finish' => $_SESSION['form']['monFinish']),
		array('day' => 'tuePay', 'start' => $_SESSION['form']['tueStart'], 'finish' => $_SESSION['form']['tueFinish']),
		array('day' => 'wedPay', 'start' => $_SESSION['form']['wedStart'], 'finish' => $_SESSION['form']['wedFinish']),
		array('day' => 'thuPay', 'start' => $_SESSION['form']['thuStart'], 'finish' => $_SESSION['form']['thuFinish']),
		array('day' => 'friPay', 'start' => $_SESSION['form']['friStart'], 'finish' => $_SESSION['form']['friFinish']),
		array('day' => 'satPay', 'start' => $_SESSION['form']['satStart'], 'finish' => $_SESSION['form']['satFinish']),
		array('day' => 'sunPay', 'start' => $_SESSION['form']['sunStart'], 'finish' => $_SESSION['form']['sunFinish'])
	);


	$t = 1;
	$pay = array();
	$_SESSION['form']['totalPay'] = '';
	$totalHours = '';

	foreach ($days as $key => $value) {
		$result = $time->pay($DBH, $value['start'], $value['finish'], $payRate['payRate']); //Pay for the hours worked
		$hours = $time->timeDiff($DBH, $value['start'], $value['finish']);  //Hours worked for that day
		$totalHours += $hours;  //Collect the total number of hours worked in a week
		$_SESSION['form']['totalHours'][$t] = round($hours,2);  //Set session variable for each day and store hours worked
		$_SESSION['form']['hols'][$t] = round(($hours * 0.1207),2);  //Set session variable for each day and store holidays acquired
		
		$_SESSION['form'][$value['day']] = $result;  //Store the pay into variables for each day
		$_SESSION['form']['totalPay'] += $result;  //Add up and store the total pay
		$t++;
	}
	$_SESSION['form']['totalHours']['total'] = round($totalHours,2);  //Store the total hours for the week
	$_SESSION['form']['totalHols'] = round(($totalHours * 0.1207),2); //Store the total holidays acquired for the week

	echo json_encode('success');
}
elseif(isset($_POST['submit'])) {
	require_once $root.'/assets/php/db.php';
	require_once $root.'/assets/php/class/Common.class.php';
	$time = new Timesheet();
	$common = new Common();

	$diff = array(
		array('start' => $form['monStart'], 'finish' => $form['monFinish']),
		array('start' => $form['tueStart'], 'finish' => $form['tueFinish']),
		array('start' => $form['wedStart'], 'finish' => $form['wedFinish']),
		array('start' => $form['thuStart'], 'finish' => $form['thuFinish']),
		array('start' => $form['friStart'], 'finish' => $form['friFinish']),
		array('start' => $form['satStart'], 'finish' => $form['satFinish']),
		array('start' => $form['sunStart'], 'finish' => $form['sunFinish'])
	);

	$commence = new DateTime($form['commence']);
	$commence = date_format($commence, 'Y-m-d');

	$e = 1;
	foreach ($diff as $key) {
		$diff = $time->diff($key['start'], $key['finish']);  //Call difference function

		$days = (float)$diff->format('%r%Y%m%d');  //Check if difference in days
		$hours = (float)$diff->format('%r%H');  //Check if difference in hours

		if(($days >= 1) || ($days < 0) || ($hours > 14) || ($hours < 0)) {
			$_SESSION['form']['error'.$e] = 'error';
			$error[] = 1;
		}
		else {
			$_SESSION['form']['error'.$e] = 'noerror';
			$error[] = 0;
		}
		$e++;
	}

	if(in_array('1', $error)) {
		echo "<script>
				alert('You have enter a finish time that is before its start time or exceeds the 14 hour shift limit, please check and change.'); 
				window.history.go(-1);
		</script>";
		exit();
	}

	$result = $time->checkSheets($DBH, $_SESSION['login']['staffID'], $commence);

	if(!empty($result)) {
		if(empty($form['timeID'])) {
			echo "<script>
					alert('You have a timesheets submitted for this week, please recall the timesheet and update as needed.'); 
					window.history.go(-1);
			</script>";
			exit();
		}
		else {
			$time->update($DBH, $_SESSION['login']['staffID'], $commence, $form['monStart'], $form['monFinish'], $form['tueStart'], $form['tueFinish'], $form['wedStart'], $form['wedFinish'], $form['thuStart'], $form['thuFinish'], $form['friStart'], $form['friFinish'], $form['satStart'], $form['satFinish'], $form['sunStart'], $form['sunFinish'], $form['timeID']);
		}
	}
	else {
		$time->insert($DBH, $_SESSION['login']['staffID'], $commence, $form['monStart'], $form['monFinish'], $form['tueStart'], $form['tueFinish'], $form['wedStart'], $form['wedFinish'], $form['thuStart'], $form['thuFinish'], $form['friStart'], $form['friFinish'], $form['satStart'], $form['satFinish'], $form['sunStart'], $form['sunFinish']);
	}

	$common->clearReturn($form['page']);
}