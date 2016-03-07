<?php

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
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<form>
											<tr>
												<td class="h2" colspan="2">
													 <center>Working Times for '.$branch['branchName'].'</center>
												</td>
											</tr>
											<tr>
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">CALL ID:</td>					<td><p><pre>'.$_SESSION['form']['callID'].'</pre></p></td>
											</tr>
                                            <tr>
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">BRANCH:</td>	             	<td><p><pre>'.$branch['branchName'].'</pre></p></td>
											</tr>
                                            <tr>                                           
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">TITLE:</td>	              	<td><p><pre>'.$_SESSION['form']['title'].'</pre></p></td>
											</tr>
                                            <tr>                                      
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">FIRST NAME:</td>	         	<td><p><pre>'.$_SESSION['form']['firstName'].'</pre></p></td>
											</tr>
                                            <tr>
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">LAST NAME:</td>	          	<td><p><pre>'.$_SESSION['form']['lastName'].'</pre></p></td>
											</tr>
                                            <tr>
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">LANDLINE NUMBER:</td>	    	<td><p><pre>'.$_SESSION['form']['landline'].'</pre></p></td>
											</tr>
                                            <tr>
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">MOBILE NUMBER:</td>	      	<td><p><pre>'.$_SESSION['form']['mobile'].'</pre></p></td>
											</tr>
                                            <tr>
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">STATUS:</td>	  				<td><p><pre>'.$_SESSION['form']['status'].'</pre></p></td>
											</tr>
                                            <tr>
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">FURTHER ACTIONS:</td>	  		<td style="width: 300px;"><p><pre wrap="" style="white-space: pre-wrap">'.$_SESSION['form']['further'].'</pre></p></td>
											</tr>
											<tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;" colspan="2"><hr width="80%"></td>
											</tr>
                                            <tr>
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">MONDAY:  <label>Client: </label></td>		<td><p><pre>'.$_SESSION['form']['monclient'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">MONDAY:  <label>Start: </label></td>		<td><p><pre>'.$_SESSION['form']['monstart'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">MONDAY:  <label>Finish: </label></td>		<td><p><pre>'.$_SESSION['form']['monfinish'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">MONDAY:  <label>Type: </label></td>		<td><p><pre>'.$_SESSION['form']['montype'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;" colspan="2"><hr width="80%"></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">TUESDAY:  <label>Client: </label></td>		<td><p><pre>'.$_SESSION['form']['tueclient'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">TUESDAY:  <label>Start: </label></td>		<td><p><pre>'.$_SESSION['form']['tuestart'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">TUESDAY:  <label>Finish: </label></td>		<td><p><pre>'.$_SESSION['form']['tuefinish'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">TUESDAY:  <label>Type: </label></td>		<td><p><pre>'.$_SESSION['form']['tuetype'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;" colspan="2"><hr width="80%"></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">WEDNESDAY:  <label>Client: </label></td>	<td><p><pre>'.$_SESSION['form']['wedclient'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">WEDNESDAY:  <label>Start: </label></td>	<td><p><pre>'.$_SESSION['form']['wedstart'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">WEDNESDAY:  <label>Finish: </label></td>	<td><p><pre>'.$_SESSION['form']['wedfinish'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">WEDNESDAY:	 <label>Type: </label></td>		<td><p><pre>'.$_SESSION['form']['wedtype'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;" colspan="2"><hr width="80%"></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">THURSDAY:  <label>Client: </label></td>	<td><p><pre>'.$_SESSION['form']['thuclient'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">THURSDAY:  <label>Start: </label></td>		<td><p><pre>'.$_SESSION['form']['thustart'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">THURSDAY:	  <label>Finish: </label></td>	<td><p><pre>'.$_SESSION['form']['thufinish'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">THURSDAY:  <label>Type: </label></td>		<td><p><pre>'.$_SESSION['form']['thutype'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;" colspan="2"><hr width="80%"></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">FRIDAY:  <label>Client: </label></td>		<td><p><pre>'.$_SESSION['form']['friclient'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">FRIDAY:  <label>Start: </label></td>		<td><p><pre>'.$_SESSION['form']['fristart'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">FRIDAY:  <label>Finish: </label></td>		<td><p><pre>'.$_SESSION['form']['frifinish'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">FRIDAY:  <label>Type: </label></td>		<td><p><pre>'.$_SESSION['form']['fritype'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;" colspan="2"><hr width="80%"></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">SATURDAY:  <label>Client: </label></td>	<td><p><pre>'.$_SESSION['form']['satclient'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">SATURDAY:  <label>Start: </label></td>		<td><p><pre>'.$_SESSION['form']['satstart'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">SATURDAY:  <label>Finish: </label></td>	<td><p><pre>'.$_SESSION['form']['satfinish'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">SATURDAY:  <label>Type: </label></td>		<td><p><pre>'.$_SESSION['form']['sattype'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;" colspan="2"><hr width="80%"></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">SUNDAY:  <label>Client: </label></td>		<td><p><pre>'.$_SESSION['form']['sunclient'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">SUNDAY:  <label>Start: </label></td>		<td><p><pre>'.$_SESSION['form']['sunstart'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">SUNDAY:  <label>Finish: </label></td>		<td><p><pre>'.$_SESSION['form']['sunfinish'].'</pre></p><br /></td>
											</tr>
                                            <tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;">SUNDAY:  <label>Type: </label></td>		<td><p><pre>'.$_SESSION['form']['suntype'].'</pre></p><br /></td>
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

?>