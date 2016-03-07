<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root.'/pages/header.php';
    
    include $root.'/assets/php/auth/branchUsers.php';

	require_once $root.'/assets/php/class/stats/Totals.class.php';
	require_once $root.'/assets/php/class/stats/StaffTotals.class.php';
	require_once $root.'/assets/php/class/stats/Emails.class.php';
	require_once $root.'/assets/php/class/stats/CallComplete.class.php';

	$staff = new StaffTotal();
    $email = new Email();
    $call = new Calls();

    $emailData = $email->emailStatsIndiv($DBH, $_SESSION['login']['staffID']);
    $callData = $call->callStatsPerPerson($DBH, $_SESSION['login']['staffID']);

    $emailFormattedResults = $email->format($DBH, $emailData);
    $callFormattedResults = $call->format($DBH, $callData);

    $nonEmailed = $email->nonEmailedIndiv($DBH, $_SESSION['login']['staffID']);
    $nonCompleted = $call->nonCompletedIndiv($DBH, $_SESSION['login']['staffID']);
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
<!-- Start main content of the page -->
<div class="row">
	<div class="col-sm-2 col-md-2 col-lg-2"></div>
	<div class="col-sm-12 col-md-12 col-lg-12" style="text-align: center;">
		<div class="row">
			<div class="col-sm-16 col-md-16 col-lg-16 emailStats">
			<h1><u>Time taken to complete calls</u></h1>
				<p>The total number of your calls compared for this result was <span class="highlight"><?php echo $emailFormattedResults['count']; ?></span>.</p>
				<p>Your average time between call completion of a call and emailing is <span class="highlight"><?php echo $email->secondsToTime($emailFormattedResults['diff']); ?></span> seconds.</p>
				<p>Your slowest emailed call stands at <span class="highlight"><?php echo $email->secondsToTime($emailFormattedResults['last']['diff']); ?></span> seconds. </p>
				<p>There were <span class="highlight"><?php echo $nonEmailed['count']; ?></span> call/calls that could not be compared as they have not been emailed yet.</p>
			</div>
		</div>
		<hr />
		<div class="row">
			<div class="col-sm-16 col-md-16 col-lg-16 emailStats">
			<h1><u>Time taken to complete calls</u></h1>
				<p>The total number of calls compared for this result is <span class="highlight"><?php echo $callFormattedResults['count']; ?></span>.</p>
				<p>Your average time between call a call being initiated and completed is <span class="highlight"><?php echo $call->secondsToTime($callFormattedResults['diff']); ?></span> seconds.</p>
				<p>Your slowest time to complete a call stands at <span class="highlight"><?php echo $call->secondsToTime($callFormattedResults['last']['diff']); ?></span>.</p>
				<p>There were <span class="highlight"><?php echo $nonCompleted['count']; ?></span> call/calls that could not be compared as they have not been completed yet.</p>
			</div>
		</div>
		<hr />
		<div class="row">
			<div class="col-sm-16 col-md-16 col-lg-16 graph">
				<?php
					$username = $_SESSION['login']['username'];
			    	require_once $root.'/pages/Admin/Stats/CompareGraph.php';
			    	echo "<hr />";
			    	require_once $root.'/pages/Admin/Stats/SingleBook.php';
			    	echo "<hr />";
			    	require_once $root.'/pages/Admin/Stats/SingleTypes.php';

				?>
			</div>
		</div>
		
		<br /><br />
	</div>
	<div class="col-sm-2 col-md-2 col-lg-2"></div>
</div>

<script type="text/javascript" src="/assets/js/highstocks/js/highstock.js"></script>
<script type="text/javascript" src="/assets/js/highcharts/js/modules/exporting.js"></script>

<?php
if($_SESSION['login']['branchID'] == 27 ) {
    require_once $root.'/pages/footer.php';
}
?>