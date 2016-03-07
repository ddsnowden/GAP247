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
	<div class="col-sm-4 col-md-4 col-lg-4"></div>

	<div class="col-sm-8 col-md-8 col-lg-8">
		<form action="/assets/php/BranchCreation.php" method='POST'>
			<fieldset>
				
				<input type="hidden" name="staffID" value="<?php if(isset($_SESSION['form']['user']['staffID'])) echo htmlspecialchars($_SESSION['form']['user']['staffID']); ?>" />
				<div class="col-sm-4 labright">
					<label>Branch Name:</label>
				</div>
				<div class="col-sm-10">
						<input class="form-control input" type="text" name="branchName" />
				</div>

				<div class="col-sm-4 labright">
					<label>Branch Type:</label>
				</div>
				<div class="col-sm-10">
					<select class="form-control input" type="text" name='type'>
    					<option value=''></option>
    					<option value='DF_'>Driving Force</option>
    					<option value='GAP_'>GAP Personnel</option>
    					<option value='Onsite_'>Onsite</option>
    				</select>
				</div>

				<div class="col-sm-4 labright">
					<label>Address One:</label>
				</div>
				<div class="col-sm-10">
					<input class="form-control input" type="text" name="addressOne" />
				</div>

				<div class="col-sm-4 labright">
					<label>Address Two:</label>
				</div>
				<div class="col-sm-10">
					<input class="form-control input" type="text" name="addressTwo" />
				</div>

				<div class="col-sm-4 labright">
					<label>Address Three:</label>
				</div>
				<div class="col-sm-10">
					<input class="form-control input" type="text" name="addressThree" />
				</div>

				<div class="col-sm-4 labright">
					<label>City:</label>
				</div>
				<div class="col-sm-10">
					<input class="form-control input" type="text" name="city" />
				</div>

				<div class="col-sm-4 labright">
					<label>Postcode:</label>
				</div>
				<div class="col-sm-10">
					<input class="form-control input" type="text" name="postcode" />
				</div>

				<div class="col-sm-4 labright">
					<label>Telephone:</label>
				</div>
				<div class="col-sm-10">
					<input class="form-control input" type="text" name="telephone" />
				</div>

				<div class="col-sm-4 labright">
					<label>Email:</label>
				</div>
				<div class="col-sm-10">
					<input class="form-control input" type="text" name="email" />
				</div>

				<div class="col-sm-4 labright">
					<label>Divert Number:</label>
				</div>
				<div class="col-sm-10">
					<input class="form-control input" type="text" name="divertNumber"/>
				</div>

				<div class="col-sm-4 labright">
					<label></label>
				</div>
				<div class="col-sm-10">
					<button id="insert" name="insert" type="submit" class="btn btn-primary">Insert User</button>
				</div>

				<input class="form-control input" type="hidden" name="page" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
			</fieldset>
		</form>
		<div id="branchInstruct">
		<p>When inserting a new branch please pay attention to the formatting and details provided.</p>
		<p>Please use capital letters for the branch names, addresses and postcode.  Place spaces into the contact numbers so that they display well once inserted into the database</p>
		<p>Providing as much information and formatting it correctly will help the staff later, cheers.</p>
		</div>
	</div>
	<div class="col-sm-4 col-md-4 col-lg-4"></div>
</div>

<?php
if($_SESSION['login']['branchID'] == 27 ) {
    require_once $root.'/pages/footer.php';
}
?>