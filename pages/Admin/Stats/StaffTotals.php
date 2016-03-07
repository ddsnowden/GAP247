<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root.'/pages/header.php';
    
    include $root.'/assets/php/auth/branchUsers.php';

	require_once $root.'/assets/php/class/stats/Totals.class.php';
	require_once $root.'/assets/php/class/stats/StaffTotals.class.php';

	$staff = new StaffTotal();
    

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
		<div id="callSelect">
			<?php include $root.'/pages/Admin/statsLinks.html'; ?>
		</div>
		<div class="row">
			<div class="col-sm-16 col-md-16 col-lg-16 graph">
				<?php
			    	if(isset($_POST['submit'])) {

			    		$post = $_POST;

			    		if(count($post) == 2) { //Single User
			    			require_once $root.'/pages/Admin/Stats/CompareGraph.php';
			    			require_once $root.'/pages/Admin/Stats/SingleBook.php';
			    			require_once $root.'/pages/Admin/Stats/SingleTypes.php';
			    		}
			    		else { //Multiple users
			    			require_once $root.'/pages/Admin/Stats/CompareGraph.php';
			    		}
						?>

				        
				        <?php
					} else {
			            $staffList = $staff->staffList($DBH);
				        ?>
				        <div id="branchSelect">
					    	<form action="" method="POST">
					    		<?php
					    		foreach ($staffList as $key) { ?>
					    			<input type="checkbox" name="<?php echo $key['username']; ?>" value="<?php echo $key['username']; ?>" /><span class="branchSelectName"><?php echo $key['username']; ?>: </span><br />
					    		<?php }
					    		?>
					    		
								<div class="col-sm-2">
				                   <button name="submit" type="submit" class="btn btn-primary">Submit</button>
				                </div>
				                
							</form>
						</div>
				<?php
					}
				?>
			</div>
		</div>
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