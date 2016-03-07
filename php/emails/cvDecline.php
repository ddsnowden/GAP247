<?php

function password($DBH, $staffNameFirst, $staffNameLast) {
	$callSearch = $DBH->prepare('SELECT emailPassword FROM staff WHERE (staffNameFirst, staffNameLast) = (?, ?)');
	$callSearch->execute(array("Dean", "Langford"));
	$CSResult = $callSearch->fetch(PDO::FETCH_ASSOC);
	return $CSResult['emailPassword'];
}
/*
function staffName($DBH, $operatorID) {
	$name = $DBH->prepare('SELECT staffNameFirst, staffNameLast FROM staff WHERE staffID = ?');
	$name->execute(array($operatorID));
	$nameResult = $name->fetch(PDO::FETCH_ASSOC);
	return $nameResult;
}

$staffNameFull = staffName($DBH, $_POST['staffName']);
*/
$password = password($DBH, $_SESSION['login']['staffNameFirst'], $_SESSION['login']['staffNameLast']);

require 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               		// Enable verbose debug output

$mail->isSMTP();                                      		// Set mailer to use SMTP
$mail->Host = '81.171.135.240';  		  					// Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               		// Enable SMTP authentication
$mail->Username = 'dean.langford@gap-personnel.com';        // SMTP username
$mail->Password = $password;                          		// SMTP password
//$mail->SMTPSecure = 'tls';                            	// Enable TLS encryption, `ssl` also accepted
$mail->Port = 62225;                                    	// TCP port to connect to

$mail->From = 'dean.langford@gap-personnel.com';
$mail->FromName = 'Dean Langford';
$mail->addAddress($name[0].'.'.$name[1].'@gap-personnel.com', $name[0].' '.$name[1]);     // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('damian.snowden@gap-personnel.com', 'Information');
//$mail->addCC('cc@example.com');
$mail->addBCC('dean.langford@gap-personnel.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
$mail->addAttachment('../images/247-logo-email.jpg', '247-logo-email.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
       <title>Nightline Out Of Hours</title>
        <style type="text/css">
            .header {padding: 0px 30px 20px 30px;}
            .subhead {font-size: 20px; color: #000000; font-family: sans-serif; letter-spacing: 2px;}
            .h1 {color: #153643; font-family: sans-serif; font-size: 15px; line-height: 38px; font-weight: bold;}
            .innerpadding {padding: 0px 30px 0px 30px;}
            .borderbottom {border-bottom: 0px solid #f2eeed;}
            .h2 {color: #153643; font-family: sans-serif; padding: 0 0 3px 0; font-size: 24px; line-height: 28px; font-weight: bold; border-bottom: 2px solid #000000;}
            .bodycopy {color: #153643; font-family: sans-serif; padding: 10px 0 0 0; font-size: 16px; line-height: 22px; }
                @media only screen and (min-device-width: 601px) {.content {width: 600px!important;} .col425 {width: 425px!important;} }
        body {margin: 0; padding: 0; min-width: 100%!important;}
        .content {width: 100%; max-width: 600px;}  
        input {outline: 0; border: 0 solid;}
        pre {font-family: sans-serif; font-size: 14px; overflow;}
        </style>
    </head>
    <body bgcolor="ffffff">
        <!--[if (gte mso 9)|(IE)]>
        <table width="600" align="center" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <![endif]-->                
                    <table class="content" align="center" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td class="header" bgcolor="ffffff">
                                <table width="600px" align="left" border="0" cellpadding="0" cellspacing="0" >
                                    <tr>
                                        <td width="600" height="70" style="padding: 0 0px 0px 0;">
                                            <center><img style="top: 0px;" src="247-logo-email.jpg" border="0"  alt="" /></center>
                                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td class="subhead" style="padding: 0 0 0 3px;">
                                                                
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <!--<td class="h1" style="padding: 2px 0 0 0;">
                                                            </td>-->
                                                        </tr>
                                                    </table>
												</td>
											</tr>
										</table>
										<!--[if mso]>
										</td><td>
										<![endif]-->   
									</td>
								</tr>
								<tr>
									<td class="innerpadding borderbottom">
										<table width="100%" border="0" cellspacing="0" cellpadding="1">
										<form>
											<tr>
												<td class="h2" colspan="2">
													<center>Uploaded CV Search Data</center>
												</td>
											</tr>
											<tr>
												<td colspan="2" style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px;">
                                                    <div style="margin: auto; width: 400px; text-align: center;">
													
														<br />
                                                        This is just a quick email to inform you that the CV search you requested has been declined.<br /><br />

                                                        Please could you contact Nightline to discuss further the reason for this decline and how we could further help you.<br />

												</td>
											</tr>
											</form>
										</table>
									</td>
								</tr>
							</table>
							<!--[if (gte mso 9)|(IE)]>
						</td>
					</tr>
				</table>
				<![endif]-->
				<!--[if (gte mso 9)|(IE)]>
				<table width="425" align="left" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td>
							<![endif]-->
							<table class="col425" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 425px;">
								<tr>
									<td height="70">
									</td>
								</tr>
							</table>
							<!--[if (gte mso 9)|(IE)]>
						</td>
					</tr>
				</table>
				<![endif]-->      
			</body>
		</html>
';
$mail->Body = $body;
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
	$error = $mail->ErrorInfo;
	echo "<script>
				alert('Unfortunately there seems to have been an issue submitting your feedback, please try again.  Should you continue to have problems please contact Dean Langford directly at dean.langford@gap-personnel.com'); 
				window.history.go(-1);
		 </script>";
} else {
	unset($_SESSION['form']);
	echo "<script>
				 alert('Your form has been submitted successfully and an acknowledgement email has been sent to you.'); 
				 window.history.go(-1);
		 </script>";
}

?>
