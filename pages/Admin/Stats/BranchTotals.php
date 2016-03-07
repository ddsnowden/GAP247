<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root.'/pages/header.php';
    
    include $root.'/assets/php/auth/branchUsers.php';

	require_once $root.'/assets/php/class/stats/Totals.class.php';
	require_once $root.'/assets/php/class/stats/TypeTotals.class.php';
	require_once $root.'/assets/php/class/stats/BranchTotals.class.php';

	$branch = new BranchTotals(); 
    $calls = new TypeTotals(); 
    $dates = $calls->collectDates($DBH);

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

					foreach ($post as $key => $value) {
					  	if($key == "submit") continue;
					  	$branches[] = $value;
					}

			    	
			        
		            
		            $dates = $calls->collectDates($DBH);
		            $JQ = '';
		            foreach ($branches as $key) {
		            	//echo $key['branchName'];
		            	$allBranchTotals = $branch->bTotals($DBH, $dates, $key);

			            $JQ .= '{ tooltip: {
			                    enabled: true,
			                    dateTimeLabelFormats: {
			                        millisecond:"%A, %b %e, %H:%M:%S.%L",
			                        second:"%A, %b %e, %H:%M:%S",
			                        minute:"%A, %b %e, %H:%M",
			                        hour:"%A, %b %e, %H:%M",
			                        day:"%A, %b %e, %Y",
			                        week:"Week from %A, %b %e, %Y",
			                        month:"%B %Y",
			                        year:"%Y"
			                    },
			                    valueDecimals: 1,
			                    valueSuffix: " Calls",
			                    
			                },
			                name: "Total Calls for '.$key.'",
			                data: '.$allBranchTotals.',
			                pointStart: Date.UTC(2015, 3, 1),
			                pointInterval: 24 * 3600 * 1000,

			            	},';

			            }

				            $JQ = rtrim($JQ, ",");
			        
			      
			      ?>
			      <div id="graphs" style="height: 600px;"></div>
			</div>
		</div>
	</div>
	<div class="col-sm-2 col-md-2 col-lg-2"></div>
</div>

<script type="text/javascript">
	$(function() {
	        // Create a timer
	        var start = + new Date();

	        // Create the chart
	        $("#graphs").highcharts("StockChart", {
	            chart: {
	                events: {
	                    load: function(chart) {
	                        this.setTitle(null, {
	                            text: "Built chart at "+ (new Date() - start) +"ms"
	                        });
	                    }
	                },
	                zoomType: "x"
	            },
	            credits: {
	              enabled: false
	            },
	            rangeSelector: {
	                buttons: [{
	                    type: "day",
	                    count: 3,
	                    text: "3d"
	                }, {
	                    type: "week",
	                    count: 1,
	                    text: "1w"
	                }, {
	                    type: "month",
	                    count: 1,
	                    text: "1m"
	                }, {
	                    type: "month",
	                    count: 6,
	                    text: "6m"
	                }, {
	                    type: "year",
	                    count: 1,
	                    text: "1y"
	                }, {
	                    type: "all",
	                    text: "All"
	                }],
	                selected: 3
	            },
	            xAxis: {
	                type: "datetime",
	                maxZoom: 5
	            },
	            yAxis: {
	                title: {
	                    text: "Call Count"
	                },
	                min: 0 // this sets minimum values of y to 0
	            },

	            title: {
	                text: "Total Daily Calls for Nightline"
	            },

	            subtitle: {
	                text: "Built chart at..." // dummy text to reserve space for dynamic subtitle
	            },
	            series: [
	            <?php echo $JQ; ?>
	            
	            ]

	        });
	    // });
	});
</script>

<script type="text/javascript" src="/assets/js/highstocks/js/highstock.js"></script>
<script type="text/javascript" src="/assets/js/highcharts/js/modules/exporting.js"></script>

 <?php
		} else {
		   
            $branches = $branch->branches($DBH);
	        ?>
	        <div id="branchSelect">
		    	<form action="" method="POST">
		    		<?php
		    		foreach ($branches as $key) { ?>
		    			<input type="checkbox" name="<?php echo $key['branchName']; ?>" value="<?php echo $key['branchName']; ?>" /><span class="branchSelectName"><?php echo $key['branchName']; ?>: </span><br />
		    		<?php }
		    		?>
		    		
					
					<div class="col-sm-2 col-md-2 col-lg-2"><button id="submit" name="submit" type="submit" class="btn btn-primary">Submit</button></div>
				</form>
			</div>
	<?php
		}
	?>
    </div>

<?php
if($_SESSION['login']['branchID'] == 27 ) {
    require_once $root.'/pages/footer.php';
}
?>