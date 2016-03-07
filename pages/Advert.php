<?php 
	//Define root path
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    //Include header
    require_once $root.'/pages/header.php';
    //Resrtrict to GAP24/7 Users
    include $root.'/assets/php/auth/branchUsers.php';
    //Include required classes
	require_once $root.'/assets/php/class/Advert.class.php';
	$advertData = new Advert();
    //Recall for existing calls
	$recall = $advertData->recall($DBH);
	$currentPage = "advert";
?>
<!-- Load common scripts and call specific scripts -->
<script src="/assets/js/custom/commonScripts.js"></script>
<script src="/assets/js/custom/callScripts.js"></script>
<script src="/assets/js/custom/searching.js"></script>
<script src="/assets/js/custom/postcodes.js"></script>
<script type="text/javascript">var callType = 'advert';</script>

<!-- Start main content of the page -->
<div class="row form">
	<div class="col-sm-5 col-md-5 col-lg-5">
        <div class="row">
		<form method="POST" action="/assets/php/Advert.php" role="form" class="form-horizontal" >
		    <fieldset>
        		<input class="hidden" type='hidden' name='callID' value="<?php if (isset($_SESSION['form']['callID'])) echo htmlspecialchars($_SESSION['form']['callID'], ENT_QUOTES); ?>" />
    			<input class="hidden" type='hidden' name='type' value="advert" />
                
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

            	<div class="col-sm-16" style="height:20px;"></div>

                <div class="col-sm-6 labright">
                	<label>Position Advertised:</label>
                </div>
                <div class="col-sm-10">
                    <input class="form-control input" name="position" value="<?php if (isset($_SESSION['form']['position'])) echo htmlspecialchars($_SESSION['form']['position'], ENT_QUOTES); ?>" />
                </div>
                <div class="col-sm-6 labright">
                    <label>Advert location:</label>
                </div>
                <div class="col-sm-10">
                    <input class="form-control input" name="advertLocation" value="<?php if (isset($_SESSION['form']['advertLocation'])) echo htmlspecialchars($_SESSION['form']['advertLocation'], ENT_QUOTES); ?>" />
                </div>
                <div class="col-sm-6 labright">
                    <label>Which media for searching:</label>
                </div>
                <div class="col-sm-10">
                    <input class="form-control input" name="media" value="<?php if (isset($_SESSION['form']['media'])) echo htmlspecialchars($_SESSION['form']['media'], ENT_QUOTES); ?>" />
                </div>
                <div class="col-sm-6 labright">
                    <label>Worked in the last 12 months?:</label>
                </div>
                <div class="col-sm-10">
                    <select class="form-control input" name='twelveMonths'>
                        <option value="" <?=(isset($_SESSION['form']['twelveMonths']) && $_SESSION['form']['twelveMonths'] == '' ? 'selected' : '')?>></option>
                        <option value="Yes" <?=(isset($_SESSION['form']['twelveMonths']) && $_SESSION['form']['twelveMonths'] == 'Yes' ? 'selected' : '')?>>Yes</option>
                        <option value="No" <?=(isset($_SESSION['form']['twelveMonths']) && $_SESSION['form']['twelveMonths'] == 'No' ? 'selected' : '')?>>No</option>
                    </select>
                </div>

			</fieldset>
		</div>
	</div>




	<div class="col-sm-5 col-md-5 col-lg-5" >
    <div class="row">
		<fieldset>
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

            <div class="col-sm-16" style="height:20px;"></div>

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

        	<div class="col-sm-16" style="height:20px;"></div>

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

        	<div class="col-sm-16" style="height:20px;"></div>

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
        	   <label>Type of Job</label>
            </div>
            <div class="col-sm-10">
                <select class="form-control input" name="jobType" id="jobType">
                    <option value="" <?=(isset($_SESSION['form']['jobType']) && $_SESSION['form']['jobType'] == '' ? 'selected' : '')?>></option>
                    <option value="Industrial" <?=(isset($_SESSION['form']['jobType']) && $_SESSION['form']['jobType'] == 'Industrial' ? 'selected' : '')?>>Industrial</option>
                    <option value="Driving" <?=(isset($_SESSION['form']['jobType']) && $_SESSION['form']['jobType'] == 'Driving' ? 'selected' : '')?>>Driving</option>
                </select>
            </div>
            <div id="extra">
                <div class="col-sm-6 labright">
                    <label>Type of licence:</label>
                </div>
                <div class="col-sm-10">
                    <select class="form-control input" name='licence'>
                        <option value="" <?=(isset($_SESSION['form']['licence']) && $_SESSION['form']['licence'] == '' ? 'selected' : '')?>></option>
                        <option value="Class B" <?=(isset($_SESSION['form']['licence']) && $_SESSION['form']['licence'] == 'Class B' ? 'selected' : '')?>>3.5t Class B</option>
                        <option value="Class C1" <?=(isset($_SESSION['form']['licence']) && $_SESSION['form']['licence'] == 'Class C1' ? 'selected' : '')?>>7.5t Class C1</option>
                        <option value="Class 2" <?=(isset($_SESSION['form']['licence']) && $_SESSION['form']['licence'] == 'Class 2' ? 'selected' : '')?>>Class 2</option>
                        <option value="Class 1" <?=(isset($_SESSION['form']['licence']) && $_SESSION['form']['licence'] == 'Class 1' ? 'selected' : '')?>>Class 1</option>
                    </select>
                </div>

                <div class="col-sm-6 labright">
                    <label>Ever disqualified:</label>
                </div>
                <div class="col-sm-10">
                    <select class="form-control input" name='disqual'>
                        <option value="" <?=(isset($_SESSION['form']['disqual']) && $_SESSION['form']['disqual'] == '' ? 'selected' : '')?>></option>
                        <option value="Yes" <?=(isset($_SESSION['form']['disqual']) && $_SESSION['form']['disqual'] == 'Yes' ? 'selected' : '')?>>Yes</option>
                        <option value="No" <?=(isset($_SESSION['form']['disqual']) && $_SESSION['form']['disqual'] == 'No' ? 'selected' : '')?>>No</option>
                    </select>
                </div>

                <div class="col-sm-6 labright">
                    <label>Disqualification details:</label>
                </div>
                <div class="col-sm-10">
                    <input class="form-control input" name="disqualDetails" value="<?php if (isset($_SESSION['form']['disqualDetails'])) echo htmlspecialchars($_SESSION['form']['disqualDetails'], ENT_QUOTES); ?>" />
                </div>

                <div class="col-sm-6 labright">
                    <label>Digital Tachograph</label>
                </div>
                <div class="col-sm-10">
                    <select class="form-control input" name='tacho'>
                        <option value="" <?=(isset($_SESSION['form']['tacho']) && $_SESSION['form']['tacho'] == '' ? 'selected' : '')?>></option>
                        <option value="Yes" <?=(isset($_SESSION['form']['tacho']) && $_SESSION['form']['tacho'] == 'Yes' ? 'selected' : '')?>>Yes</option>
                        <option value="No" <?=(isset($_SESSION['form']['tacho']) && $_SESSION['form']['tacho'] == 'No' ? 'selected' : '')?>>No</option>
                    </select>
                </div>

                <div class="col-sm-6 labright">
                    <label>Other Qualifications:</label>
                </div>
                <div class="col-sm-10">
                    <input class="form-control input" name="other" value="<?php if (isset($_SESSION['form']['other'])) echo htmlspecialchars($_SESSION['form']['other'], ENT_QUOTES); ?>" />
                </div>
            </div>
        	
        	
        </fieldset>
	</div>
	</div>



    <div class="col-sm-5 col-md-5 col-lg-5">
    <div class="row">
    	<fieldset>
    		
    		<div class="col-sm-6 labright">
                <label for="transport">Transport:</label>
            </div>
            <div class="col-sm-10">
                <select class="form-control input" name='transport'>
                    <option value="" <?=(isset($_SESSION['form']['transport']) && $_SESSION['form']['transport'] == '' ? 'selected' : '')?>></option>
                    <option value="Yes" <?=(isset($_SESSION['form']['transport']) && $_SESSION['form']['transport'] == 'Yes' ? 'selected' : '')?>>Yes</option>
                    <option value="No" <?=(isset($_SESSION['form']['transport']) && $_SESSION['form']['transport'] == 'No' ? 'selected' : '')?>>No</option>
                </select>
        	</div>
        	<div class="col-sm-6 labright">
                <label for="preferHours">Prefered Hours:</label>
            </div>
            <div class="col-sm-10">
	            <input class="form-control input" name="preferHours" value="<?php if (isset($_SESSION['form']['preferHours'])) echo htmlspecialchars($_SESSION['form']['preferHours'], ENT_QUOTES); ?>" />
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
                <label for="salary">Salary:</label>
            </div>
            <div class="col-sm-10">
                <input class="form-control input" name="salary" value="<?php if (isset($_SESSION['form']['salary'])) echo htmlspecialchars($_SESSION['form']['salary'], ENT_QUOTES); ?>" />
            </div>

        	<div class="col-sm-16" style="height:20px;"></div>

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
	            	<a id="emailConfirm"><button id="email" name="" type="submit" class="btn btn-primary" style="width: 100%">Email</button></a>
	            </div>
            <?php } ?>
    	</fieldset>
    	</form>
        </div>
    </div>
    <div class="col-sm-1 col-md-1 col-lg-1"></div>
</div>
<script>
    $(document).ready(function (){
        var jobType = $("#jobType").val();
        if (jobType == "") {
            $("#extra").hide();
        }
        else if (jobType == "Industrial") {
            $("#extra").hide();
        }
        else if (jobType == "Driving") {
            $("#extra").show();
        }

        $("#jobType").change(function() {
            // foo is the id of the other select box 
            if ($(this).val() == "Industrial") {
                $("#extra").hide();
            }
            else if ($(this).val() == "Driving") {
                $("#extra").show();
            }
            else{
                $("#extra").hide();
            } 
        });
    });
</script>

<?php
if($_SESSION['login']['branchID'] == 27 ) {
	require_once $root.'/pages/footer.php';
}
?>