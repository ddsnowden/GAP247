<?php 
    //Define root path
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    //Include header
    require_once $root.'/pages/header.php';
    //Resrtrict to GAP24/7 Users
    include $root.'/assets/php/auth/branchUsers.php';
    //Include required classes
	require_once $root.'/assets/php/class/MatalanAdvert.class.php';
	$matalanData = new Matalan();
    //Recall for existing calls
	$recall = $matalanData->recall($DBH);
	$currentPage = "Matalan Advert";
?>
<!-- Load common scripts and call specific scripts -->
<script src="/assets/js/custom/commonScripts.js"></script>
<script src="/assets/js/custom/callScripts.js"></script>
<script src="/assets/js/custom/searching.js"></script>
<script src="/assets/js/custom/postcodes.js"></script>
<script type="text/javascript">var callType = 'Matalan Advert';</script>
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
	<div class="col-sm-5 col-md-5 col-lg-5">
        <div class="row">
		<form method="POST" action="/assets/php/MatalanAdvert.php" role="form" class="form-horizontal" >
		    <fieldset>
        		<input class="hidden" type='hidden' name='callID' value="<?php if (isset($_SESSION['form']['callID'])) echo htmlspecialchars($_SESSION['form']['callID'], ENT_QUOTES); ?>" />
    			<input class="hidden" type='hidden' name='type' value="Matalan Advert" />
                
                <div class="col-sm-6 labright">
                    <label for="recall">Recall:</label>
                </div>
                <div class="col-sm-10">
    	            <select id="recall" class="form-control input">
    		            <option selected></option>
    		            <?php
    		            foreach ($recall as $key) {
    						echo '<option id='.htmlspecialchars($key['callID'], ENT_QUOTES).'>'.
                            date("d-m-Y", strtotime(htmlspecialchars($key['dateInputted'], ENT_QUOTES))).'/'.
                            date("H:i:s", strtotime(htmlspecialchars($key['timeInputted'], ENT_QUOTES))) .' - '.
                            htmlspecialchars($key['branchNameShort'], ENT_QUOTES).' - '.
                            htmlspecialchars($key['firstName'], ENT_QUOTES).' '.
                            htmlspecialchars($key['lastName'], ENT_QUOTES).' - '.
                            htmlspecialchars($key['landline'], ENT_QUOTES).' - '.
                            htmlspecialchars($key['mobile'], ENT_QUOTES).' - '.
                            htmlspecialchars($key['emailed'], ENT_QUOTES).'</option>';
    					}
    					?>
    		        </select>
    		    </div>
                <div class="col-sm-6 labright">
                    <label for="branch">Branch:</label>
                </div>
                <div class="col-sm-10">
                	<?php require $root.'/assets/php/branchList.php'; ?>
            	</div>

                <div class="col-sm-6 labright">
                    <label for="search">Temp Search:</label>
                </div>
                <div class="col-sm-10">
                    <input type="text" name="tempSearch" id="tempSearch" class="form-control input" />
                    <div id="tempResult" style="z-index: 10000;">
                        <?php if(isset($_SESSION['form']['tempList'])) {
                            foreach ($_SESSION['form']['tempList'] as $key) { ?>
                                <p onclick="tempID($(this).attr('id'))" class="resultList" id="<?php echo htmlspecialchars($key['tempID'], ENT_QUOTES); ?>"><?php echo ucwords(htmlspecialchars($key['firstName'], ENT_QUOTES)).' '.ucwords(htmlspecialchars($key['lastName'], ENT_QUOTES)).' - '.htmlspecialchars($key['landline'], ENT_QUOTES).' - '.htmlspecialchars($key['mobile'], ENT_QUOTES).' - '.htmlspecialchars($key['postcode'], ENT_QUOTES); ?></p>
                        <?php } } ?>
                    </div>
                </div> 

                <div id="tempDetails">
                    <input class="hidden" id="tempID" name="tempID" value="<?php if (isset($_SESSION['form']['tempID'])) echo htmlspecialchars($_SESSION['form']['tempID'], ENT_QUOTES); ?>" />
                    <div class="col-sm-6 labright">
                        <label for="title">Title:</label>
                    </div>
                    <div class="col-sm-10">
        	            <select class="form-control input" name='title' id="title">
        					<option value='' <?=(isset($_SESSION['form']['title']) && $_SESSION['form']['title'] == '' ? 'selected' : '')?>></option>
        					<option value='Mr' <?=(isset($_SESSION['form']['title']) && $_SESSION['form']['title'] == 'Mr' ? 'selected' : '')?>>Mr</option>
        					<option value='Miss' <?=(isset($_SESSION['form']['title']) && $_SESSION['form']['title'] == 'Miss' ? 'selected' : '')?>>Miss</option>
        					<option value='Mrs' <?=(isset($_SESSION['form']['title']) && $_SESSION['form']['title'] == 'Mrs' ? 'selected' : '')?>>Mrs</option>
        				</select>
                	</div>

                    <div class="col-sm-6 labright">
                        <label for="firstName">First Name:</label>
                    </div>
                    <div class="col-sm-10">
                    	<input class="form-control input letters" name="firstName" id="firstName" type="text" value="<?php if (isset($_SESSION['form']['firstName'])) echo htmlspecialchars($_SESSION['form']['firstName'], ENT_QUOTES); ?>" />
                	</div>

                    <div class="col-sm-6 labright">
                        <label for="lastName">Last Name:</label>
                    </div>
                    <div class="col-sm-10">
                    	<input class="form-control input letters" name="lastName" id="lastName" type="text" value="<?php if (isset($_SESSION['form']['lastName'])) echo htmlspecialchars($_SESSION['form']['lastName'], ENT_QUOTES); ?>" />
                	</div>

                    <div class="col-sm-6 labright">
                        <label for="landline">Landline:</label>
                    </div>
                    <div class="col-sm-10">
                    	<input class="form-control input number" name="landline" id="landline" type="text" value="<?php if (isset($_SESSION['form']['landline'])) echo htmlspecialchars($_SESSION['form']['landline'], ENT_QUOTES); ?>" />
                	</div>

                    <div class="col-sm-6 labright">
                        <label for="mobile">Mobile:</label>
                    </div>
                    <div class="col-sm-10">
                    	<input class="form-control input number" name="mobile" id="mobile" type="text" value="<?php if (isset($_SESSION['form']['mobile'])) echo htmlspecialchars($_SESSION['form']['mobile'], ENT_QUOTES); ?>" />
                	</div>
                      

                    <div class="col-sm-6 labright">
                        <label for="postcode">Postcode:</label>
                    </div>
                    <div class="col-sm-10">
                    	<input type="text" class="form-control input postcode" id="postcode" name="postcode" value="<?php if (isset($_SESSION['form']['postcode'])) echo htmlspecialchars($_SESSION['form']['postcode'], ENT_QUOTES); ?>" />
                    	<div style="text-align: center">
                    		<input type="button" class="btn btn-primary postCodeLookup" value="Postcode Search" />
                    	</div>
                	</div>

                	<div class="col-sm-6 labright">
                        <label for="nameNumber">Name/Number:</label>
                    </div>
                    <div class="col-sm-10">
                    	<input type="text" class="form-control input" name="nameNumber" value="<?php if (isset($_SESSION['form']['nameNumber'])) echo htmlspecialchars($_SESSION['form']['nameNumber'], ENT_QUOTES); ?>" />
                	</div>

                	<div class="col-sm-6 labright">
                        <label for="addressOne">First line</label>
                    </div>
                    <div class="col-sm-10">
                    	<input type="text" class="form-control input" name="addressOne" value="<?php if (isset($_SESSION['form']['addressOne'])) echo htmlspecialchars($_SESSION['form']['addressOne'], ENT_QUOTES); ?>" />
                	</div>

                	<div class="col-sm-6 labright">
                        <label for="addressTwo">Second line:</label>
                    </div>
                    <div class="col-sm-10">
                    	<input type="text" class="form-control input" name="addressTwo" value="<?php if (isset($_SESSION['form']['addressTwo'])) echo htmlspecialchars($_SESSION['form']['addressTwo'], ENT_QUOTES); ?>" />
                	</div>
                	
                	<div class="col-sm-6 labright">
                        <label for="city">City:</label>
                    </div>
                    <div class="col-sm-10">
                    	<input type="text" class="form-control" name="city" value="<?php if (isset($_SESSION['form']['city'])) echo htmlspecialchars($_SESSION['form']['city'], ENT_QUOTES); ?>" />
                	</div>
                </div>
            	
            	<div class="col-sm-6 labright">
                    <label for="advertLocation">Advert location:</label>
                </div>
                <div class="col-sm-10">
                	<input type="text" class="form-control input" name="advertLocation" value="<?php if (isset($_SESSION['form']['advertLocation'])) echo htmlspecialchars($_SESSION['form']['advertLocation'], ENT_QUOTES); ?>" />
            	</div>
				
				<div class="col-sm-6 labright">
                    <label for="age">Over 18?:</label>
                </div>
                <div class="col-sm-10">
                	<select class="form-control input" name="age">
						<option value="" <?=(isset($_SESSION['form']['age']) && $_SESSION['form']['age'] == '' ? 'selected' : '')?>></option>
						<option value="Yes" <?=(isset($_SESSION['form']['age']) && $_SESSION['form']['age'] == 'Yes' ? 'selected' : '')?>>Yes</option>
						<option value="No" <?=(isset($_SESSION['form']['age']) && $_SESSION['form']['age'] == 'No' ? 'selected' : '')?>>No</option>
					</select>
            	</div>

            	<div class="col-sm-16" style="height:34px;"></div>

            	<div class="col-sm-6 labright">
                    <label for="employed">Employed?:</label>
                </div>
                <div class="col-sm-10">	
                	<select class="form-control input" name='employed'>
						<option value="" <?=(isset($_SESSION['form']['employed']) && $_SESSION['form']['employed'] == '' ? 'selected' : '')?>></option>
						<option value="Yes" <?=(isset($_SESSION['form']['employed']) && $_SESSION['form']['employed'] == 'Yes' ? 'selected' : '')?>>Yes</option>
						<option value="No" <?=(isset($_SESSION['form']['employed']) && $_SESSION['form']['employed'] == 'No' ? 'selected' : '')?>>No</option>
					</select>
            	</div>

                <div class="col-sm-6 labright">
                    <label for="currentPos">Current position:</label>
                </div>
                <div class="col-sm-10">   
                	<input class="form-control input" name="currentPos" value="<?php if (isset($_SESSION['form']['currentPos'])) echo htmlspecialchars($_SESSION['form']['currentPos'], ENT_QUOTES); ?>" />
            	</div>

                <div class="col-sm-6 labright">
                    <label for="currentCompany">Company:</label>
                </div>
                <div class="col-sm-10">
    	            <input class="form-control input" name="currentCompany" value="<?php if (isset($_SESSION['form']['currentCompany'])) echo htmlspecialchars($_SESSION['form']['currentCompany'], ENT_QUOTES); ?>" />
            	</div>

            	<div class="col-sm-6 labright">
                    <label for="agency1">Agency?:</label>
                </div>
                <div class="col-sm-10">
    	            <select class="form-control input" name='agency1'>
						<option value="" <?=(isset($_SESSION['form']['agency1']) && $_SESSION['form']['agency1'] == '' ? 'selected' : '')?>></option>
						<option value="Yes" <?=(isset($_SESSION['form']['agency1']) && $_SESSION['form']['agency1'] == 'Yes' ? 'selected' : '')?>>Yes</option>
						<option value="No" <?=(isset($_SESSION['form']['agency1']) && $_SESSION['form']['agency1'] == 'No' ? 'selected' : '')?>>No</option>
					</select>
            	</div>

            	<div class="col-sm-6 labright">
                    <label for="agencyName1">Which agency:</label>
                </div>
                <div class="col-sm-10">
    	            <input class="form-control input" name="agencyName1" value="<?php if (isset($_SESSION['form']['agencyName1'])) echo htmlspecialchars($_SESSION['form']['agencyName1'], ENT_QUOTES); ?>" />
            	</div>

            	<div class="col-sm-6 labright">
                    <label for="supervisorName1">Supervisor:</label>
                </div>
                <div class="col-sm-10">
    	            <input class="form-control input" name="supervisorName1" value="<?php if (isset($_SESSION['form']['supervisorName1'])) echo htmlspecialchars($_SESSION['form']['supervisorName1'], ENT_QUOTES); ?>" />
            	</div>

			</fieldset>
		</div>
	</div>




	<div class="col-sm-5 col-md-5 col-lg-5 form" >
    <div class="row">
		<fieldset>
                <div class="col-sm-6 labright">
                    <label for="previousPos1">Previous position:</label>
                </div>
                <div class="col-sm-10">   
                	<input class="form-control input" name="previousPos1" value="<?php if (isset($_SESSION['form']['previousPos1'])) echo htmlspecialchars($_SESSION['form']['previousPos1'], ENT_QUOTES); ?>" />
            	</div>

                <div class="col-sm-6 labright">
                    <label for="previousCompany1">Company:</label>
                </div>
                <div class="col-sm-10">
    	            <input class="form-control input" name="previousCompany1" value="<?php if (isset($_SESSION['form']['previousCompany1'])) echo htmlspecialchars($_SESSION['form']['previousCompany1'], ENT_QUOTES); ?>" />
            	</div>

            	<div class="col-sm-6 labright">
                    <label for="agency2">Agency?:</label>
                </div>
                <div class="col-sm-10">
    	            <select class="form-control input" name='agency2'>
						<option value="" <?=(isset($_SESSION['form']['agency2']) && $_SESSION['form']['agency2'] == '' ? 'selected' : '')?>></option>
						<option value="Yes" <?=(isset($_SESSION['form']['agency2']) && $_SESSION['form']['agency2'] == 'Yes' ? 'selected' : '')?>>Yes</option>
						<option value="No" <?=(isset($_SESSION['form']['agency2']) && $_SESSION['form']['agency2'] == 'No' ? 'selected' : '')?>>No</option>
					</select>
            	</div>

            	<div class="col-sm-6 labright">
                    <label for="agencyName2">Which agency:</label>
                </div>
                <div class="col-sm-10">
    	            <input class="form-control input" name="agencyName2" value="<?php if (isset($_SESSION['form']['agencyName2'])) echo htmlspecialchars($_SESSION['form']['agencyName2'], ENT_QUOTES); ?>" />
            	</div>

            	<div class="col-sm-6 labright">
                    <label for="supervisorName2">Supervisor:</label>
                </div>
                <div class="col-sm-10">
    	            <input class="form-control input" name="supervisorName2" value="<?php if (isset($_SESSION['form']['supervisorName2'])) echo htmlspecialchars($_SESSION['form']['supervisorName2'], ENT_QUOTES); ?>" />
            	</div>

            	<div class="col-sm-16" style="height:34px;"></div>

            	<div class="col-sm-6 labright">
                    <label for="previousPos2">Previous position:</label>
                </div>
                <div class="col-sm-10">   
                	<input class="form-control input" name="previousPos2" value="<?php if (isset($_SESSION['form']['previousPos2'])) echo htmlspecialchars($_SESSION['form']['previousPos2'], ENT_QUOTES); ?>" />
            	</div>

                <div class="col-sm-6 labright">
                    <label for="previousCompany2">Company:</label>
                </div>
                <div class="col-sm-10">
    	            <input class="form-control input" name="previousCompany2" value="<?php if (isset($_SESSION['form']['previousCompany2'])) echo htmlspecialchars($_SESSION['form']['previousCompany2'], ENT_QUOTES); ?>" />
            	</div>

            	<div class="col-sm-6 labright">
                    <label for="agency3">Agency?:</label>
                </div>
                <div class="col-sm-10">
    	            <select class="form-control input" name='agency3'>
						<option value="" <?=(isset($_SESSION['form']['agency3']) && $_SESSION['form']['agency3'] == '' ? 'selected' : '')?>></option>
						<option value="Yes" <?=(isset($_SESSION['form']['agency3']) && $_SESSION['form']['agency3'] == 'Yes' ? 'selected' : '')?>>Yes</option>
						<option value="No" <?=(isset($_SESSION['form']['agency3']) && $_SESSION['form']['agency3'] == 'No' ? 'selected' : '')?>>No</option>
					</select>
            	</div>

            	<div class="col-sm-6 labright">
                    <label for="agencyName3">Which agency:</label>
                </div>
                <div class="col-sm-10">
    	            <input class="form-control input" name="agencyName3" value="<?php if (isset($_SESSION['form']['agencyName3'])) echo htmlspecialchars($_SESSION['form']['agencyName3'], ENT_QUOTES); ?>" />
            	</div>

            	<div class="col-sm-6 labright">
                    <label for="supervisorName3">Supervisor:</label>
                </div>
                <div class="col-sm-10">
    	            <input class="form-control input" name="supervisorName3" value="<?php if (isset($_SESSION['form']['supervisorName3'])) echo htmlspecialchars($_SESSION['form']['supervisorName3'], ENT_QUOTES); ?>" />
            	</div>

            	<div class="col-sm-16" style="height:34px;"></div>

            	<div class="col-sm-6 labright">
                    <label for="transport">Own transport:</label>
                </div>
                <div class="col-sm-10">
    	            <select class="form-control input" name='transport'>
						<option value="" <?=(isset($_SESSION['form']['transport']) && $_SESSION['form']['transport'] == '' ? 'selected' : '')?>></option>
						<option value="Yes" <?=(isset($_SESSION['form']['transport']) && $_SESSION['form']['transport'] == 'Yes' ? 'selected' : '')?>>Yes</option>
						<option value="No" <?=(isset($_SESSION['form']['transport']) && $_SESSION['form']['transport'] == 'No' ? 'selected' : '')?>>No</option>
					</select>
            	</div>
            	<div class="col-sm-6 labright">
                    <label for="travel">Willing to travel:</label>
                </div>
                <div class="col-sm-10">
    	            <select class="form-control input" name='travel'>
						<option value="" <?=(isset($_SESSION['form']['travel']) && $_SESSION['form']['travel'] == '' ? 'selected' : '')?>></option>
						<option value="Yes" <?=(isset($_SESSION['form']['travel']) && $_SESSION['form']['travel'] == 'Yes' ? 'selected' : '')?>>Yes</option>
						<option value="No" <?=(isset($_SESSION['form']['travel']) && $_SESSION['form']['travel'] == 'No' ? 'selected' : '')?>>No</option>
					</select>
            	</div>

            	<div class="col-sm-6 labright">
                    <label></label>
                </div>
                <div class="col-sm-10">
                	<div style="text-align: center">
                		<p style="margin-top: 10px;">Are you able to work the following:</p>
                	</div>
                </div>

            	<div class="col-sm-6 labright">
                    <label for="workTimeMorn">0600-1400?:</label>
                </div>
                <div class="col-sm-10">
    	            <select class="form-control input" name='workTimeMorn'>
						<option value="" <?=(isset($_SESSION['form']['workTimeMorn']) && $_SESSION['form']['workTimeMorn'] == '' ? 'selected' : '')?>></option>
						<option value="Yes" <?=(isset($_SESSION['form']['workTimeMorn']) && $_SESSION['form']['workTimeMorn'] == 'Yes' ? 'selected' : '')?>>Yes</option>
						<option value="No" <?=(isset($_SESSION['form']['workTimeMorn']) && $_SESSION['form']['workTimeMorn'] == 'No' ? 'selected' : '')?>>No</option>
					</select>
            	</div>
            	<div class="col-sm-6 labright">
                    <label for="workTimeEve">1400-2200?:</label>
                </div>
                <div class="col-sm-10">
    	            <select class="form-control input" name='workTimeEve'>
						<option value="" <?=(isset($_SESSION['form']['workTimeEve']) && $_SESSION['form']['workTimeEve'] == '' ? 'selected' : '')?>></option>
						<option value="Yes" <?=(isset($_SESSION['form']['workTimeEve']) && $_SESSION['form']['workTimeEve'] == 'Yes' ? 'selected' : '')?>>Yes</option>
						<option value="No" <?=(isset($_SESSION['form']['workTimeEve']) && $_SESSION['form']['workTimeEve'] == 'No' ? 'selected' : '')?>>No</option>
					</select>
            	</div>
            	<div class="col-sm-6 labright">
                    <label for="workTimeNight">2200-0600?:</label>
                </div>
                <div class="col-sm-10">
    	            <select class="form-control input" name='workTimeNight'>
						<option value="" <?=(isset($_SESSION['form']['workTimeNight']) && $_SESSION['form']['workTimeNight'] == '' ? 'selected' : '')?>></option>
						<option value="Yes" <?=(isset($_SESSION['form']['workTimeNight']) && $_SESSION['form']['workTimeNight'] == 'Yes' ? 'selected' : '')?>>Yes</option>
						<option value="No" <?=(isset($_SESSION['form']['workTimeNight']) && $_SESSION['form']['workTimeNight'] == 'No' ? 'selected' : '')?>>No</option>
					</select>
            	</div>
            	<div class="col-sm-6 labright">
                    <label for="workTimeEnds">Weekends?:</label>
                </div>
                <div class="col-sm-10">
    	            <select class="form-control input" name='workTimeEnds'>
						<option value="" <?=(isset($_SESSION['form']['workTimeEnds']) && $_SESSION['form']['workTimeEnds'] == '' ? 'selected' : '')?>></option>
						<option value="Yes" <?=(isset($_SESSION['form']['workTimeEnds']) && $_SESSION['form']['workTimeEnds'] == 'Yes' ? 'selected' : '')?>>Yes</option>
						<option value="No" <?=(isset($_SESSION['form']['workTimeEnds']) && $_SESSION['form']['workTimeEnds'] == 'No' ? 'selected' : '')?>>No</option>
					</select>
            	</div>

            	<div class="col-sm-6 labright">
                    <label></label>
                </div>
                <div class="col-sm-10">
                	<div style="text-align: center">
                		<p style="margin-top: 10px;">Have you worked:</p>
                	</div>
                </div>

            	<div class="col-sm-6 labright">
                    <label for="twelveMonths">In the last 12 months?:</label>
                </div>
                <div class="col-sm-10">
    	            <select class="form-control input" name='twelveMonths'>
						<option value="" <?=(isset($_SESSION['form']['twelveMonths']) && $_SESSION['form']['twelveMonths'] == '' ? 'selected' : '')?>></option>
						<option value="Yes" <?=(isset($_SESSION['form']['twelveMonths']) && $_SESSION['form']['twelveMonths'] == 'Yes' ? 'selected' : '')?>>Yes</option>
						<option value="No" <?=(isset($_SESSION['form']['twelveMonths']) && $_SESSION['form']['twelveMonths'] == 'No' ? 'selected' : '')?>>No</option>
					</select>
            	</div>
            	<div class="col-sm-6 labright">
                    <label for="pastMat">For Matalan before?:</label>
                </div>
                <div class="col-sm-10">
    	            <select class="form-control input" name='pastMat'>
						<option value="" <?=(isset($_SESSION['form']['pastMat']) && $_SESSION['form']['pastMat'] == '' ? 'selected' : '')?>></option>
						<option value="Yes" <?=(isset($_SESSION['form']['pastMat']) && $_SESSION['form']['pastMat'] == 'Yes' ? 'selected' : '')?>>Yes</option>
						<option value="No" <?=(isset($_SESSION['form']['pastMat']) && $_SESSION['form']['pastMat'] == 'No' ? 'selected' : '')?>>No</option>
					</select>
            	</div>
            	
            </fieldset>
            </div>
		
	</div>



    <div class="col-sm-5 col-md-5 col-lg-5 form">
    <div class="row">
    	<fieldset>
    		<div class="col-sm-6 labright">
                <label for=""> </label>
            </div>
            <div class="col-sm-10">
            	<div style="text-align: center">
            		<p>Are you:</p>
            	</div>
            </div>

    		<div class="col-sm-6 labright">
                <label for="reference" >Able to supply references:</label>
            </div>
            <div class="col-sm-10">
                <select class="form-control input" name='reference'>
                    <option value="" <?=(isset($_SESSION['form']['reference']) && $_SESSION['form']['reference'] == '' ? 'selected' : '')?>></option>
                    <option value="Yes" <?=(isset($_SESSION['form']['reference']) && $_SESSION['form']['reference'] == 'Yes' ? 'selected' : '')?>>Yes</option>
                    <option value="No" <?=(isset($_SESSION['form']['reference']) && $_SESSION['form']['reference'] == 'No' ? 'selected' : '')?>>No</option>
                </select>
        	</div>
        	<div class="col-sm-6 labright">
                <label for="otherPos" >Intereseted in other positions:</label>
            </div>
            <div class="col-sm-10">
	            <select class="form-control input" name='otherPos'>
					<option value="" <?=(isset($_SESSION['form']['otherPos']) && $_SESSION['form']['otherPos'] == '' ? 'selected' : '')?>></option>
					<option value="Yes" <?=(isset($_SESSION['form']['otherPos']) && $_SESSION['form']['otherPos'] == 'Yes' ? 'selected' : '')?>>Yes</option>
					<option value="No" <?=(isset($_SESSION['form']['otherPos']) && $_SESSION['form']['otherPos'] == 'No' ? 'selected' : '')?>>No</option>
				</select>
        	</div>

            <div class="col-sm-6 labright">
                <label></label>
            </div>
            <div class="col-sm-10">
            	<div style="text-align: center">
            		<p style="margin-top: 10px;">Disclosure and Barring Service</p>
            	</div>
            </div>

            
        	<div class="col-sm-6 labright">
                <label for="dbs">DBS, do you object?:</label>
            </div>
            <div class="col-sm-10">
	            <select class="form-control input" name='dbs'>
					<option value="" <?=(isset($_SESSION['form']['dbs']) && $_SESSION['form']['dbs'] == '' ? 'selected' : '')?>></option>
					<option value="Yes" <?=(isset($_SESSION['form']['dbs']) && $_SESSION['form']['dbs'] == 'Yes' ? 'selected' : '')?>>Yes</option>
					<option value="No" <?=(isset($_SESSION['form']['dbs']) && $_SESSION['form']['dbs'] == 'No' ? 'selected' : '')?>>No</option>
				</select>
        	</div>

        	<div class="col-sm-16" style="height:34px;"></div>

    		<div class="col-sm-6 labright">
                <label for="details">Details:</label>
            </div>
            <div class="col-sm-10">	
            	<textarea class="form-control input" rows="5" name="details" id="details" type="text"><?php if (isset($_SESSION['form']['details'])) echo htmlspecialchars($_SESSION['form']['details'], ENT_QUOTES); ?></textarea>
        	</div>

            <div class="col-sm-6 labright">
                <label for="further">Further Actions:</label>
            </div>
            <div class="col-sm-10">   
            	<textarea class="form-control input" rows="5" name="further" id="further" type="text"><?php if (isset($_SESSION['form']['further'])) echo htmlspecialchars($_SESSION['form']['further'], ENT_QUOTES); ?></textarea>
        	</div>

            <div class="col-sm-6 labright">
                <label for="status">Status:</label>
            </div>
            <div class="col-sm-10">
	            <select class="form-control input" name='status' id="status" required>
					<option value='' <?=(isset($_SESSION['form']['status']) && $_SESSION['form']['status'] == '' ? 'selected' : '')?>></option>
					<option value='Completed' <?=(isset($_SESSION['form']['status']) && $_SESSION['form']['status'] == 'Completed' ? 'selected' : '')?>>Completed</option>
					<option value='Outstanding' <?=(isset($_SESSION['form']['status']) && $_SESSION['form']['status'] == 'Outstanding' ? 'selected' : '')?>>Outstanding</option>
				</select>
        	</div>

            <div class="col-sm-6 labright">
        	   <!-- <label for="submit"></label> -->
            </div>
            <div class="col-sm-10">
            	<button id="submit" name="submit" type="submit" class="btn btn-primary" style="width: 100%">Submit</button>
            </div>

            <div class="col-sm-6 labright">
               <!-- <label for="clear"></label> -->
            </div>
            <div class="col-sm-10">
            	<a id="clearConfirm"><button name="" type="submit" class="btn btn-primary" style="width: 100%">Clear</button></a>
            </div>
            <input type="hidden" name="page" value="<?php echo $_SERVER['REQUEST_URI']; ?>">

            <?php if(isset($_SESSION['form']['status']) && $_SESSION['form']['status'] == 'Completed') { ?>
	            <div class="col-sm-6 labright">
                   <!-- <label for="email"></label> -->
                </div>
	            <div class="col-sm-10">
	            	<a id="emailConfirm"><button id="email" name="" type="submit" class="btn btn-primary">Email</button></a>
	            </div>
            <?php } ?>
    	</fieldset>
        </div>
    	</form>
    </div>
    <div class="col-sm-1 col-md-1 col-lg-1"></div>
</div>

<?php
if($_SESSION['login']['branchID'] == 27 ) {
    require_once $root.'/pages/footer.php';
}
?>