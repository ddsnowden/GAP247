<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';;
$to = 'charlotte.owens@gap-personnel.com';
$cc = '';
$subject = 'This weeks payroll for GAP27/7';
include 'payroll.php';
$body = $body;

// session_start();

function password($DBH, $staffNameFirst, $staffNameLast) {
	$callSearch = $DBH->prepare('SELECT emailPassword FROM staff WHERE (staffNameFirst, staffNameLast) = (?, ?)');
	$callSearch->execute(array($_SESSION['login']['staffNameFirst'], $_SESSION['login']['staffNameLast']));
	$CSResult = $callSearch->fetch(PDO::FETCH_ASSOC);
	return $CSResult['emailPassword'];
}

function insertEmail($DBH, $to, $cc, $subject, $body) {
	$insert = 'INSERT INTO staffEmail ($to, $cc, $subject, $body, $staffID, $dateTime)
					VALUES (:to, :cc, :subject, :body, :staffID, :dateTime)';
	$in = $DBH->prepare($insert);
	$in->bindParam(':to', $to);
	$in->bindParam(':cc', $cc);
	$in->bindParam(':subject', $subject);
	$in->bindParam(':body', $body);
	$in->bindParam(':staffID', $staffID);
	$in->bindParam(':dateTime', $dateTime);

	$in->execute();
}

$password = password($DBH, $_SESSION['login']['staffNameFirst'], $_SESSION['login']['staffNameLast']);

$header = "Content-Type: text/html; charset=\"iso-8859-1\"\n";

require $root.'/assets/PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               		// Enable verbose debug output

$mail->isSMTP();                                      		// Set mailer to use SMTP
$mail->Host = '81.171.135.240';  		  					// Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               		// Enable SMTP authentication
$mail->Username = $_SESSION['login']['staffNameFirst'].'.'.$_SESSION['login']['staffNameLast'].'@gap-personnel.com';                 // SMTP username
$mail->Password = $password;                          	// SMTP password
//$mail->SMTPSecure = 'tls';                            	// Enable TLS encryption, `ssl` also accepted
$mail->Port = 62225;                                    	// TCP port to connect to

$mail->From = $_SESSION['login']['staffNameFirst'].'.'.$_SESSION['login']['staffNameLast'].'@gap-personnel.com';
$mail->FromName = $_SESSION['login']['staffNameFirst'].' '.$_SESSION['login']['staffNameLast'];

$mail->Subject = $subject;
$mail->addAddress($to);     // Add a recipient

$mail->addCC($cc);

$mail->addBCC('dean.langford@gap-personnel.com');
$mail->AddEmbeddedImage($root.'/assets/img/247-logo-email.jpg', '247-logo-email.jpg');
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Body = $body;

if(!$mail->send()) {
	$error = $mail->ErrorInfo;
	echo "<script>
				alert('Mailer Error: ".$error."');
				window.history.go(-1);
		 </script>";
} else {
	$referer = $_SERVER['HTTP_REFERER'];
	$dateTime = date('Y-m-d H:i:s');
	$staffID = $_SESSION['login']['staffID'];
	//insertEmail($DBH, $to, $cc, $subject, $body, staffID, $dateTime);
	echo '<script>
				 alert("Message has been sent"); 
				 window.location.href = "'.$referer.'";
		 </script>';
}