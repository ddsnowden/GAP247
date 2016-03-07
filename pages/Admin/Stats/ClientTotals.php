<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root.'/pages/header.php';
    
    include $root.'/assets/php/auth/branchUsers.php';

	require_once $root.'/assets/php/class/stats/TypeTotals.class.php';

    $calls = new TypeTotals();
	$dates = $calls->collectDates($DBH);

	$bookings = $calls->booked($DBH);
	$noShow = $calls->noShow($DBH);

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
				<div id="bar"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-16 col-md-16 col-lg-16 graph">
				<div id="bar2"></div>
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
	            credits: {
	              enabled: false
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
	                name: 'Total Client Calls',
	                data: <?php echo $calls->clientCalls($DBH, $dates); ?>,
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
	                name: 'Total Booking Calls',
	                data: <?php echo $calls->typeTotal($DBH, $dates, "bookings"); ?>,
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
	                name: 'Total Cancellation Calls',
	                data: <?php echo $calls->typeTotal($DBH, $dates, "Cancellations"); ?>,
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
	                name: 'Total Checkin Calls',
	                data: <?php echo $calls->typeTotal($DBH, $dates, "checkins_complete"); ?>,
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
	                name: 'Total Head Office Calls',
	                data: <?php echo $calls->typeTotal($DBH, $dates, "head office client call"); ?>,
	                pointStart: Date.UTC(2015, 3, 1),
	                pointInterval: 24 * 3600 * 1000,

	            }]

	        });
	    
	var bookFilled = new Highcharts.Chart({
            chart: { 
              renderTo : 'bar',
              type: 'bar',
              backgroundColor: 'rgba(0,0,0,0)'
            },
            title: {
              text: 'Booking Quantity and Filled for the Year',
              style: {
                color: 'white'
              },
              x: -20 //center
            },
            subtitle: {
              text: 'Source: Nightline Server',
              style: {
                color: 'white'
              },
              x: -20
            },
            legend: {
              itemStyle: {
                color: 'white'
              },
            },
            xAxis: {
              categories: ['Bookings'], /*As the php array contains strings add a single speech mark to the beginning and end */
              labels: {
                style: {
                  color: 'white'
                }
              }
            },
            yAxis: {
              min: 0,
              labels: {
                style: {
                  color: 'rgba(255,255,255,1)'
                }
              },
              title: {
                text: 'Total Calls',
                style: {
                  color: 'rgba(255,255,255,1)'
                }
              },
              plotOptions: {
                bar: {
                  dataLabels: {
                    enabled: true
                  }
                }
              }
            },
            credits: {
              enabled: false
            },
            series: [{
              name: 'Booked',
              data: [<?php echo $bookings[0]['booked']; ?>]
            }, {
            name: 'Filled',
            data: [<?php echo $bookings[0]['filled']; ?>]
          }]
        }); 

	var bookFilled = new Highcharts.Chart({
            chart: { 
              renderTo : 'bar2',
              type: 'bar',
              backgroundColor: 'rgba(0,0,0,0)'
            },
            title: {
              text: 'No Show Quantity and Filled for the Year',
              style: {
                color: 'white'
              },
              x: -20 //center
            },
            subtitle: {
              text: 'Source: Nightline Server',
              style: {
                color: 'white'
              },
              x: -20
            },
            legend: {
              itemStyle: {
                color: 'white'
              },
            },
            xAxis: {
              categories: ['No Show'], /*As the php array contains strings add a single speech mark to the beginning and end */
              labels: {
                style: {
                  color: 'white'
                }
              }
            },
            yAxis: {
              min: 0,
              labels: {
                style: {
                  color: 'rgba(255,255,255,1)'
                }
              },
              title: {
                text: 'Total Calls',
                style: {
                  color: 'rgba(255,255,255,1)'
                }
              },
              plotOptions: {
                bar: {
                  dataLabels: {
                    enabled: true
                  }
                }
              }
            },
            credits: {
              enabled: false
            },
            series: [{
              name: 'No Show Quantity',
              data: [<?php echo $noShow[0]['noQuant']; ?>]
            }, {
            name: 'No Show Filled',
            data: [<?php echo $noShow[0]['filled']; ?>]
          }]
        });  /* End of booked filled chart */
});
	</script>

<script type="text/javascript" src="/assets/js/highstocks/js/highstock.js"></script>
<script type="text/javascript" src="/assets/js/highcharts/js/modules/exporting.js"></script>

<?php
if($_SESSION['login']['branchID'] == 27 ) {
    require_once $root.'/pages/footer.php';
}
?>