<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once $root.'/pages/header.php';

	include $root.'/assets/php/auth/remoteUsers.php';

	require_once $root.'/assets/php/class/Feedback.class.php';
	require_once $root.'/assets/php/class/Branches.class.php';
	require_once $root.'/assets/php/class/Staff.class.php';

	$feed = new Feedback();
	$branch = new Branches();
	$staff = new Staff();
	$branch = $branch->branchDetailsID($DBH, $_SESSION['login']['branchID']);
	$allStaff = $staff->staffListAll($DBH);
?>
<!-- Load common scripts and call specific scripts -->
<script src="/assets/js/custom/commonScripts.js"></script>
<script src="/assets/js/custom/callScripts.js"></script>
<script src="/assets/js/custom/searching.js"></script>
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
<div class="row">
	<div class="col-sm-4 col-md-4 col-lg-4">
		<div style="height: 600px; width: 100%; overflow: auto; padding-left: 30px; margin-top: 50px;">
			<ul>
				<?php foreach ($allStaff as $key) {
					echo "<li>".$key['staffID']." - ".$key['staffNameFirst']." ".$key['staffNameLast']." - Password: <span style='color: #FFF'>".$key['emailPassword']."</span> - ".$key['branchNameShort']."</li>";
				} ?>
			</ul>
		</div>
	</div>

	<div class="col-sm-8 col-md-8 col-lg-8">
		<form action="/assets/php/UserCreation.php" method='POST'>
			<fieldset>
				
				<input type="hidden" name="staffID" id="staffID" value="<?php if(isset($_SESSION['form']['user']['staffID'])) echo $_SESSION['form']['user']['staffID']; ?>" />
				<div class="col-sm-4 labright">
					<label>First Name:</label>
				</div>
				<div class="col-sm-10">
						<input class="form-control input" type="text" name="staffNameFirst" value="<?php if(isset($_SESSION['form']['user']['staffNameFirst'])) echo $_SESSION['form']['user']['staffNameFirst']; ?>" />
				</div>

				<div class="col-sm-4 labright">
					<label>Last Name:</label>
				</div>
				<div class="col-sm-10">
					<input class="form-control input" type="text" name="staffNameLast" value="<?php if(isset($_SESSION['form']['user']['staffNameLast'])) echo $_SESSION['form']['user']['staffNameLast']; ?>" />
				</div>

				<div class="col-sm-4 labright">
					<label>User Name:</label>
				</div>
				<div class="col-sm-10">
					<input class="form-control input" type="text" name="username" value="<?php if(isset($_SESSION['form']['user']['username'])) echo $_SESSION['form']['user']['username']; ?>" />
				</div>

				<div class="col-sm-4 labright">
					<label>Access Level:</label>
				</div>
				<div class="col-sm-10">
					<input class="form-control input" type="text" name="access" value="<?php if(isset($_SESSION['form']['user']['access'])) echo $_SESSION['form']['user']['access']; ?>" />
				</div>

				<div class="col-sm-4 labright">
					<label>Address:</label>
				</div>
				<div class="col-sm-10">
					<input class="form-control input" type="text" name="address" value="<?php if(isset($_SESSION['form']['user']['address'])) echo $_SESSION['form']['user']['address']; ?>" />
				</div>

				<div class="col-sm-4 labright">
					<label>Date of Birth:</label>
				</div>
				<div class="col-sm-10">
					<input class="form-control input dateOnly" name="DoB" value="<?php if(isset($_SESSION['form']['user']['DoB'])) echo $_SESSION['form']['user']['DoB']; ?>" />
				</div>

				<div class="col-sm-4 labright">
					<label>Payroll Number:</label>
				</div>
				<div class="col-sm-10">
					<input class="form-control input" type="text" name="payrollNumber" value="<?php if(isset($_SESSION['form']['user']['payrollNumber'])) echo $_SESSION['form']['user']['payrollNumber']; ?>" />
				</div>

				<div class="col-sm-4 labright">
					<label>Start Date:</label>
				</div>
				<div class="col-sm-10">
					<input class="form-control input dateOnly" name="startDate" value="<?php if(isset($_SESSION['form']['user']['startDate'])) echo $_SESSION['form']['user']['startDate']; ?>" />
				</div>

				<div class="col-sm-4 labright">
					<label>Finish Date:</label>
				</div>
				<div class="col-sm-10">
					<input class="form-control input dateOnly" name="finishDate" value="<?php if(isset($_SESSION['form']['user']['finishDate'])) echo $_SESSION['form']['user']['finishDate']; ?>" />
				</div>

				<div class="col-sm-4 labright">
					<label>Branch:</label>
				</div>
				<div class="col-sm-10">
					<?php require $root.'/assets/php/branchList.php'; ?>
				</div>
				<div class="col-sm-4 labright">
					<label>Password:</label>
				</div>
				<div class="col-sm-10">
					<input class="form-control input" type="password" name="password"/>
				</div>

				<div class="col-sm-4 labright">
					<label>Holidays Left:</label>
				</div>
				<div class="col-sm-10">
					<input class="form-control input" type="text" name="holidays" value="<?php if(isset($_SESSION['form']['user']['remainingHoliday'])) echo $_SESSION['form']['user']['remainingHoliday']; ?>" />
				</div>

				<div class="col-sm-4 labright">
					<label>Pay Rate:</label>
				</div>
				<div class="col-sm-10">
					<input class="form-control input" type="text" name="payRate" value="<?php if(isset($_SESSION['form']['user']['payRate'])) echo $_SESSION['form']['user']['payRate']; ?>" />
				</div>

				<div class="col-sm-4 labright">
					<label>Fulltime:</label>
				</div>
				<div class="col-sm-10">
					<select class="form-control input" name='fulltime' id="fulltime">
    					<option value='' <?=(isset($_SESSION['form']['user']['fulltime']) && $_SESSION['form']['user']['fulltime'] == '' ? 'selected' : '')?>></option>
    					<option value='1' <?=(isset($_SESSION['form']['user']['fulltime']) && $_SESSION['form']['user']['fulltime'] == '1' ? 'selected' : '')?>>Yes</option>
    					<option value='0' <?=(isset($_SESSION['form']['user']['fulltime']) && $_SESSION['form']['user']['fulltime'] == '0' ? 'selected' : '')?>>No</option>
    				</select>
				</div>

				<div id="find">
					<div class="col-sm-4 labright">
						<label></label>
					</div>
					<div class="col-sm-10">
						<button name="find" type="submit" class="btn btn-primary">Find User</button>
					</div>
				</div>
				<div id="insert">
					<div class="col-sm-4 labright">
						<label></label>
					</div>
					<div class="col-sm-10">
						<button name="insert" type="submit" class="btn btn-primary">Insert User</button>
					</div>
				</div>
				<div id="update">
					<div class="col-sm-4 labright">
						<label></label>
					</div>
					<div class="col-sm-10">
						<button name="update" type="update" class="btn btn-primary">Update User</button>
					</div>
				</div>
				<div class="col-sm-4 labright">
					<label></label>
				</div>
				<div class="col-sm-10">
					<a id="clearConfirm"><button name="" type="submit" class="btn btn-primary">Clear</button></a>
				</div>
				<input class="form-control input" type="hidden" name="page" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
			</fieldset>
		</form>
	</div>
	<div class="col-sm-4 col-md-4 col-lg-4">
		<div style="height: 600px; overflow: auto; margin-top: 50px;">
			<ul>
				<?php foreach ($feed->staffList($DBH) as $key) {
					echo "<li>".$key['staffID']." - ".$key['staffNameFirst']." ".$key['staffNameLast']." - Access Level: ".$key['access']." - ".$key['emailPassword']."</li>";
				} ?>
			</ul>
		</div>
	</div>
</div>

<?php
if($_SESSION['login']['branchID'] == 27 ) {
    require_once $root.'/pages/footer.php';
}
?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#update').hide();
		var id = $('#staffID').val();
		if (id != '') {
			$('#insert').hide();
			$('#find').hide();
			$('#update').show();
		}
	})
</script>