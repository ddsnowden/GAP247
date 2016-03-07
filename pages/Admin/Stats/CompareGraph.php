<?php
if(isset($post)) {
	foreach ($post as $key => $value) {
	  	if($key == "submit") continue;
	  	$username[] = $value;
	}
}

$dates = $staff->collectDates($DBH);
$JQ = '';
if(is_array($username)) {
	foreach ($username as $key) {
		$allStaffTotals = $staff->STCalls($DBH, $dates, $key);

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
	        data: '.$allStaffTotals.',
	        pointStart: Date.UTC(2015, 3, 1),
	        pointInterval: 24 * 3600 * 1000,

	    	},';

	    }
	}
	else {
		$allStaffTotals = $staff->STCalls($DBH, $dates, $username);

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
	        name: "Total Calls for '.$username.'",
	        data: '.$allStaffTotals.',
	        pointStart: Date.UTC(2015, 3, 1),
	        pointInterval: 24 * 3600 * 1000,

	    	},';
	}

$JQ = rtrim($JQ, ",");
?>
<script src="/assets/js/custom/commonScripts.js"></script>
<div id="graphs" style="height: 600px"></div>
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
	                text: "Total Daily Calls for <?php if(is_array($username)) { echo 'Nightline';} else echo $username; ?>"
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