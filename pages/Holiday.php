<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once $root.'/pages/header.php';

    include $root.'/assets/php/auth/branchUsers.php';

	require_once $root.'/assets/php/class/Holiday.class.php';

	$holidayData = new Holiday();
	$recall = $holidayData->recall($DBH, $_SESSION['login']['access'], $_SESSION['login']['staffID']);
?>
<!-- Load common scripts and call specific scripts -->
<script src="/assets/js/custom/commonScripts.js"></script>
<script src="/assets/js/custom/callScripts.js"></script>
<script src="/assets/js/custom/searching.js"></script>

<script type="text/javascript">var callType = 'holiday';</script>
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
	<div class="col-sm-6 col-md-6 col-lg-4">
		<form method="POST" action="/assets/php/Holiday.php" role="form" class="form-horizontal" >
			<input type='hidden' name='holidayID' value="<?php if (isset($_SESSION['form']['holidayID'])) echo $_SESSION['form']['holidayID']; ?>" />

	    	
	    	<div class="col-sm-6 labright">
                <label for="firstName">First Name:</label>
            </div>
            <div class="col-sm-8">
            	<input class="form-control input letters" name="firstName" id="firstName" type="text" value="<?php if(($_SESSION['login']['access'] == 2) && isset($_SESSION['form']['staffNameFirst'])) {echo $_SESSION['form']['staffNameFirst']; } else {echo $_SESSION['login']['staffNameFirst']; }  ?>" disabled />
        	</div>
        	<div class="col-sm-2"></div>

            <div class="col-sm-6 labright">
                <label for="lastName">Last Name:</label>
            </div>
            <div class="col-sm-8">
            	<input class="form-control input letters" name="lastName" id="lastName" type="text" value="<?php if(($_SESSION['login']['access'] == 2) && isset($_SESSION['form']['staffNameLast'])) {echo $_SESSION['form']['staffNameLast']; } else {echo $_SESSION['login']['staffNameLast']; }  ?>" disabled />
        	</div>
        	<div class="col-sm-2"></div>

            <div class="col-sm-6 labright">
                <label for="branch">Branch:</label>
            </div>
            <div class="col-sm-8">
            	<input class="form-control input letters" name="branch" id="branch" type="text" value="Nightline" disabled />
        	</div>
        	<div class="col-sm-2"></div>

        	<div class="col-sm-6 labright">
                <label for="holStart">Start:</label>
            </div>
            <div class="col-sm-8">
				<input class="form-control input dateOnly" name="holStart" value="<?php if (isset($_SESSION['form']['holStart'])) echo $_SESSION['form']['holStart']; ?>" required/>
			</div>
			<div class="col-sm-2"></div>

			<div class="col-sm-6 labright">
                <label for="holFinish">Finish:</label>
            </div>
            <div class="col-sm-8">
				<input class="form-control input dateOnly" name="holFinish" value="<?php if (isset($_SESSION['form']['holFinish'])) echo $_SESSION['form']['holFinish']; ?>" required/>
			</div>
			<div class="col-sm-2"></div>

			<div class="col-sm-6 labright">
                <label for="additional">Additional Information:</label>
            </div>
            <div class="col-sm-8">   
            	<textarea class="form-control input" rows="10" name="additional" id="additional" type="text"><?php if (isset($_SESSION['form']['additional'])) echo $_SESSION['form']['additional']; ?></textarea>
        	</div>
        	<div class="col-sm-2"></div>

        	<?php if ($_SESSION['login']['access'] == '2'): ?>
				<div class="col-sm-6 labright">
					<label for="sanctioned">Sanctioned</label>
				</div>
				<div class="col-sm-8">
					<select class="form-control input" name='sanctioned'>
						<option value='' <?php echo (isset($_SESSION['form']['sanctioned']) && $_SESSION['form']['sanctioned'] == '' ? 'selected' : '') ?> ></option>
						<option value='Yes' <?php echo (isset($_SESSION['form']['sanctioned']) && $_SESSION['form']['sanctioned'] == 'Yes' ? 'selected' : '') ?> >Yes</option>
						<option value='No' <?php echo (isset($_SESSION['form']['sanctioned']) && $_SESSION['form']['sanctioned'] == 'No' ? 'selected' : '') ?> >No</option>
					</select>
				</div>
				<div class="col-sm-2"></div>
			<?php endif; ?>

        	<div class="col-sm-6 labright">
        	   <!-- <label for="submit"></label> -->
            </div>
            <div class="col-sm-8">
            	<button id="submit" name="submit" type="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="col-sm-2"></div>

            <div class="col-sm-6 labright">
               <!-- <label for="clear"></label> -->
            </div>
            <div class="col-sm-8">
            	<a id="clearConfirm"><button name="" type="submit" class="btn btn-primary">Clear</button></a>
            </div>
            <div class="col-sm-2"></div>

            
            <input type="hidden" name="page" value="<?php echo $_SERVER['REQUEST_URI']; ?>">

		</form>
	</div>

	<div class="col-sm-6 col-md-6 col-lg-9">
		<div>
            <table class="tableWhite" style="width: 100%;">
                <th class="top" style="width: 15%">Holiday ID</th><th class="top" style="max-width: 10%">Start</th><th class="top"  class="checkinContacts" style="max-width: 5%">Finish</th><th class="top"  class="checkinContacts" style="max-width: 12.5%">Sanctioned</th><?php if($_SESSION['login']['access'] == 2) echo '<th class="top">Staff Name</th>'; ?>
                    <tbody>
                    <?php
                    foreach ($recall as $key) { ?>
                    	<tr>
                    		<td class="clickID" onClick="holidayRecall(this.innerHTML);"><?php echo $key['holidayID']; ?></td>
                    		<td><?php echo date('d-m-Y', strtotime($key['holStart'])); ?></td>
                            <td><?php echo date('d-m-Y', strtotime($key['holFinish'])); ?></td>
                            <td class="sanctioned"><?php echo $key['sanctioned']; ?></td>
                            <td><?php if($_SESSION['login']['access'] == 2) echo $key['staffNameFirst'].' '.$key['staffNameLast'] ?></td>
                    	</tr>
                       <?php } ?>
                	</tbody>
            	</table>
	   		</div>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-3">
			<h1 id="remHol">Your remaining holidays</h1>
            <br />
            <p>You have <span id="bold"><?php echo round($holidayData->remaining($DBH, $_SESSION['login']['staffID']), 2);?></span> <?php echo ($_SESSION['login']['fulltime'] == 0 ? ' hours' : ' days') ?> remaining.</p>
            <p>Please remember that these may not bee 100% accurate, any issues please contact Dean Langford</p>
		</div>
	</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.sanctioned').each(function(i, obj) {
		    var sanctioned = $(this).html();
		    if(sanctioned == 'Yes') {
		    	$(this).css('background-color', 'rgba(0,255,0,0.55');
		    }
            else if(sanctioned == 'No') {
                $(this).css('background-color', 'rgba(255,0,0,0.55');
            }
		});
	})
</script>

<?php
if($_SESSION['login']['branchID'] == 27 ) {
    require_once $root.'/pages/footer.php';
}
?>