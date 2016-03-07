<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root.'/pages/header.php';
    
    include $root.'/assets/php/auth/branchUsers.php';

    require_once $root.'/assets/php/class/StaffInfo.class.php';
    require_once $root.'/assets/php/class/Staff.class.php';
    $staffInfo = new StaffInfo();
    $staff = new Staff();
    $staffList = $staff->staffList($DBH);

?>
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
<script src="/assets/js/custom/commonScripts.js"></script>
<script src="/assets/js/custom/callScripts.js"></script>
<script src="/assets/js/custom/searching.js"></script>
<!-- Start main content of the page -->
<div class="row form">
	<div class="col-sm-16 col-md-16 col-lg-16">
		<?php
				if(isset($_POST['insert'])) {
					$staffInfo->insert($DBH, $_POST['staffID'], date('Y-m-d', strtotime($_POST['weekStarting'])), $_POST['hoursWorked'], $_POST['holidayTaken']);
				}
				if(isset($_POST['email'])) {
					$result = $staffInfo->emailPayroll($DBH, $_POST['date']);
					
					$week = $_POST['date'];
					
					require_once $root.'/assets/php/emails/timesheetEmail.php';
				}
		    	if(isset($_POST['submit'])) {

		    		foreach ($_POST as $key => $value) {
					  	if($key == "submit") continue;
					  	$username = $value;
					}

		    		$payroll = $staffInfo->payrollDetails($DBH, $username);
		    		$history = $staffInfo->payrollHistory($DBH, $username);

		    		?>
		    		<div class="row">  <!-- Group One -->
						<div class="col-sm-8 col-md-8 col-lg-8">
							<form method="POST" action="" >
								<div class="row">
									<div class="col-sm-6 labright">
										<label ></label>
									</div>
									<div class="col-sm-10">
										<input class="form-control input" type="hidden" name="staffID" value="<?php echo $payroll['staffID']; ?>" />
									</div>
									<div class="col-sm-6 labright">
										<label ></label>
									</div>
									<div class="col-sm-10">
										<input class="form-control input" type="text" name="name" value="<?php echo $payroll['staffNameFirst'].' '.$payroll['staffNameLast']; ?>" readonly />
									</div>
									<div class="col-sm-6 labright">
										<label ></label>
									</div>
									<div class="col-sm-10">
										<input class="form-control input" type="text" name="payrollNumber" value="<?php echo $payroll['payrollNumber']; ?>" readonly />
									</div>
									<div class="col-sm-6 labright">
										<label ></label>
									</div>
									<div class="col-sm-10">
										<input class="form-control input" type="text" name="payRate" value="<?php echo $payroll['payRate']; ?>" readonly />
									</div>
									<div class="col-sm-6 labright">
										<label >Week Starting</label>
									</div>
									<div class="col-sm-10">
										<input class=" form-control dateOnlySunday" type="text" name="weekStarting" />
									</div>
									<div class="col-sm-6 labright">
										<label >Hours Worked</label>
									</div>
									<div class="col-sm-10">
										<input class="form-control input" type="number" name="hoursWorked" />
									</div>
									<div class="col-sm-6 labright">
										<label >Holiday Taken</label>
									</div>
									<div class="col-sm-10">
										<input class="form-control input" type="number" name="holidayTaken" />
									</div>
									<div class="col-sm-6 labright">
									</div>
									<div class="col-sm-10">
										<input type="hidden" name="page" value="'.$_SERVER['REQUEST_URI'].'">
									</div>

									<div class="col-sm-6 labright">
										<label ></label>
									</div>
									<div class="col-sm-10">
										<button id="submit" name="insert" type="submit" class="btn btn-primary">Submit</button>
									</div>
									<div class="col-sm-6 labright">
										<label >Back to User List:</label></div>
									<div class="col-sm-10">
										<a href="/WebAdmin/Timesheets/"><button class="btn btn-primary">Back</button></a>
									</div>
								</div>
							</form>
				    	</div>
				    	<div class="col-sm-8 col-md-8 col-lg-8">
				    		<div style="width: 100%">
				                <table class="tableWhite" width="100%">
				                <th colspan="4">Payroll History for <?php echo $username; ?></th>
				                    <tr class="top" >
				                        <td>
				                            Week Starting
				                        </td>
				                        <td >
				                            Hours Worked
				                        </td>
				                        <td>
				                            Holiday Taken
				                        </td>
				                        <td>
				                            Holiday Remaining
				                        </td>
				                    </tr>
				                    <?php foreach ($history as $key) { 
				                    	if($key['fulltime'] == 0) {
				                    		$parm = 'hours';
				                    	}
				                    	else {
				                    		$parm = 'days';
				                    	}
				                    ?>
				                    <tr>
				                        <td >
				                            <?php echo date('d-m-Y', strtotime($key['weekStarting'])); ?>
				                        </td>
				                        <td>
				                            <?=(isset($key['hoursWorked']) && $key['hoursWorked'] != '' ? $key['hoursWorked'] : '0')?> hours
				                        </td>
				                        <td>
				                            <?=(isset($key['holidayTaken']) && $key['holidayTaken'] != '' ? $key['holidayTaken'] : '0')?> <?php echo $parm; ?>
				                        </td>
				                        <td>
				                            <?=(isset($key['remainingHoliday']) && $key['remainingHoliday'] != '' ? $key['remainingHoliday'] : '0')?> <?php echo $parm; ?>
				                        </td>
				                    </tr>
				                    <?php } ?>
				                </table>
				            </div>
				    	</div>
			    	</div>  <!-- End Group One -->
	    		<?php
		    	}
		    	else { ?>
		    	<div class="row">  <!-- Group Two -->
					<div class="col-sm-8 col-md-8 col-lg-5">
			    		<div id="staffSelect">
					    	<form action="" method="POST">
					    	<div class="row">  <!-- Group Two -->
					    		<div class="col-sm-8 col-md-8 col-lg-7">

						    	</div>
								<div class="col-sm-8 col-md-8 col-lg-9">
						    		<?php
						    		foreach ($staffList as $key) { 
						    			if($key['username'] == 'nightline') continue;
						    				?>
						    			<div class="checkbox">
						    				<label><input type="checkbox" name="<?php echo $key['username']; ?>" value="<?php echo $key['username']; ?>" /><?php echo $key['staffNameFirst'].' '.$key['staffNameLast']; ?></label>
						    			</div>
						    		<?php }	?>
						    	</div>
						    </div>
						    <div class="col-sm-8 col-md-8 col-lg-7">

						    </div>
						    <div class="col-sm-8 col-md-8 col-lg-9">
								<button id="submit" name="submit" type="submit" class="btn btn-primary">Submit</button>
							</div>
							</form>
						</div>
					</div>
					<div class="col-sm-8 col-md-8 col-lg-5">
						<div id="emailSelect">
							<form method="POST" action="">
								<div class="col-sm-6 labright">
									<label>Select week to email:</label>
								</div>
								<div class="col-sm-10">
									<input class="form-control input dateOnlySunday" name="date" required />
								</div>
								<input class="hidden" type='hidden' name='type' value="Payroll" />
								
								<input type="hidden" name="page" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
								<div class="col-sm-6 labright">
									<label></label>
								</div>
								<div class="col-sm-10">
									<button id="email" name="email" type="submit" class="btn btn-primary">Email</button>
									<!-- <input type="submit" name="email" value="Email" class="darkButton"/> -->
								</div>
							</form>
						</div>
					</div>
				</div>  <!-- End Group Two -->
		    	<?php
		    	}
		    	?>
			</div>
		</div>
	<script type="text/javascript">
	$(document).ready(function(){
		$('input[type="checkbox"]').on('change', function() {
		   $('input[type="checkbox"]').not(this).prop('checked', false);
		});
	});
	</script>
	</div>
	

	</div>
</div>

<?php
if($_SESSION['login']['branchID'] == 27 ) {
    require_once $root.'/pages/footer.php';
}
?>