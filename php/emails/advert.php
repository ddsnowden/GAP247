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
										<table width="100%" border="0" cellspacing="0" cellpadding="1">
										<form>
											<tr>
												<td class="h2" colspan="2">
													<center>Job Advert for '.$branch.'</center>
												</td>
											</tr>
											<tr>
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">CALL ID:</td>							<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 200px;"><p><pre>'.$_SESSION['form']['callID'].'</pre></p></td>
											</tr>
											
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">BRANCH:</td>             				<td><p><pre>'.$branch.'</pre></p></td>
											</tr>
											<tr>		                                         
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">TITLE:</td>              				<td><p><pre>'.$_SESSION['form']['title'].'</pre></p></td>
											</tr>
											<tr>		                                    
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">FIRST NAME:</td>         				<td><p><pre>'.$_SESSION['form']['firstName'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">LAST NAME:</td>          				<td><p><pre>'.$_SESSION['form']['lastName'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">LANDLINE NUMBER:</td>    				<td><p><pre>'.$_SESSION['form']['landline'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">MOBILE NUMBER:</td>     				<td><p><pre>'.$_SESSION['form']['mobile'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">WORKED IN LAST 12 MONTHS:</td>		<td><p><pre>'.$_SESSION['form']['twelveMonths'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">JOB TYPE:</td>						<td><p><pre>'.$_SESSION['form']['jobType'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">POSITION:</td>						<td><p><pre>'.$_SESSION['form']['position'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">ADVERT LOCATION:</td>					<td><p><pre>'.$_SESSION['form']['advertLocation'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">ADDRESS:</td>							<td><p><pre>'.$_SESSION['form']['nameNumber'].', '.$_SESSION['form']['addressOne'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">ADDRESS:</td>							<td><p><pre>'.$_SESSION['form']['addressTwo'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">CITY:</td>							<td><p><pre>'.$_SESSION['form']['city'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">POSTCODE:</td>						<td><p><pre>'.$_SESSION['form']['postcode'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">LICENCE TYPE:</td>					<td><p><pre>'.$_SESSION['form']['licence'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">DISQUAL:</td>							<td><p><pre>'.$_SESSION['form']['disqual'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">DISQUAL DETAILS:</td>					<td><p><pre>'.$_SESSION['form']['disqualDetails'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">TACHO:</td>							<td><p><pre>'.$_SESSION['form']['tacho'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">DETAILS:</td>							<td><p><pre wrap="" style="white-space: pre-wrap">'.$_SESSION['form']['details'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">OTHER QUALS:</td>						<td><p><pre wrap="" style="white-space: pre-wrap">'.$_SESSION['form']['other'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">CURRENTLY EMPLOYED:</td>				<td><p><pre>'.$_SESSION['form']['employed'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;" colspan="2"><center><hr width="80%" /></center></td>
											</tr>
											<tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">CURRENT POSITION:</td>					<td><p><pre>'.$_SESSION['form']['currentPos'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">CURRENT COMPANY:</td>					<td><p><pre>'.$_SESSION['form']['currentCompany'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">AGENCY:</td>							<td><p><pre>'.$_SESSION['form']['agency1'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">AGENCY NAME:</td>						<td><p><pre>'.$_SESSION['form']['agencyName1'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">SUPERVISOR NAME:</td>					<td><p><pre>'.$_SESSION['form']['supervisorName1'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;" colspan="2"><center><hr width="80%" /></center></td>
											</tr>
											<tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">PREVIOUS POSITION 1:</td>				<td><p><pre>'.$_SESSION['form']['previousPos1'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">PREVIOUS COMPANY 1:</td>				<td><p><pre>'.$_SESSION['form']['previousCompany1'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">AGENCY:</td>							<td><p><pre>'.$_SESSION['form']['agency2'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">AGENCY NAME:</td>						<td><p><pre>'.$_SESSION['form']['agencyName2'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">SUPERVISOR NAME:</td>					<td><p><pre>'.$_SESSION['form']['supervisorName2'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;" colspan="2"><center><hr width="80%" /></center></td>
											</tr>
											<tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">PREVIOUS POSITION 2:</td>				<td><p><pre>'.$_SESSION['form']['previousPos2'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">PREVIOUS COMPANY 2:</td>				<td><p><pre>'.$_SESSION['form']['previousCompany2'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">AGENCY:</td>							<td><p><pre>'.$_SESSION['form']['agency3'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">AGENCY NAME:</td>						<td><p><pre>'.$_SESSION['form']['agencyName3'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">SUPERVISOR NAME:</td>					<td><p><pre>'.$_SESSION['form']['supervisorName3'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;" colspan="2"><center><hr width="80%" /></center></td>
											</tr>
											<tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">PREVIOUS POSITION 3:</td>				<td><p><pre>'.$_SESSION['form']['previousPos3'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">PREVIOUS COMPANY 3:</td>				<td><p><pre>'.$_SESSION['form']['previousCompany3'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">AGENCY:</td>							<td><p><pre>'.$_SESSION['form']['agency4'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">AGENCY NAME:</td>						<td><p><pre>'.$_SESSION['form']['agencyName4'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">SUPERVISOR NAME:</td>					<td><p><pre>'.$_SESSION['form']['supervisorName4'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;" colspan="2"><center><hr width="80%" /></center></td>
											</tr>
											<tr>	
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">TRANSPORT:</td>						<td><p><pre>'.$_SESSION['form']['transport'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">PREFERED HOURS:</td>					<td><p><pre>'.$_SESSION['form']['preferHours'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">TRAVEL:</td>							<td><p><pre>'.$_SESSION['form']['travel'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">SALARY:</td>							<td><p><pre>'.$_SESSION['form']['salary'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;">STATUS:</td>             				<td><p><pre>'.$_SESSION['form']['status'].'</pre></p></td>
											</tr>
											<tr>		
												<td style="padding: 0px 3px 3px 0px; font-family: sans-serif; font-size: 14px; width: 240px;" valign="top">FURTHER ACTIONS:</td>    	<td><p><pre wrap="" style="white-space: pre-wrap">'.$_SESSION['form']['further'].'</pre></p></td>
											</tr>		
													
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
		</html>
';

?>