<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root.'/pages/header.php';
    
    include $root.'/assets/php/auth/branchUsers.php';

	require_once $root.'/assets/php/class/stats/Totals.class.php';
	require_once $root.'/assets/php/class/stats/TypeTotals.class.php';
	require_once $root.'/assets/php/class/Staff.class.php';
	require_once $root.'/assets/php/class/stats/BranchTotals.class.php';

	$calls = new BranchTotals(); 
	$dates = $calls->collectDates($DBH);
	$branches = $calls->branches($DBH);
	$percentTotals = $calls->percentTotals($DBH);
	$totalCalls = '';

	$calls2 = new TypeTotals();
	$types = $calls2->types($DBH);
	$result = $calls2->branchType($DBH, $branches);

	$staffCalls = new Staff();
	$sTotals = $staffCalls->staffTotals($DBH);

	$hTotal = $calls2->hourlyTotals($DBH);

	for ($i=0; $i < 24; $i++) { 
	  $hour[] = array('hour' => $i);
	}
	$hType = $calls2->hourlyType($DBH, $hour);
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
				<div id="pie2">
					<?php
						foreach ($percentTotals as $key) {
							$totalCalls += (int)$key['count'];
						}
						foreach ($percentTotals as $key) {
							$pie2[] = '{name: "'.$key['branchName'].'", y:'.substr(((((int)$key['count']) / $totalCalls)*100), 0, 4).', drilldown: "'.$key['branchName'].'"}';
						}
					?>
	            </div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-16 col-md-16 col-lg-16 graph">
				<div id="hourBar">
					<?php 
						$hourData = '';
						foreach ($hTotal as $key) {
							$hourData .= "{name: '".$key['hour']."', y: ".$key['count'].", drilldown: '".$key['hour']."'}, ";
						}
						$hourData = rtrim($hourData,',');

					?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-5 col-md-5 col-lg-5 graph tablestats">
        <div id="tablestatsOne">
  				<table>
  					<th>Staff Name</th><th>Call %</th><th>Total Calls</th>
  					<?php foreach ($sTotals as $key) { ?>
  					<tr>
  						<td><?php echo $key['username']; ?></td><td><?php echo substr(((((int)$key['count']) / $totalCalls)*100), 0, 4); ?>%</td><td><?php echo $key['count'];?> calls.</td>
  					</tr>
  					<?php } ?>
  				</table>
        </div>
			</div>
			<div class="col-sm-6 col-md-6 col-lg-6 graph tablestats">
        <div id="tablestatsTwo">
  				<table>
  					<th>Branch</th><th>Call %</th><th>Total Calls</th>
  					<?php
  					foreach ($percentTotals as $key) {
  						$pie[] = '{name: "'.$key['branchName'].'", y:'.substr(((((int)$key['count']) / $totalCalls)*100), 0, 4).'}';
  					?>
  					<tr>
  						<td><?php echo $key['branchName']; ?></td><td><?php echo substr(((((int)$key['count']) / $totalCalls)*100), 0, 4); ?>%</td><td><?php echo $key['count'];?> calls.</td>
  					</tr>
  					<?php } ?>
  				</table>
        </div>
			</div>
				
			<div class="col-sm-5 col-md-5 col-lg-5 graph tablestats">
        <div id="tablestatsThree">
  				<table>
  				<th>Call Type</th><th>Call %</th><th>Total Calls</th>
  				<?php foreach ($types as $key) { ?>
  				<tr>
  					<td><?php echo ucwords($key['type']); ?></td><td><?php echo substr(((((int)$key['count']) / $totalCalls)*100), 0, 4); ?>%</td><td><?php echo $key['count'];?> calls.</td>
  				</tr>
  				<?php } ?>
  				</table>
        </div>
			</div>
		</div>


	</div>
	<div class="col-sm-2 col-md-2 col-lg-2"></div>
</div>

<script type="text/javascript">
    $(function () {

    // Radialize the colors
    Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: {
                cx: 0.5,
                cy: 0.3,
                r: 0.7
            },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
            ]
        };
    });
  });
  </script>
<!--  Pie2 -->
  <script type="text/javascript">
    $(function () {
      // Create the chart
      $('#pie2').highcharts({
          chart: {
              type: 'pie'
          },
          title: {
              text: 'Drilldown statistics for all branches.'
          },
          subtitle: {
              text: 'Total calls for all branches is ' + <?php echo $totalCalls; ?> + ' calls.'
          },
          plotOptions: {
              series: {
                  dataLabels: {
                      enabled: true,
                      format: '{point.name}: {point.y:.1f}'
                  }
              }
          },

          tooltip: {
              headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
              pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> of total<br/>'
          },
          series: [{
              name: 'Percentage of calls for each branch',
              colorByPoint: true,
              data: [
                <?php 
                  $text = '';
                  foreach ($pie2 as $key) {
                    $text .= $key.',';
                  }
                  $text = rtrim($text,',');
                  echo $text;
                ?>
              ]
          }],
          drilldown: {
              series: [<?php echo $result; ?> {
                  
              }]
          }
      });
  });
  </script>

  <script type="text/javascript">
    $(function () {
      // Create the chart
      $('#hourBar').highcharts({
          chart: {
              type: 'column'
          },
          title: {
              text: 'Hourly call breakdown for Nightline'
          },
          subtitle: {
              text: 'Total calls for all branches is ' + <?php echo $totalCalls; ?> + ' calls.'
          },
          xAxis: {
              type: 'category'
          },
          yAxis: {
              title: {
                  text: 'Total calls'
              }

          },
          legend: {
              enabled: false
          },
          plotOptions: {
              series: {
                  borderWidth: 0,
                  dataLabels: {
                      enabled: true,
                      format: '{point.y:.1f}'
                  }
              }
          },

          tooltip: {
              headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
              pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> of total<br/>'
          },

          series: [{
              name: 'Hour',
              colorByPoint: true,
              data: [<?php echo $hourData; ?>]
          }],
          drilldown: {
              series: [<?php echo $hType; ?>]
          }
      });
  });
  </script>

<script type="text/javascript" src="/assets/js/highstocks/js/highstock.js"></script>
<script type="text/javascript" src="/assets/js/highcharts/js/modules/drilldown.js"></script>
<script type="text/javascript" src="/assets/js/highcharts/js/modules/exporting.js"></script>