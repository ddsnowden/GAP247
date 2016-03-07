<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';
var_dump($_SESSION['form']);
require_once $root.'/assets/php/class/Email.class.php';
require_once $root.'/assets/php/class/Branches.class.php';
$email = new Email();
$branches = new Branches();

$branch = $branches->branchDetailsID($DBH, $_SESSION['login']['branchID']);
$staff = $email->staffDetails($DBH, $_SESSION['form']['operator']);

$to = 'branch';
$branch = array("branchName" => $branch['branchName'], "branchNameShort" => $branch['branchNameShort']);
$from = $_SESSION['login']['staffNameFirst'].'.'.$_SESSION['login']['staffNameLast'].'@gap-personnel.com';
$bcc = 'nightline@gap-personnel.com';

$body =  '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
                                            <center><img style="top: 0px;" src="nightline.jpg" border="0"  alt="" /></center>
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
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td class="h2">
													Feedback from '.$_SESSION['form']['nameFirst'].' '.$_SESSION['form']['nameLast'].' at '.$branch['branchNameShort'].'
												</td>
											</tr>
											<tr>
												<td class="bodycopy">
													<form>
													<p style="text-align: center;">Thank you for raising a feedback ticket with Nightline.  I will endevour to reply to this email within 24 hours of receiveing it.
													Should you need any further help please do not hesitate to contact me directly.</p>
													CALL ID:			<input type="text" name="CallID" value="'.$feedbackID.'" />
													<br />
													BRANCH:             <input type="text" name="Branch" value="'.$branch['branchNameShort'].'" />
													<br/>                                            
													FIRST NAME:         <input type="text" name="First Name" value="'.$_SESSION['form']['nameFirst'].'" />
													<br/>
													LAST NAME:          <input type="text" name="Last Name" value="'.$_SESSION['form']['nameLast'].'" />
													<br/>
													FEEDBACK TYPE:      <input type="text" name="feedbackType" value="'.$_SESSION['form']['feedbackType'].'" />
													<br/>
													COMPLAINT TYPE:     <input type="text" name="complaintType" value="'.$_SESSION['form']['complaintType'].'" />
													<br/>
													OPERATORS NAME:		<input type="text" name="operatorID" value="'.$staff['staffNameFirst'].' '.$staff['staffNameLast'].'" />
													<br />
													CALL ID:			<input type="text" name="callIDRef" value="'.$_SESSION['form']['callIDRef'].'" />
													<br />
													PROCEDURE TYPE:		<input type="text" name="time needed" value="'.$_SESSION['form']['procType'].'" />
													<br />
													DETAILS:            <textarea name="Details">'.$_SESSION['form']['details'].'</textarea>  
													<br/>
													</form>
												</td>
											</tr>
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
		</html>';

$type = ucwords($_SESSION['form']['type']);

$error = $email->sendEmail($DBH, $_SESSION['login']['staffID'], $to, $branch, $from, $bcc, $body, $type);

if($error == 'success') {
	unset($_SESSION['form']);
	echo "<script>
		alert('Your feedback has been submitted successfully and an acknowledgement email has been sent to you.'); 
		window.history.go(-1);
	</script>";
}
else {
	echo "<script>
		alert('Unfortunately there seems to have been an issue submitting your feedback, please try again.  Should you continue to have problems please contact Dean Langford directly at dean.langford@gap-personnel.com'); 
		window.history.go(-1);
	</script>";
}