<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root.'/pages/header.php';
    
    include $root.'/assets/php/auth/branchUsers.php';
?>
<script src="/assets/js/custom/commonScripts.js"></script>
<!-- Start main content of the page -->
<div class="row">
	<div class="col-sm-1 col-md-1 col-lg-1"></div>
	<div class="col-sm-14 col-md-14 col-lg-14">
		<iframe id="calendar" src="/assets/phpCal/"></iframe>
	</div>
	<div class="col-sm-1 col-md-1 col-lg-1"></div>
</div>
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
<?php
if($_SESSION['login']['branchID'] == 27 ) {
	require_once $root.'/pages/footer.php';
}
?>