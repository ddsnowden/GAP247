<?php
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

require_once $root.'/assets/php/class/Procedures.class.php';
require_once $root.'/assets/php/class/Branches.class.php';
require_once $root.'/assets/php/class/Common.class.php';
require_once $root.'/assets/php/class/Staff.class.php';
$proc = new Procedures();
$branch = new Branches();
$common = new Common();
$staff = new Staff();
$form = $_POST;

if (isset($form['branch']) && $form['branch'] != "") {
	$branchName = $form['branch'];
}
else {
	$branchName = $branch->branchDetailsID($DBH, $_SESSION['login']['branchID']);
	$branchName = $branchName['branchNameShort'];
}
$proc->update($DBH, $form['advert'], $form['bookings'], $form['cancellations'], $form['checkins'], $form['sick'], $form['tempnoshow'], $form['working'], $form['otherclient'], $form['pay'], $form['othertemp'], $branchName);
//$common->clearReturn($form['page']);
require $root.'/assets/PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;
$password = $staff->details($DBH,'4');
//$mail->SMTPDebug = 3;                               		// Enable verbose debug output

$mail->isSMTP();                                      		// Set mailer to use SMTP
$mail->Host = '81.171.135.240';  		  					// Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               		// Enable SMTP authentication
$mail->Username = 'dean.langford@gap-personnel.com';                 // SMTP username
$mail->Password = $password[0]['emailPassword'];                          	// SMTP password
$mail->Port = 62225;                                    	// TCP port to connect to

$mail->From = 'dean.langford@gap-personnel.com';
$mail->addAddress('dean.langford@gap-personnel.com');     // Add a recipient


$mail->Subject = 'A branch has altered their procedures';

$mail->Body = $_SESSION['login']['staffNameFirst'].' '.$_SESSION['login']['staffNameLast'].' from '.$branchName.' has updated the procedures for their branch.';

if(!$mail->send()) {
	$error = $mail->ErrorInfo;
} else {
	unset($_SESSION['form']);
	header('location: /pages/BranchAdmin/Procedures.php');
}

?>