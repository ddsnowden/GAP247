<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root.'/pages/header.php';
    
    include $root.'/assets/php/auth/branchUsers.php';

	require_once $root.'/assets/php/class/stats/Totals.class.php';

	$calls = new Totals(); 
	$dates = $calls->collectDates($DBH);

	$months = $calls->months($DBH);
	$total = $calls->monthlyTotals($DBH, $months);
	$clientTotals = $calls->clientMonthlyTotals($DBH, $months);
	$tempTotals = $calls->tempMonthlyTotals($DBH, $months);
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
				<div id="graphs"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-16 col-md-16 col-lg-16 graph">
				<div id="totalsGraphs"></div>
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
	        $('#graphs').highcharts('StockChart', {
	            chart: {
	                events: {
	                    load: function(chart) {
	                        this.setTitle(null, {
	                            text: 'Built chart at '+ (new Date() - start) +'ms'
	                        });
	                    }
	                },
	                zoomType: 'x'
	            },
	            
	            rangeSelector: {
	                buttons: [{
	                    type: 'day',
	                    count: 3,
	                    text: '3d'
	                }, {
	                    type: 'week',
	                    count: 1,
	                    text: '1w'
	                }, {
	                    type: 'month',
	                    count: 1,
	                    text: '1m'
	                }, {
	                    type: 'month',
	                    count: 6,
	                    text: '6m'
	                }, {
	                    type: 'year',
	                    count: 1,
	                    text: '1y'
	                }, {
	                    type: 'all',
	                    text: 'All'
	                }],
	                selected: 3
	            },
	            xAxis: {
	                type: 'datetime',
	                maxZoom: 5
	            },
	            yAxis: {
	                title: {
	                    text: 'Call Count'
	                },
	                min: 0 // this sets minimum values of y to 0
	            },

	            title: {
	                text: 'Total Daily Calls for Nightline'
	            },

	            subtitle: {
	                text: 'Built chart at...' // dummy text to reserve space for dynamic subtitle
	            },

	            series: [{
	                tooltip: {
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
	                    valueSuffix: ' Calls',
	                    
	                },
	                name: 'Total Calls',
	                data: <?php echo $calls->calls($DBH, $dates); ?>,
	                pointStart: Date.UTC(2015, 3, 1),
	                pointInterval: 24 * 3600 * 1000,

	            },
	            {
	                tooltip: {
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
	                    valueSuffix: ' Calls',
	                    
	                },
	                name: 'Total Temp Calls',
	                data: <?php echo $calls->tempCalls($DBH, $dates); ?>,
	                pointStart: Date.UTC(2015, 3, 1),
	                pointInterval: 24 * 3600 * 1000,

	            },
	            {
	                tooltip: {
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
	                    valueSuffix: ' Calls',
	                    
	                },
	                name: 'Total Client Calls',
	                data: <?php echo $calls->clientCalls($DBH, $dates); ?>,
	                pointStart: Date.UTC(2015, 3, 1),
	                pointInterval: 24 * 3600 * 1000,
	            }]
	  			});
			
				var totalCalls = new Highcharts.Chart({  //Totals for year chart
			            chart: { 
			            	events: {
			                    load: function(chart) {
			                        this.setTitle(null, {
			                            text: 'Built chart at '+ (new Date() - start) +'ms'
			                        });
			                    }
			                },
			              marginBottom: 120,
			              renderTo : 'totalsGraphs',
			              type: 'line',
			              backgroundColor: 'rgba(255, 255, 255, 1)'
			            },
			            title: {
			              text: 'Call Statistics Last Two Years',
			              style: {
			                color: 'black'
			              },
			              x: -20 //center
			            },
			            subtitle: {
			              text: 'Source: Nightline Server',
			              style: {
			                color: 'black'
			              },
			              x: -20
			            },
			            legend: {
			              itemStyle: {
			                color: 'black'
			              },
			            },
			            xAxis: {
			              tickInterval: 1,

			                categories: [<?php 
			                	foreach ($months as $key) {
							      $month[] = $key['yearMonth'];
							    }

							    $result = "'".join("','", $month)."'";
							    echo $result;
							     ?>], /*As the php array contains strings add a single speech mark to the beginning and end */
			                labels: {
			                  rotation: -45,
			                style: {
			                  color: 'black'
			                }
			              }
			            },
			            yAxis: {
			              labels: {
			                  style: {
			                      color: 'rgba(0, 0, 0, 1)'
			                  }
			              },
			              title: {
			                text: 'Total Calls',
			                style: {
			                  color: 'rgba(0, 0, 0, 1)'
			                  },
			              },
			              plotLines: [{
			                value: 0,
			                width: 1,
			                color: '#808080'
			              }]
			            },
			            credits: {
			              enabled: false
			            },
			            series: [{
			            name: 'Total Calls',
			            color: 'rgb(255,0,0)',
			            data: [<?php echo $total; ?>],
			            tooltip: {
			              valueSuffix: ' Calls'
			              },
			            },{
			            name: 'Total Client',
			            color: 'rgb(0,255,0)',
			            data: [<?php echo $clientTotals; ?>],
			            tooltip: {
			              valueSuffix: ' Calls'
			              },
			            },{
			            name: 'Total Temp',
			            color: 'rgb(0,0,255)',
			            data: [<?php echo $tempTotals; ?>],
			            tooltip: {
			              valueSuffix: ' Calls'
			              }
			            }]
			        });  /* End of Client calls chart */
				});
</script>

<script type="text/javascript" src="/assets/js/highstocks/js/highstock.js"></script>
<script type="text/javascript" src="/assets/js/highcharts/js/modules/exporting.js"></script>

<?php
if($_SESSION['login']['branchID'] == 27 ) {
    require_once $root.'/pages/footer.php';
}
?>