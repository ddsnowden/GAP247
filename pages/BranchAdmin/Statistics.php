<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once $root.'/pages/header.php';

	include $root.'/assets/php/auth/remoteUsers.php';

	require_once $root.'/assets/php/class/CallData.class.php';
	require_once $root.'/assets/php/class/Branches.class.php';

	$calldata = new CallData();
	$branch = new Branches();
	$branch = $branch->branchDetailsID($DBH, $_SESSION['login']['branchID']);
?>
<!-- Load common scripts and call specific scripts -->
<script src="/assets/js/custom/commonScripts.js"></script>
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
  <div class="col-sm-16 col-md-16 col-lg-16">
    <div id="branchStats">
      <h1>Calls Statistics for <?php echo $branch['branchName']; ?></h1>
      <p>Here you will find statistics collected by the GAP24/7 regarding the calls recorded for your branch.  <br />The calls are displayed along with GAP24/7's totals.  <br />You are able to filter the graphs by selecting the labels under the graphs to toggle thier display state.</p>
      <hr />
  </div>
</div>
<div class="row">
	<div class="col-sm-2 col-md-2 col-lg-2"></div>
	
	<div class="col-sm-12 col-md-12 col-lg-12">
		<div id="tempCallsMonth" style="width: 1200px; height: 800px;  margin: 0 auto;"></div>
      	<hr class="dashed" />
	</div>
	<div class="col-sm-2 col-md-2 col-lg-2"></div>
</div>

<div class="row">
	<div class="col-sm-2 col-md-2 col-lg-2"></div>

	<div class="col-sm-12 col-md-12 col-lg-12">
		<div id="clientCallsMonth" style="width: 1200px; height: 800px;  margin: 0 auto;"></div>
	      <br />
	      <hr class="dashed" />
	</div>
	<div class="col-sm-2 col-md-2 col-lg-2"></div>
</div>

<div class="row">
	<div class="col-sm-2 col-md-2 col-lg-2"></div>

	<div class="col-sm-6 col-md-6 col-lg-6">
		<div id="bookFilled" style="width: 550px; height: 400px;  float: left;"></div>
	</div>
	<div class="col-sm-6 col-md-6 col-lg-6">
		<div id="noShow" style="width: 550px; height: 400px;  float: right;"></div>
	</div>
	<div class="col-sm-2 col-md-2 col-lg-2"></div>
</div>

<div class="row">
	<div class="col-sm-2 col-md-2 col-lg-2"></div>

	<div class="col-sm-12 col-md-12 col-lg-12">
		<hr class="dashed" />
      	<div id="totalsYear" style="width: 1600px; height: auto;  margin: 0 auto;"></div>
	</div>
	<div class="col-sm-2 col-md-2 col-lg-2"></div>
</div>

<script type="text/javascript">
	
$(function () {
    var chart;
    $(document).ready(function() {
    var tempCalls = new Highcharts.Chart({  //Temp calls
        chart: { 
          renderTo : 'tempCallsMonth',
          type: 'line',
          backgroundColor: 'rgba(0,0,0,0)'
        },
        title: {
          text: 'Temp Call Statistics This Month',
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
          categories: [<?php echo $calldata->daysJoined($DBH); ?>], /*As the php array contains strings add a single speech mark to the beginning and end */
          labels: {
            style: {
              color: 'white'
            }
          }
        },
        yAxis: {
          labels: {
              style: {
                  color: 'rgba(255,255,255,1)'
              }
          },
          title: {
            text: 'Total Calls',
            style: {
              color: 'rgba(255,255,255,1)'
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
        name: 'Total Temp Calls Taken By Nightline',
        color: 'rgb(255,0,0)',
        data: [<?php echo $calldata->tempTotal($DBH); ?>],
        tooltip: {
          valueSuffix: ' Calls'
          },
        },{
        name: 'Pay Queries',
        color: 'rgb(255,255,255)',
        data: [<?php echo $calldata->pay($DBH, $_SESSION['login']['branchID']); ?>],
        tooltip: {
          valueSuffix: ' Calls'
          },
        },{
        name: 'Matalan',
        color: 'rgb(0,0,255)',
        data: [<?php echo $calldata->matalan($DBH, $_SESSION['login']['branchID']); ?>],
        tooltip: {
          valueSuffix: ' Calls'
          },
        },{
        name: 'Sick',
        color: 'rgb(0,255,255)',
        data: [<?php echo $calldata->sick($DBH, $_SESSION['login']['branchID']); ?>],
        tooltip: {
          valueSuffix: ' Calls'
          },
        },{
        name: 'Temp Issue',
        color: 'rgb(255,255,0)',
        data: [<?php echo $calldata->tempIssue($DBH, $_SESSION['login']['branchID']); ?>],
        tooltip: {
          valueSuffix: ' Calls'
        }
      }]
    });  /* End of Temp calls chart */
    
    var clientCalls = new Highcharts.Chart({  //Client Chart
        chart: { 
          renderTo : 'clientCallsMonth',
          type: 'line',
          backgroundColor: 'rgba(0,0,0,0)'
        },
        title: {
          text: 'Client Call Statistics This Month',
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
          categories: [<?php echo $calldata->daysJoined($DBH); ?>], /*As the php array contains strings add a single speech mark to the beginning and end */
          labels: {
            style: {
              color: 'white'
            }
          }
        },
        yAxis: {
          labels: {
              style: {
                  color: 'rgba(255,255,255,1)'
              }
          },
          title: {
            text: 'Total Calls',
            style: {
              color: 'rgba(255,255,255,1)'
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
        name: 'Total Client Calls Taken By Nightline',
        color: 'rgb(255,0,0)',
        data: [<?php echo $calldata->clientTotal($DBH); ?>],
        tooltip: {
          valueSuffix: ' Calls'
          },
        },{
        name: 'Bookings',
        color: 'rgb(255,255,255)',
        data: [<?php echo $calldata->bookings($DBH, $_SESSION['login']['branchID']); ?>],
        tooltip: {
          valueSuffix: ' Calls'
          },
        },{
        name: 'Cancellations',
        color: 'rgb(0,0,255)',
        data: [<?php echo $calldata->cancel($DBH, $_SESSION['login']['branchID']); ?>],
        tooltip: {
          valueSuffix: ' Calls'
          },
        },{
        name: 'No Show',
        color: 'rgb(0,255,255)',
        data: [<?php echo $calldata->noShow($DBH, $_SESSION['login']['branchID']); ?>],
        tooltip: {
          valueSuffix: ' Calls'
          },
        },{
        name: 'Client Issue',
        color: 'rgb(255,255,0)',
        data: [<?php echo $calldata->clientOther($DBH, $_SESSION['login']['branchID']); ?>],
        tooltip: {
          valueSuffix: ' Calls'
        }
      }]
    });  /* End of Client calls chart */

    var totalCalls = new Highcharts.Chart({  //Totals for year chart
        chart: { 
          marginBottom: 120,
          renderTo : 'totalsYear',
          type: 'line',
          backgroundColor: 'rgba(0,0,0,0)'
        },
        title: {
          text: 'Call Statistics Last Two Years',
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
          tickInterval: 1,

            categories: [<?php echo $calldata->monthsJoined($DBH); ?>], /*As the php array contains strings add a single speech mark to the beginning and end */
            labels: {
              rotation: -45,
            style: {
              color: 'white'
            }
          }
        },
        yAxis: {
          labels: {
              style: {
                  color: 'rgba(255,255,255,1)'
              }
          },
          title: {
            text: 'Total Calls',
            style: {
              color: 'rgba(255,255,255,1)'
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
        name: 'Total Calls Taken By Nightline',
        color: 'rgb(255,0,0)',
        data: [<?php echo $calldata->twoYearTotal($DBH); ?>],
        tooltip: {
          valueSuffix: ' Calls'
          },
        },{
        name: 'Total Client',
        color: 'rgb(255,255,255)',
        data: [<?php echo $calldata->twoYearClientTotal($DBH, $_SESSION['login']['branchID']); ?>],
        tooltip: {
          valueSuffix: ' Calls'
          },
        },{
        name: 'Total Temp',
        color: 'rgb(0,0,255)',
        data: [<?php echo $calldata->twoYearTempTotal($DBH, $_SESSION['login']['branchID']); ?>],
        tooltip: {
          valueSuffix: ' Calls'
          }
        }]
    });  /* End of Client calls chart */

   var bookFilled = new Highcharts.Chart({
        chart: { 
          renderTo : 'bookFilled',
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
          data: [<?php $booked = $calldata->bookFillTotals($DBH, $_SESSION['login']['branchID']); echo $booked[0]['booked']; ?>]
        }, {
        name: 'Filled',
        data: [<?php echo $booked[0]['filled']; ?>]
      }]
    });  /* End of booked filled chart */

    var noshow = new Highcharts.Chart({
        chart: { 
          renderTo : 'noShow',
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
          name: 'Booked',
          data: [<?php $noshow = $calldata->noshowFillTotals($DBH, $_SESSION['login']['branchID']); echo $noshow[0]['noQuant']; ?>]
        }, {
        name: 'Filled',
        data: [<?php echo $noshow[0]['filled']; ?>]
      }]
    });  /* End of booked filled chart */
  }); /* End onDocument Start */
}); /* End Function */

</script>
<script type="text/javascript" src="/assets/js/highcharts/js/highcharts.js"></script>
<script type="text/javascript" src="/assets/js/highcharts/js/modules/exporting.js"></script>