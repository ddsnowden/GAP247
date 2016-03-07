<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';
require_once $root.'/pages/header.php';
include $root.'/assets/php/auth/branchUsers.php';
require_once $root.'/assets/php/class/stats/Emails.class.php';
require_once $root.'/assets/php/class/stats/CallComplete.class.php';

//include $root.'/kint/Kint.class.php';

$email = new Email();
$call = new Calls();

$emailData = $email->emailStats($DBH);
$callData = $call->callstats($DBH);

$emailFormattedResults = $email->format($DBH, $emailData);
$callFormattedResults = $call->format($DBH, $callData);

$nonEmailed = $email->nonEmailed($DBH);

$nonCompleted = $call->nonCompleted($DBH);
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
			<div class="col-sm-16 col-md-16 col-lg-16 emailStats">
				<p>The total number of calls compared for this result is <span class="highlight"><?php echo $emailFormattedResults['count']; ?></span>.</p>
				<p>The average time between call completion and emailing is <span class="highlight"><?php echo $email->secondsToTime($emailFormattedResults['diff']); ?></span> seconds.</p>
				<p>The slowest emailed call stands at <span class="highlight"><?php echo $email->secondsToTime($emailFormattedResults['last']['diff']); ?></span> seconds by <?php echo htmlspecialchars($emailFormattedResults['last']['username'], ENT_QUOTES); ?>.</p>
				<p>There were <span class="highlight"><?php echo $nonEmailed['count']; ?></span> call/calls that could not be compared as they have not been emailed yet.</p>
			</div>
		</div>
		<br /><br />
		<hr />
		<div class="row">
			<div class="col-sm-16 col-md-16 col-lg-16 emailStats">
				<p>The total number of calls compared for this result is <span class="highlight"><?php echo $callFormattedResults['count']; ?></span>.</p>
				<p>The average time between call a call being initiated and completed is <span class="highlight"><?php echo $call->secondsToTime($callFormattedResults['diff']); ?></span> seconds.</p>
				<p>The slowest time to complete a call stands at <span class="highlight"><?php echo $call->secondsToTime($callFormattedResults['last']['diff']); ?></span> seconds by <?php echo htmlspecialchars($emailFormattedResults['last']['username'], ENT_QUOTES); ?>.</p>
				<p>There were <span class="highlight"><?php echo $nonCompleted['count']; ?></span> call/calls that could not be compared as they have not been completed yet.</p>
			</div>
		</div>
		<br /><br />
		<hr />
		<div class="row">
			<div class="col-sm-16 col-md-16 col-lg-16 emailStats">
				<div id="container" style="min-width: 310px; max-width: 1400px; height: 800px; margin: 0 auto"></div>
			</div>
		</div>
		<br /><br />
		<hr />
		<div class="row">
			<div class="col-sm-16 col-md-16 col-lg-16 emailStats">
				<div id="container2" style="min-width: 310px; max-width: 1400px; height: 800px; margin: 0 auto"></div>
			</div>
		</div>
		<br /><br />
	</div>
	<div class="col-sm-2 col-md-2 col-lg-2"></div>
</div>

<script type="text/javascript" src="/assets/js/highstocks/js/highstock.js"></script>
<script type="text/javascript" src="/assets/js/highcharts/js/modules/exporting.js"></script>



<script type="text/javascript">
	$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Average Length of Time Between Call Initiation and Completion'
        },
        subtitle: {
           // text: 'Source: <a href="http://en.wikipedia.org/wiki/List_of_cities_proper_by_population">Wikipedia</a>'
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -45,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            title: {
                text: 'Time (hh:mm)'
            },
            labels: {
                formatter: function () {
                    var time = this.value;
                    var hours1=parseInt(time/3600000);
                    var mins1=parseInt((parseInt(time%3600000))/60000);
                    return hours1 + ':' + mins1;
                }
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            formatter: function() {
                            return '<b>'+ this.key +'</b><br/>'+
                            Highcharts.dateFormat('%H', this.y)+' hours '+Highcharts.dateFormat('%M', this.y)+' minutes';
                    }
        },
        series: [{
            name: 'Time taken between initation and completion',
            data: <?php echo json_encode($call->perBranch($DBH)); ?>,
            
        }]
    });
});
</script>

<script type="text/javascript">
	$(function () {
    $('#container2').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Average Length of Time Between Call Initiation and Completion'
        },
        subtitle: {
           // text: 'Source: <a href="http://en.wikipedia.org/wiki/List_of_cities_proper_by_population">Wikipedia</a>'
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -45,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            title: {
                text: 'Time (hh:mm)'
            },
            labels: {
                formatter: function () {
                    var time = this.value;
                    var hours1=parseInt(time/3600000);
                    var mins1=parseInt((parseInt(time%3600000))/60000);
                    return hours1 + ':' + mins1;
                }
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            formatter: function() {
                            return '<b>'+ this.key +'</b><br/>'+
                            Highcharts.dateFormat('%H', this.y)+' hours '+Highcharts.dateFormat('%M', this.y)+' minutes '+Highcharts.dateFormat('%S', this.y)+' seconds';
                    }
        },
        series: [{
            name: 'Time taken between initation and completion',
            data: <?php echo json_encode($call->perPerson($DBH)); ?>,
            
        }]
    });
});
</script>


<?php
if($_SESSION['login']['branchID'] == 27 ) {
    require_once $root.'/pages/footer.php';
}
?>