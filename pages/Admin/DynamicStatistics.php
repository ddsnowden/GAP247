<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root.'/pages/header.php';
    
    include $root.'/assets/php/auth/branchUsers.php';

	require_once $root.'/assets/php/class/stats/Totals.class.php';

	$totals = new Totals();
?>
<!-- Start Open Web Analytics Tracker -->
<script type="text/javascript">
//<![CDATA[
var owa_baseUrl = 'http://localhost/assets/Open-Web-Analytics/';
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
<div class="row form">
	<div class="col-sm-2 col-md-2 col-lg-2"></div>
	<div class="col-sm-12 col-md-12 col-lg-12" style="text-align: center;">
		<div id="callSelect">
			<?php include 'statsLinks.html'; ?>
		</div>
		<div id="running">
			<h1><?php $totals = new Totals(); $running = $totals->serverRunning($DBH); echo "The server has been running for ".$running['days']." days"; ?></h1>
		</div>
	</div>
	<div class="col-sm-2 col-md-2 col-lg-2"></div>
</div>

<?php
if($_SESSION['login']['branchID'] == 27 ) {
    require_once $root.'/pages/footer.php';
}
?>