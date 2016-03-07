<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class Email
{
	function password($DBH, $firstName, $lastName) {
		$admin = $DBH->prepare('SELECT emailPassword FROM staff WHERE staffNameFirst = ? AND staffNameLast = ?');
		$admin->execute(array($firstName, $lastName));
		$password = $admin->fetch(PDO::FETCH_ASSOC);
		return $password;
	}

	function sendEmail($DBH, $staffID, $to, $branch, $from, $bcc, $body, $type, $subject) {
		$root = realpath($_SERVER["DOCUMENT_ROOT"]);

		$details = $this->staffDetails($DBH, $staffID);

		require $root.'/assets/PHPMailer/PHPMailerAutoload.php';

		$mail = new PHPMailer;

		//$mail->SMTPDebug = 3;                               		// Enable verbose debug output

		$mail->isSMTP();                                      		// Set mailer to use SMTP
		$mail->Host = '81.171.135.240';  		  					// Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               		// Enable SMTP authentication
		$mail->Username = $details['staffNameFirst'].'.'.$details['staffNameLast'].'@gap-personnel.com';                 // SMTP username
		$mail->Password = $details['emailPassword'];                          	// SMTP password
		//$mail->SMTPSecure = 'tls';                            	// Enable TLS encryption, `ssl` also accepted
		$mail->Port = 62225;                                    	// TCP port to connect to

		$mail->From = $details['staffNameFirst'].'.'.$details['staffNameLast'].'@gap-personnel.com';
		$mail->FromName = $details['staffNameFirst'].' '.$details['staffNameLast'];
		//$mail->addAddress($details['staffNameFirst'].'.'.$details['staffNameLast'].'@gap-personnel.com', $details['staffNameFirst'].' '.$details['staffNameLast']);     // Add a recipient

		if ($to == "head_office") {
			echo "******IN HERE******";
			$contact = explode(' ', $_SESSION['form']['contact']);
			$mail->Subject = $branch['branchName'].' Out Of Hours Call';
			$mail->addAddress($contact[0].'.'.$contact[1].'@gap-personnel.com', $_SESSION['login']['staffNameFirst'].' '.$_SESSION['login']['staffNameLast']);     // Add a recipient
		}
		else {
			$mail->Subject = $branch['branchName'].' Out Of Hours Call - '.$type;
			$mail->addAddress($branch['branchNameShort'].'@gap-personnel.com', $_SESSION['login']['staffNameFirst'].' '.$_SESSION['login']['staffNameLast']);     // Add a recipient
		}

		$mail->addBCC($bcc.'@gap-personnel.com');

		$mail->addAttachment($root.'/assets/img/247-logo-email.jpg', '247-logo-email.jpg');    // Optional name
		$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = $subject;

		$mail->Body = $body;

		if(!$mail->send()) {
			$error = $mail->ErrorInfo;
		} else {
			$error = 'success';
		}
		return $error;
	}

	function updateEmail($DBH, $callID) {
		$dateTime = date('Y-m-d H:i:s');
		$emailUpdate = 'UPDATE callinfo SET 
								emailed = "Emailed",
								emailDateTime = ?
								WHERE callID = ?';
		$CU = $DBH->prepare($emailUpdate);
		$CU->execute(array($dateTime, $callID));
	}

	function staffDetails($DBH, $staffID) {
		$query = $DBH->prepare('SELECT staffNameFirst, staffNameLast, emailPassword FROM staff WHERE staffID = ?');
		$query->execute(array($staffID));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result;
	}
}