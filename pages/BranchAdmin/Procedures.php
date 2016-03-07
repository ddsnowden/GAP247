<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root.'/pages/header.php';
    
    include $root.'/assets/php/auth/remoteUsers.php';
    require_once $root.'/assets/php/class/Branches.class.php';

    $branch = new Branches();
?>
<!-- Load common scripts and call specific scripts -->
<script src="/assets/js/custom/commonScripts.js"></script>
<!-- <script src="/assets/js/custom/callScripts.js"></script> -->
<!-- <script src="/assets/js/custom/searching.js"></script> -->

<!--This script populates the form from the recall list-->
<script>
$(document).ready(function(){
	$('select[name=branchProc]').on('change', function() {var recallGet = this.options[this.selectedIndex].value
		$.ajax({                                     
			url: '/assets/php/branchadmin/procRecall.php',
			data: {recallGet: recallGet},
			type: 'GET',
			dataType: 'json',
			success: function(data)
			{
				if(data == 'success'){
    				location.reload();
				}
			}
		});
	});
});
</script>
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
<div class="row form">
	<div class="col-sm-3 col-md-3 col-lg-3">
		
			<?php 
			if(isset($_SESSION['login']['access']) && ($_SESSION['login']['access'] == 2)) { ?>
			<div class="col-sm-6 labright">
	            <label for="branch">Branch:</label>
	        </div>
	        <div class="col-sm-10">
	        <?php
				$branchList = $branch->branchList($DBH);
			?>
			<select id="branchProc" name='branchProc' class="form-control input" required>
				<option value="" <?=(isset($_SESSION['form']['branchNameShort']) && $_SESSION['form']['branchNameShort'] == '' ? 'selected' : '')?>></option>
			<?php
			foreach ($branchList as $key) { 
				$branchName = str_replace('_', ' ', $key['branchNameShort']);
			?>
				<option value="<?php echo $key['branchNameShort']; ?>" <?=(isset($_SESSION['form']['branchNameShort']) && $_SESSION['form']['branchNameShort'] == $key['branchNameShort'] ? 'selected' : '')?> ><?php echo ucwords($branchName); ?></option>
			<?php
			}
			?>
			</select>
			</div>
			<?php 
				} else {
					$branchProc = $branch->branchDetailsID($DBH, $_SESSION['login']['branchID']);
				}
			?>
		
	</div>
	
	<div class="col-sm-10 col-md-10 col-lg-10">
		<form style="float: left;padding-left: 50px;" action="/assets/php/branchadmin/ProcUpdate.php" method="POST">
			<input type="hidden" name="branch" value="<?php if(isset($_SESSION['form']['procEdit']['branch'])) echo $_SESSION['form']['procEdit']['branch']; ?>" />
			<style type="text/css">
				.tg  {border-collapse:collapse;border-spacing:0;border-color:#aabcfe;}
				.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aabcfe;color:#669;background-color:#e8edff;}
				.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aabcfe;color:#039;background-color:#b9c9fe;}
				.tg .tg-s6z2{text-align:center}
				.tg .tg-vn4c{background-color:#D2E4FC}
				.vert {vertical-align: middle;}
				table th {text-align: center;}
				.proc {min-width: 800px; height: 100px;}
				textarea.form-control {min-height: 200px;}
			</style>
			<div>
				<table class="tg">
				<th colspan="2"><h1><?php if(isset($_SESSION['form']['procEdit']['branchName'])) {echo $_SESSION['form']['procEdit']['branchName'];} elseif (isset($branchProc['branchName'])) {echo $branchProc['branchName'];}  ?></h1></th>
				  <tr>
				    <th class="tg-s6z2">Type of call</th>
				    <th class="tg-031e">Procedure</th>
				  </tr>
				  <tr>
				    <td class="tg-031e vert">Adverts</td>
				    <td class="tg-031e" style="width: 810px">
				    	<textarea class="form-control input proc" name="advert"><?php if (isset($branchProc['advert'])) {echo $branchProc['advert'];} elseif (isset($_SESSION['form']['procEdit'])) {echo $_SESSION['form']['procEdit']['advert'];}  ?></textarea>
					</td>
				  </tr>
				  <tr>
				    <td class="tg-vn4c vert">Bookings</td>
				    <td class="tg-vn4c" style="width: 810px">
				    	<textarea class="form-control input proc" name="bookings"><?php if (isset($branchProc['bookings'])) {echo $branchProc['bookings'];} elseif (isset($_SESSION['form']['procEdit'])) {echo $_SESSION['form']['procEdit']['bookings'];}  ?></textarea>
					</td>
				  </tr>
				  <tr>
				    <td class="tg-031e vert">Cancellations</td>
				    <td class="tg-031e">
				    	<textarea class="form-control input proc" name="cancellations"><?php if (isset($branchProc['cancellations'])) {echo $branchProc['cancellations'];} elseif (isset($_SESSION['form']['procEdit'])) {echo $_SESSION['form']['procEdit']['cancellations'];}  ?></textarea></td>
				  </tr>
				  <tr>
				    <td class="tg-vn4c vert">Temp No Show</td>
				    <td class="tg-vn4c">
				    	<textarea class="form-control input proc" name="tempnoshow"><?php if (isset($branchProc['tempnoshow'])) {echo $branchProc['tempnoshow'];} elseif (isset($_SESSION['form']['procEdit'])) {echo $_SESSION['form']['procEdit']['tempnoshow'];}  ?></textarea></td>
				  </tr>
				  <tr>
				    <td class="tg-031e vert">Other Client Issue</td>
				    <td class="tg-031e">
				    	<textarea class="form-control input proc" name="otherclient"><?php if (isset($branchProc['otherclient'])) {echo $branchProc['otherclient'];} elseif (isset($_SESSION['form']['procEdit'])) {echo $_SESSION['form']['procEdit']['otherclient'];}  ?></textarea></td>
				  </tr>
				  <tr>
				    <td class="tg-vn4c vert">Client Checkins</td>
				    <td class="tg-vn4c">
				    	<textarea class="form-control input proc" name="checkins"><?php if (isset($branchProc['checkins'])) {echo $branchProc['checkins'];} elseif (isset($_SESSION['form']['procEdit'])) {echo $_SESSION['form']['procEdit']['checkins'];}  ?></textarea></td>
				  </tr>
				  <tr>
				    <td class="tg-031e vert">Temp Sickness or Absence</td>
				    <td class="tg-031e">
				    	<textarea class="form-control input proc" name="sick"><?php if (isset($branchProc['sick'])) {echo $branchProc['sick'];} elseif (isset($_SESSION['form']['procEdit'])) {echo $_SESSION['form']['procEdit']['sick'];}  ?></textarea></td>
				  </tr>
				  <tr>
				    <td class="tg-vn4c vert">Temp Working Times</td>
				    <td class="tg-vn4c">
				    	<textarea class="form-control input proc" name="working"><?php if (isset($branchProc['working'])) {echo $branchProc['working'];} elseif (isset($_SESSION['form']['procEdit'])) {echo $_SESSION['form']['procEdit']['working'];}  ?></textarea></td>
				  </tr>
				  <tr>
				    <td class="tg-031e vert">Temp Pay Queries</td>
				    <td class="tg-031e">
				    	<textarea class="form-control input proc" name="pay"><?php if (isset($branchProc['pay'])) {echo $branchProc['pay'];} elseif (isset($_SESSION['form']['procEdit'])) {echo $_SESSION['form']['procEdit']['pay'];}  ?></textarea></td>
				  </tr>
				  <tr>
				    <td class="tg-vn4c vert">Temp Other Issues</td>
				    <td class="tg-vn4c">
				    	<textarea class="form-control input proc" name="othertemp"><?php if (isset($branchProc['othertemp'])) {echo $branchProc['othertemp'];} elseif (isset($_SESSION['form']['procEdit'])) {echo $_SESSION['form']['procEdit']['othertemp'];}  ?></textarea></td>
				  </tr>
				</table>
			</div>
			<input type="hidden" name="page" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
			<div style="text-align: center;padding: 15px 0 50px 0;">
				<button id="submit" name="submit" type="submit" class="btn btn-primary">Submit</button>
				<a id="clearConfirm"><button name="" type="submit" class="btn btn-primary">Clear</button></a>
			</div>
		</form>
	</div>
	<div class="col-sm-3 col-md-3 col-lg-3"></div>
</div>

<?php
if($_SESSION['login']['branchID'] == 27 ) {
    require_once $root.'/pages/footer.php';
}
?>