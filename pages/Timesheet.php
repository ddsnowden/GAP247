<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once $root.'/pages/header.php';

    include $root.'/assets/php/auth/branchUsers.php';

	require_once $root.'/assets/php/class/Timesheet.class.php';

	$timeData = new Timesheet();
	$recall = $timeData->recall($DBH, $_SESSION['login']['access'], $_SESSION['login']['staffID']);
?>
<!-- Load common scripts and call specific scripts -->
<script src="/assets/js/custom/commonScripts.js"></script>
<script src="/assets/js/custom/callScripts.js"></script>
<script src="/assets/js/custom/searching.js"></script>

<script type="text/javascript">var callType = 'timesheet';</script>
<!-- Start Open Web Analytics Tracker -->
<script type="text/javascript">
//<![CDATA[
var owa_baseUrl = 'http://nightline/assets/Open-Web-Analytics/';
var owa_cmds = owa_cmds || [];
owa_cmds.push(['setSiteId', 'a892d08052dfe7355501b456aef1e8e1']);
owa_cmds.push(['trackPageView']);
owa_cmds.push(['trackClicks']);
owa_cmds.push(['trackDomStream']);

(function() {
    var _owa = document.createElement('script'); _owa.type = 'text/javascript'; _owa.async = true;
    owa_baseUrl = ('https:' == document.location.protocol ? window.owa_baseSecUrl || owa_baseUrl.replace(/http:/, 'https:') : owa_baseUrl );
    _owa.src = owa_baseUrl + 'modules/base/js/owa.tracker-combined-min.js';
    var _owa_s = document.getElementsByTagName('script')[0]; _owa_s.parentNode.insertBefore(_owa, _owa_s);
}());
//]]>
</script>
<!-- End Open Web Analytics Code -->
<!-- Start main content of the page -->
<div class="row form">
	<div class="col-sm-10 col-md-10 col-lg-7">
		<form method="POST" action="/assets/php/Timesheet.php" role="form" class="form-horizontal" >
			<input type='hidden' name='timeID' value="<?php if (isset($_SESSION['form']['timeID'])) echo $_SESSION['form']['timeID']; ?>" />
			<div class="col-sm-6 labright">
                <label for="recall">Recall:</label>
            </div>
            <div class="col-sm-10">
				<select name='recall' id='recall' class="form-control input">
					<option selected></option>
					<?php
	                    foreach ($recall as $key) {
							echo '<option id='.$key['timeID'].'>Week number - '.date("W", strtotime($key['commence'])) . ' - ' .$key['branchNameShort'].' - '.$key['staffNameFirst'].' '.$key['staffNameLast'];'</option>';
						}
	                ?>
	            </select>
	        </div>
	    	
	    	<div class="col-sm-6 labright">
                <label for="firstName">First Name:</label>
            </div>
            <div class="col-sm-10">
            	<input class="form-control input letters" name="firstName" id="firstName" type="text" value="<?php if(($_SESSION['login']['access'] == 2) && isset($_SESSION['form']['staffNameFirst'])) {echo $_SESSION['form']['staffNameFirst']; } else {echo $_SESSION['login']['staffNameFirst']; }  ?>" disabled />
        	</div>

            <div class="col-sm-6 labright">
                <label for="lastName">Last Name:</label>
            </div>
            <div class="col-sm-10">
            	<input class="form-control input letters" name="lastName" id="lastName" type="text" value="<?php if(($_SESSION['login']['access'] == 2) && isset($_SESSION['form']['staffNameLast'])) {echo $_SESSION['form']['staffNameLast']; } else {echo $_SESSION['login']['staffNameLast']; }  ?>" disabled />
        	</div>

        	<div class="col-sm-6 labright">
                <label for="payroll">Payroll Number:</label>
            </div>
            <div class="col-sm-10">
            	<input class="form-control input letters" name="payroll" type="text" value="<?php if(($_SESSION['login']['access'] == 2) && isset($_SESSION['form']['payrollNumber'])) {echo $_SESSION['form']['payrollNumber']; } elseif (isset($_SESSION['form']['payrollNumber'])) { echo $_SESSION['form']['payrollNumber']; }  ?>" disabled />
        	</div>

            <div class="col-sm-6 labright">
                <label for="branch">Branch:</label>
            </div>
            <div class="col-sm-10">
            	<input class="form-control input letters" name="branch" id="branch" type="text" value="Nightline" disabled />
        	</div>

        	<div class="col-sm-6 labright">
                <label for="commence">Week Commencing:</label>
            </div>
            <div class="col-sm-10">
				<input class="form-control input dateOnlyMonday" name="commence" value="<?php if (isset($_SESSION['form']['commence'])) echo $_SESSION['form']['commence']; ?>" required/>
			</div>

			<div class="col-sm-6 labright">
                <label for="commence">Monday:</label>
            </div>

            <div class="col-sm-5">
				<input class="form-control input datetime <?php if(isset($_SESSION['form']['error1'])) echo $_SESSION['form']['error1']; ?>" placeholder="Start" name="monStart" value="<?php if (isset($_SESSION['form']['monStart'])) echo $timeData->removeZeros($_SESSION['form']['monStart']); ?>" />
			</div>
			<div class="col-sm-5">
				<input class="form-control input datetime <?php if(isset($_SESSION['form']['error1'])) echo $_SESSION['form']['error1']; ?>" placeholder="Finish" name="monFinish" value="<?php if (isset($_SESSION['form']['monFinish'])) echo $timeData->removeZeros($_SESSION['form']['monFinish']); ?>" />
			</div>

			<div class="col-sm-6 labright">
                <label for="commence">Tuesday:</label>
            </div>
            <div class="col-sm-5">
				<input class="form-control input datetime <?php if(isset($_SESSION['form']['error2'])) echo $_SESSION['form']['error2']; ?>" placeholder="Start" name="tueStart" value="<?php if (isset($_SESSION['form']['tueStart'])) echo $timeData->removeZeros($_SESSION['form']['tueStart']); ?>" />
			</div>
			<div class="col-sm-5">
				<input class="form-control input datetime <?php if(isset($_SESSION['form']['error2'])) echo $_SESSION['form']['error2']; ?>" placeholder="Finish" name="tueFinish" value="<?php if (isset($_SESSION['form']['tueFinish'])) echo $timeData->removeZeros($_SESSION['form']['tueFinish']); ?>" />
			</div>

			<div class="col-sm-6 labright">
                <label for="commence">Wednesday:</label>
            </div>
            <div class="col-sm-5">
				<input class="form-control input datetime <?php if(isset($_SESSION['form']['error3'])) echo $_SESSION['form']['error3']; ?>" placeholder="Start" name="wedStart" value="<?php if (isset($_SESSION['form']['wedStart'])) echo $timeData->removeZeros($_SESSION['form']['wedStart']); ?>" />
			</div>
			<div class="col-sm-5">
				<input class="form-control input datetime <?php if(isset($_SESSION['form']['error3'])) echo $_SESSION['form']['error3']; ?>" placeholder="Finish" name="wedFinish" value="<?php if (isset($_SESSION['form']['wedFinish'])) echo $timeData->removeZeros($_SESSION['form']['wedFinish']); ?>" />
			</div>

			<div class="col-sm-6 labright">
                <label for="commence">Thursday:</label>
            </div>
            <div class="col-sm-5">
				<input class="form-control input datetime <?php if(isset($_SESSION['form']['error4'])) echo $_SESSION['form']['error4']; ?>" placeholder="Start" name="thuStart" value="<?php if (isset($_SESSION['form']['thuStart'])) echo $timeData->removeZeros($_SESSION['form']['thuStart']); ?>" />
			</div>
			<div class="col-sm-5">
				<input class="form-control input datetime <?php if(isset($_SESSION['form']['error4'])) echo $_SESSION['form']['error4']; ?>" placeholder="Finish" name="thuFinish" value="<?php if (isset($_SESSION['form']['thuFinish'])) echo $timeData->removeZeros($_SESSION['form']['thuFinish']); ?>" />
			</div>

			<div class="col-sm-6 labright">
                <label for="commence">Friday:</label>
            </div>
            <div class="col-sm-5">
				<input class="form-control input datetime <?php if(isset($_SESSION['form']['error5'])) echo $_SESSION['form']['error5']; ?>" placeholder="Start" name="friStart" value="<?php if (isset($_SESSION['form']['friStart'])) echo $timeData->removeZeros($_SESSION['form']['friStart']); ?>" />
			</div>
			<div class="col-sm-5">
				<input class="form-control input datetime <?php if(isset($_SESSION['form']['error5'])) echo $_SESSION['form']['error5']; ?>" placeholder="Finish" name="friFinish" value="<?php if (isset($_SESSION['form']['friFinish'])) echo $timeData->removeZeros($_SESSION['form']['friFinish']); ?>" />
			</div>

			<div class="col-sm-6 labright">
                <label for="commence">Saturday:</label>
            </div>
            <div class="col-sm-5">
				<input class="form-control input datetime <?php if(isset($_SESSION['form']['error6'])) echo $_SESSION['form']['error6']; ?>" placeholder="Start" name="satStart" value="<?php if (isset($_SESSION['form']['satStart'])) echo $timeData->removeZeros($_SESSION['form']['satStart']); ?>" />
			</div>
			<div class="col-sm-5">
				<input class="form-control input datetime <?php if(isset($_SESSION['form']['error6'])) echo $_SESSION['form']['error6']; ?>" placeholder="Finish" name="satFinish" value="<?php if (isset($_SESSION['form']['satFinish'])) echo $timeData->removeZeros($_SESSION['form']['satFinish']); ?>" />
			</div>

			<div class="col-sm-6 labright">
                <label for="commence">Sunday:</label>
            </div>
            <div class="col-sm-5">
				<input class="form-control input datetime <?php if(isset($_SESSION['form']['error7'])) echo $_SESSION['form']['error7']; ?>" placeholder="Start" name="sunStart" value="<?php if (isset($_SESSION['form']['sunStart'])) echo $timeData->removeZeros($_SESSION['form']['sunStart']); ?>" />
			</div>
			<div class="col-sm-5">
				<input class="form-control input datetime <?php if(isset($_SESSION['form']['error7'])) echo $_SESSION['form']['error7']; ?>" placeholder="Finish" name="sunFinish" value="<?php if (isset($_SESSION['form']['sunFinish'])) echo $timeData->removeZeros($_SESSION['form']['sunFinish']); ?>" />
			</div>

			<div class="col-sm-6 labright">
        	   <!-- <label for="submit"></label> -->
            </div>
            <div class="col-sm-10">
            	<button id="submit" name="submit" type="submit" class="btn btn-primary">Submit</button>
            </div>

            <div class="col-sm-6 labright">
               <!-- <label for="clear"></label> -->
            </div>
            <div class="col-sm-10">
            	<a id="clearConfirm"><button name="" type="submit" class="btn btn-primary">Clear</button></a>
            </div>
            <input type="hidden" name="page" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
		</form>
	</div>
	<div class="col-sm-6 col-md-6 col-lg-9">
		<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2"></div>
		<div class="col-sm-10 col-md-10 col-lg-10">
			<div>
                <table class="tableWhite" style="width: 100%">
                    <th class="top" style="width: 15%"></th><th class="top" style="max-width: 10%">Total Hours</th><th class="top"  class="checkinContacts" style="max-width: 5%">Pay Rate</th><th class="top"  class="checkinContacts" style="max-width: 12.5%">Before Tax</th><th class="top">Holidays Acquired</th>
                        <tbody>
                        	<tr>
                        		<td class="side">Monday</td>
                        		<td><?php if(isset($_SESSION['form']['totalHours']['1'])) echo $_SESSION['form']['totalHours']['1']; ?></td>
                                <td><?php if(isset($_SESSION['login']['payRate'])) echo '£'.$_SESSION['login']['payRate']; ?></td>
                                <td><?php if(isset($_SESSION['form']['monPay'])) echo '£'.$_SESSION['form']['monPay']; ?></td>
                                <td><?php if(isset($_SESSION['form']['hols']['1'])) echo $_SESSION['form']['hols']['1']; ?></td>
                        	</tr>
                            <tr>
                                <td class="side">Tuesday</td>
                                <td><?php if(isset($_SESSION['form']['totalHours']['2'])) echo $_SESSION['form']['totalHours']['2']; ?></td>
                                <td><?php if(isset($_SESSION['login']['payRate'])) echo '£'.$_SESSION['login']['payRate']; ?></td>
                                <td><?php if(isset($_SESSION['form']['tuePay'])) echo '£'.$_SESSION['form']['tuePay']; ?></td>
                                <td><?php if(isset($_SESSION['form']['hols']['1'])) echo $_SESSION['form']['hols']['2']; ?></td>
                            </tr>
                            <tr>
                            	<td class="side">Wednesday</td>
                            	<td><?php if(isset($_SESSION['form']['totalHours']['3'])) echo $_SESSION['form']['totalHours']['3']; ?></td>
                                <td><?php if(isset($_SESSION['login']['payRate'])) echo '£'.$_SESSION['login']['payRate']; ?></td>
                                <td><?php if(isset($_SESSION['form']['wedPay'])) echo '£'.$_SESSION['form']['wedPay']; ?></td>
                                <td><?php if(isset($_SESSION['form']['hols']['1'])) echo $_SESSION['form']['hols']['3']; ?></td>
                            </tr>
                            <tr>
                            	<td class="side">Thursday</td>
                            	<td><?php if(isset($_SESSION['form']['totalHours']['4'])) echo $_SESSION['form']['totalHours']['4']; ?></td>
                                <td><?php if(isset($_SESSION['login']['payRate'])) echo '£'.$_SESSION['login']['payRate']; ?></td>
                                <td><?php if(isset($_SESSION['form']['thuPay'])) echo '£'.$_SESSION['form']['thuPay']; ?></td>
                                <td><?php if(isset($_SESSION['form']['hols']['1'])) echo $_SESSION['form']['hols']['4']; ?></td>
                            </tr>
                            <tr>
                            	<td class="side">Friday</td>
                            	<td><?php if(isset($_SESSION['form']['totalHours']['5'])) echo $_SESSION['form']['totalHours']['5']; ?></td>
                                <td><?php if(isset($_SESSION['login']['payRate'])) echo '£'.$_SESSION['login']['payRate']; ?></td>
                                <td><?php if(isset($_SESSION['form']['friPay'])) echo '£'.$_SESSION['form']['friPay']; ?></td>
                                <td><?php if(isset($_SESSION['form']['hols']['1'])) echo $_SESSION['form']['hols']['5']; ?></td>
                            </tr>
                            <tr>
                            	<td class="side">Saturday</td>
                            	<td><?php if(isset($_SESSION['form']['totalHours']['6'])) echo $_SESSION['form']['totalHours']['6']; ?></td>
                                <td><?php if(isset($_SESSION['login']['payRate'])) echo '£'.$_SESSION['login']['payRate']; ?></td>
                                <td><?php if(isset($_SESSION['form']['satPay'])) echo '£'.$_SESSION['form']['satPay']; ?></td>
                                <td><?php if(isset($_SESSION['form']['hols']['1'])) echo $_SESSION['form']['hols']['6']; ?></td>
                            </tr>
                            <tr>
                            	<td class="side">Sunday</td>
                            	<td><?php if(isset($_SESSION['form']['totalHours']['7'])) echo $_SESSION['form']['totalHours']['7']; ?></td>
                                <td><?php if(isset($_SESSION['login']['payRate'])) echo '£'.$_SESSION['login']['payRate']; ?></td>
                                <td><?php if(isset($_SESSION['form']['sunPay'])) echo '£'.$_SESSION['form']['sunPay']; ?></td>
                                <td><?php if(isset($_SESSION['form']['hols']['1'])) echo $_SESSION['form']['hols']['7']; ?></td>
                            </tr>
                            <tr id="base">
                            	<td class="side">Totals &#10140;</td>
                            	<td><?php if(isset($_SESSION['form']['totalHours']['total'])) echo $_SESSION['form']['totalHours']['total']; ?></td>
                                <td></td>
                                <td><?php if(isset($_SESSION['form']['totalPay'])) echo '£'.$_SESSION['form']['totalPay']; ?></td>
                                <td><?php if(isset($_SESSION['form']['totalHols'])) echo $_SESSION['form']['totalHols'].'h'; ?></td>
                            </tr>
                    	</tbody>
                	</table>
		   		</div>
			</div>
		</div>
	</div>
</div>

<?php
if($_SESSION['login']['branchID'] == 27 ) {
    require_once $root.'/pages/footer.php';
}
?>