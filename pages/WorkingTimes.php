<?php
    //Define root path
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
    //Include header
	require_once $root.'/pages/header.php';
    //Resrtrict to GAP24/7 Users
    include $root.'/assets/php/auth/branchUsers.php';
    //Include required classes
	require_once $root.'/assets/php/class/WorkingTimes.class.php';
	$workingData = new WorkingTimes();
    //Recall for existing calls
	$recall = $workingData->recall($DBH);
    $clientList = $workingData->clientList($DBH);
	$currentPage = "working times";
?>
<!-- Load common scripts and call specific scripts -->
<script src="/assets/js/custom/commonScripts.js"></script>
<script src="/assets/js/custom/callScripts.js"></script>
<!-- <script src="/assets/js/custom/searching.js"></script> -->
<!-- Start Open Web Analytics Tracker -->
<script type="text/javascript">
//<![CDATA[
/*var owa_baseUrl = 'http://nightline/assets/Open-Web-Analytics/';
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
}());*/
//]]>
</script>
<!-- End Open Web Analytics Code -->
<script type="text/javascript">var callType = 'working times';</script>

<!-- Start main content of the page -->
<div class="row form">
	<div class="col-sm-8 col-md-8 col-lg-5">
        <div class="row">
		<form method="POST" action="/assets/php/WorkingTimes.php" role="form" class="form-horizontal" >
		    <fieldset>
        		<input class="hidden" type='hidden' name='callID' value="<?php if (isset($_SESSION['form']['callID'])) echo htmlspecialchars($_SESSION['form']['callID'], ENT_QUOTES); ?>" />
    			<input class="hidden" type='hidden' name='type' value="working times" />
                
                <div class="col-sm-6 labright">
                    <label for="recall">Recall:</label>
                </div>
                <div class="col-sm-10">
    	            <select id="recall" class="form-control input">
    		            <option selected></option>
    		            <?php
    		            foreach ($recall as $key) {
    						echo '<option id='.htmlspecialchars($key['callID'], ENT_QUOTES).'>'.
                            htmlspecialchars(date("d-m-Y", strtotime($key['dateInputted'], ENT_QUOTES))).'/'.
                            htmlspecialchars(date("H:i:s", strtotime($key['timeInputted'], ENT_QUOTES))) . ' - ' .
                            htmlspecialchars($key['branchNameShort'], ENT_QUOTES).' - '.
                            htmlspecialchars($key['firstName'], ENT_QUOTES).' '.
                            htmlspecialchars($key['lastName'], ENT_QUOTES).' - ' .
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
                </div>      

                <div class="col-sm-6 labright">
                    <label for="mobile">Monday:</label>
                </div>

                <div class="col-sm-5">
                	<input class="form-control input" type="text" list='clients' name="monclient" placeholder='Client' value="<?php if (isset($_SESSION['form']['monclient'])) echo htmlspecialchars($_SESSION['form']['monclient'], ENT_QUOTES); ?>" />
					<datalist id='clients'>
						<option selected></option>
							<?php
								foreach ($clientList as $key) {
										echo '<option>'.htmlspecialchars($key['clientName'], ENT_QUOTES).'</option>';
									}
							?>
					</datalist>
                </div>
            	<div class="col-sm-5">
                	<select class="form-control input" id="type" name="montype">
						<option value="" <?=(isset($_SESSION['form']['montype']) && $_SESSION['form']['montype'] == '' ? 'selected' : '')?>></option>
						<option value="class1" <?=(isset($_SESSION['form']['montype']) && $_SESSION['form']['montype'] == 'class1' ? 'selected' : '')?>>HGV Class 1</option>
						<option value="class2" <?=(isset($_SESSION['form']['montype']) && $_SESSION['form']['montype'] == 'class2' ? 'selected' : '')?>>HGV Class 2</option>
						<option value="75t" <?=(isset($_SESSION['form']['montype']) && $_SESSION['form']['montype'] == '75t' ? 'selected' : '')?>>7.5 Tonne</option>
						<option value="35t" <?=(isset($_SESSION['form']['montype']) && $_SESSION['form']['montype'] == '35t' ? 'selected' : '')?>>3.5 Tonne</option>
						<option value="mate" <?=(isset($_SESSION['form']['montype']) && $_SESSION['form']['montype'] == 'mate' ? 'selected' : '')?>>Drivers Mate</option>
						<option value="special" <?=(isset($_SESSION['form']['montype']) && $_SESSION['form']['montype'] == 'special' ? 'selected' : '')?>>Specialist Driver</option>
					</select>
            	</div>
            	<div class="col-sm-6 labright">
                    <label for="mobile"></label>
                </div>
            	<div class="col-sm-5">
                	<input class="form-control input timeOnly" name="monstart" placeholder="Start" value="<?php if (isset($_SESSION['form']['monstart'])) echo htmlspecialchars($_SESSION['form']['monstart'], ENT_QUOTES); ?>"/>
            	</div>
            	<div class="col-sm-5">
                	<input class="form-control input timeOnly" name="monfinish" placeholder="Finish" value="<?php if (isset($_SESSION['form']['monfinish'])) echo htmlspecialchars($_SESSION['form']['monfinish'], ENT_QUOTES); ?>"/>
            	</div>

            	<div class="col-sm-6 labright">
                    <label for="mobile">Tuesday:</label>
                </div>
                <div class="col-sm-5">
                	<input class="form-control input" type="text" list='clients' name="tueclient" placeholder='Client' value="<?php if (isset($_SESSION['form']['tueclient'])) echo htmlspecialchars($_SESSION['form']['tueclient'], ENT_QUOTES); ?>" />
					<datalist id='clients'>
						<option selected></option>
							<?php
								foreach ($clientList as $key) {
										echo '<option>'.htmlspecialchars($key['clientName'], ENT_QUOTES).'</option>';
									}
							?>
					</datalist>
            	</div>
            	<div class="col-sm-5">
                	<select class="form-control input" id="type" name="tuetype">
						<option value="" <?=(isset($_SESSION['form']['tuetype']) && $_SESSION['form']['tuetype'] == '' ? 'selected' : '')?>></option>
						<option value="class1" <?=(isset($_SESSION['form']['tuetype']) && $_SESSION['form']['tuetype'] == 'class1' ? 'selected' : '')?>>HGV Class 1</option>
						<option value="class2" <?=(isset($_SESSION['form']['tuetype']) && $_SESSION['form']['tuetype'] == 'class2' ? 'selected' : '')?>>HGV Class 2</option>
						<option value="75t" <?=(isset($_SESSION['form']['tuetype']) && $_SESSION['form']['tuetype'] == '75t' ? 'selected' : '')?>>7.5 Tonne</option>
						<option value="35t" <?=(isset($_SESSION['form']['tuetype']) && $_SESSION['form']['tuetype'] == '35t' ? 'selected' : '')?>>3.5 Tonne</option>
						<option value="mate" <?=(isset($_SESSION['form']['tuetype']) && $_SESSION['form']['tuetype'] == 'mate' ? 'selected' : '')?>>Drivers Mate</option>
						<option value="special" <?=(isset($_SESSION['form']['tuetype']) && $_SESSION['form']['tuetype'] == 'special' ? 'selected' : '')?>>Specialist Driver</option>
					</select>
            	</div>
            	<div class="col-sm-6 labright">
                    <label for="mobile"></label>
                </div>
            	<div class="col-sm-5">
                	<input class="form-control input timeOnly" name="tuestart" placeholder="Start" value="<?php if (isset($_SESSION['form']['tuestart'])) echo htmlspecialchars($_SESSION['form']['tuestart'], ENT_QUOTES); ?>"/>
            	</div>
            	<div class="col-sm-5">
                	<input class="form-control input timeOnly" name="tuefinish" placeholder="Finish" value="<?php if (isset($_SESSION['form']['tuefinish'])) echo htmlspecialchars($_SESSION['form']['tuefinish'], ENT_QUOTES); ?>"/>
            	</div>

            	<div class="col-sm-6 labright">
                    <label for="mobile">Wednesday:</label>
                </div>
                <div class="col-sm-5">
                	<input class="form-control input" type="text" list='clients' name="wedclient" placeholder='Client' value="<?php if (isset($_SESSION['form']['wedclient'])) echo htmlspecialchars($_SESSION['form']['wedclient'], ENT_QUOTES); ?>" />
					<datalist id='clients'>
						<option selected></option>
							<?php
								foreach ($clientList as $key) {
										echo '<option>'.htmlspecialchars($key['clientName'], ENT_QUOTES).'</option>';
									}
							?>
					</datalist>
            	</div>
            	<div class="col-sm-5">
                	<select class="form-control input" id="type" name="wedtype">
						<option value="" <?=(isset($_SESSION['form']['wedtype']) && $_SESSION['form']['wedtype'] == '' ? 'selected' : '')?>></option>
						<option value="class1" <?=(isset($_SESSION['form']['wedtype']) && $_SESSION['form']['wedtype'] == 'class1' ? 'selected' : '')?>>HGV Class 1</option>
						<option value="class2" <?=(isset($_SESSION['form']['wedtype']) && $_SESSION['form']['wedtype'] == 'class2' ? 'selected' : '')?>>HGV Class 2</option>
						<option value="75t" <?=(isset($_SESSION['form']['wedtype']) && $_SESSION['form']['wedtype'] == '75t' ? 'selected' : '')?>>7.5 Tonne</option>
						<option value="35t" <?=(isset($_SESSION['form']['wedtype']) && $_SESSION['form']['wedtype'] == '35t' ? 'selected' : '')?>>3.5 Tonne</option>
						<option value="mate" <?=(isset($_SESSION['form']['wedtype']) && $_SESSION['form']['wedtype'] == 'mate' ? 'selected' : '')?>>Drivers Mate</option>
						<option value="special" <?=(isset($_SESSION['form']['wedtype']) && $_SESSION['form']['wedtype'] == 'special' ? 'selected' : '')?>>Specialist Driver</option>
					</select>
            	</div>
            	<div class="col-sm-6 labright">
                    <label for="mobile"></label>
                </div>
            	<div class="col-sm-5">
                	<input class="form-control input timeOnly" name="wedstart" placeholder="Start" value="<?php if (isset($_SESSION['form']['wedstart'])) echo htmlspecialchars($_SESSION['form']['wedstart'], ENT_QUOTES); ?>"/>
            	</div>
            	<div class="col-sm-5">
                	<input class="form-control input timeOnly" name="wedfinish" placeholder="Finish" value="<?php if (isset($_SESSION['form']['wedfinish'])) echo htmlspecialchars($_SESSION['form']['wedfinish'], ENT_QUOTES); ?>"/>
            	</div>

            	<div class="col-sm-6 labright">
                    <label for="mobile">Thursday:</label>
                </div>
                <div class="col-sm-5">
                	<input class="form-control input" type="text" list='clients' name="thuclient" placeholder='Client' value="<?php if (isset($_SESSION['form']['thuclient'])) echo htmlspecialchars($_SESSION['form']['thuclient'], ENT_QUOTES); ?>" />
					<datalist id='clients'>
						<option selected></option>
							<?php
								foreach ($clientList as $key) {
										echo '<option>'.htmlspecialchars($key['clientName'], ENT_QUOTES).'</option>';
									}
							?>
					</datalist>
            	</div>
            	<div class="col-sm-5">
                	<select class="form-control input" id="type" name="thutype">
						<option value="" <?=(isset($_SESSION['form']['thutype']) && $_SESSION['form']['thutype'] == '' ? 'selected' : '')?>></option>
						<option value="class1" <?=(isset($_SESSION['form']['thutype']) && $_SESSION['form']['thutype'] == 'class1' ? 'selected' : '')?>>HGV Class 1</option>
						<option value="class2" <?=(isset($_SESSION['form']['thutype']) && $_SESSION['form']['thutype'] == 'class2' ? 'selected' : '')?>>HGV Class 2</option>
						<option value="75t" <?=(isset($_SESSION['form']['thutype']) && $_SESSION['form']['thutype'] == '75t' ? 'selected' : '')?>>7.5 Tonne</option>
						<option value="35t" <?=(isset($_SESSION['form']['thutype']) && $_SESSION['form']['thutype'] == '35t' ? 'selected' : '')?>>3.5 Tonne</option>
						<option value="mate" <?=(isset($_SESSION['form']['thutype']) && $_SESSION['form']['thutype'] == 'mate' ? 'selected' : '')?>>Drivers Mate</option>
						<option value="special" <?=(isset($_SESSION['form']['thutype']) && $_SESSION['form']['thutype'] == 'special' ? 'selected' : '')?>>Specialist Driver</option>
					</select>
            	</div>
            	<div class="col-sm-6 labright">
                    <label for="mobile"></label>
                </div>
            	<div class="col-sm-5">
                	<input class="form-control input timeOnly" name="thustart" placeholder="Start" value="<?php if (isset($_SESSION['form']['thustart'])) echo htmlspecialchars($_SESSION['form']['thustart'], ENT_QUOTES); ?>"/>
            	</div>
            	<div class="col-sm-5">
                	<input class="form-control input timeOnly" name="thufinish" placeholder="Finish" value="<?php if (isset($_SESSION['form']['thufinish'])) echo htmlspecialchars($_SESSION['form']['thufinish'], ENT_QUOTES); ?>"/>
            	</div>

            	<div class="col-sm-6 labright">
                    <label for="mobile">Friday:</label>
                </div>
                <div class="col-sm-5">
                	<input class="form-control input" type="text" list='clients' name="friclient" placeholder='Client' value="<?php if (isset($_SESSION['form']['friclient'])) echo htmlspecialchars($_SESSION['form']['friclient'], ENT_QUOTES); ?>" />
					<datalist id='clients'>
						<option selected></option>
							<?php
								foreach ($clientList as $key) {
										echo '<option>'.htmlspecialchars($key['clientName'], ENT_QUOTES).'</option>';
									}
							?>
					</datalist>
            	</div>
            	<div class="col-sm-5">
                	<select class="form-control input" id="type" name="fritype">
						<option value="" <?=(isset($_SESSION['form']['fritype']) && $_SESSION['form']['fritype'] == '' ? 'selected' : '')?>></option>
						<option value="class1" <?=(isset($_SESSION['form']['fritype']) && $_SESSION['form']['fritype'] == 'class1' ? 'selected' : '')?>>HGV Class 1</option>
						<option value="class2" <?=(isset($_SESSION['form']['fritype']) && $_SESSION['form']['fritype'] == 'class2' ? 'selected' : '')?>>HGV Class 2</option>
						<option value="75t" <?=(isset($_SESSION['form']['fritype']) && $_SESSION['form']['fritype'] == '75t' ? 'selected' : '')?>>7.5 Tonne</option>
						<option value="35t" <?=(isset($_SESSION['form']['fritype']) && $_SESSION['form']['fritype'] == '35t' ? 'selected' : '')?>>3.5 Tonne</option>
						<option value="mate" <?=(isset($_SESSION['form']['fritype']) && $_SESSION['form']['fritype'] == 'mate' ? 'selected' : '')?>>Drivers Mate</option>
						<option value="special" <?=(isset($_SESSION['form']['fritype']) && $_SESSION['form']['fritype'] == 'special' ? 'selected' : '')?>>Specialist Driver</option>
					</select>
            	</div>
            	<div class="col-sm-6 labright">
                    <label for="mobile"></label>
                </div>
            	<div class="col-sm-5">
                	<input class="form-control input timeOnly" name="fristart" placeholder="Start" value="<?php if (isset($_SESSION['form']['fristart'])) echo htmlspecialchars($_SESSION['form']['fristart'], ENT_QUOTES); ?>"/>
            	</div>
            	<div class="col-sm-5">
                	<input class="form-control input timeOnly" name="frifinish" placeholder="Finish" value="<?php if (isset($_SESSION['form']['frifinish'])) echo htmlspecialchars($_SESSION['form']['frifinish'], ENT_QUOTES); ?>"/>
            	</div>

            	<div class="col-sm-6 labright">
                    <label for="mobile">Saturday:</label>
                </div>
                <div class="col-sm-5">
                	<input class="form-control input" type="text" list='clients' name="satclient" placeholder='Client' value="<?php if (isset($_SESSION['form']['satclient'])) echo htmlspecialchars($_SESSION['form']['satclient'], ENT_QUOTES); ?>" />
					<datalist id='clients'>
						<option selected></option>
							<?php
								foreach ($clientList as $key) {
										echo '<option>'.htmlspecialchars($key['clientName'], ENT_QUOTES).'</option>';
									}
							?>
					</datalist>
            	</div>
            	<div class="col-sm-5">
                	<select class="form-control input" id="type" name="sattype">
						<option value="" <?=(isset($_SESSION['form']['sattype']) && $_SESSION['form']['sattype'] == '' ? 'selected' : '')?>></option>
						<option value="class1" <?=(isset($_SESSION['form']['sattype']) && $_SESSION['form']['sattype'] == 'class1' ? 'selected' : '')?>>HGV Class 1</option>
						<option value="class2" <?=(isset($_SESSION['form']['sattype']) && $_SESSION['form']['sattype'] == 'class2' ? 'selected' : '')?>>HGV Class 2</option>
						<option value="75t" <?=(isset($_SESSION['form']['sattype']) && $_SESSION['form']['sattype'] == '75t' ? 'selected' : '')?>>7.5 Tonne</option>
						<option value="35t" <?=(isset($_SESSION['form']['sattype']) && $_SESSION['form']['sattype'] == '35t' ? 'selected' : '')?>>3.5 Tonne</option>
						<option value="mate" <?=(isset($_SESSION['form']['sattype']) && $_SESSION['form']['sattype'] == 'mate' ? 'selected' : '')?>>Drivers Mate</option>
						<option value="special" <?=(isset($_SESSION['form']['sattype']) && $_SESSION['form']['sattype'] == 'special' ? 'selected' : '')?>>Specialist Driver</option>
					</select>
            	</div>
            	<div class="col-sm-6 labright">
                    <label for="mobile"></label>
                </div>
            	<div class="col-sm-5">
                	<input class="form-control input timeOnly" name="satstart" placeholder="Start" value="<?php if (isset($_SESSION['form']['satstart'])) echo htmlspecialchars($_SESSION['form']['satstart'], ENT_QUOTES); ?>"/>
            	</div>
            	<div class="col-sm-5">
                	<input class="form-control input timeOnly" name="satfinish" placeholder="Finish" value="<?php if (isset($_SESSION['form']['satfinish'])) echo htmlspecialchars($_SESSION['form']['satfinish'], ENT_QUOTES); ?>"/>
            	</div>

            	<div class="col-sm-6 labright">
                    <label for="mobile">Sunday:</label>
                </div>
                <div class="col-sm-5">
                	<input class="form-control input" type="text" list='clients' name="sunclient" placeholder='Client' value="<?php if (isset($_SESSION['form']['sunclient'])) echo htmlspecialchars($_SESSION['form']['sunclient'], ENT_QUOTES); ?>" />
					<datalist id='clients'>
						<option selected></option>
							<?php
								foreach ($clientList as $key) {
										echo '<option>'.htmlspecialchars($key['clientName'], ENT_QUOTES).'</option>';
									}
							?>
					</datalist>
            	</div>
            	<div class="col-sm-5">
                	<select class="form-control input" id="type" name="suntype">
						<option value="" <?=(isset($_SESSION['form']['suntype']) && $_SESSION['form']['suntype'] == '' ? 'selected' : '')?>></option>
						<option value="class1" <?=(isset($_SESSION['form']['suntype']) && $_SESSION['form']['suntype'] == 'class1' ? 'selected' : '')?>>HGV Class 1</option>
						<option value="class2" <?=(isset($_SESSION['form']['suntype']) && $_SESSION['form']['suntype'] == 'class2' ? 'selected' : '')?>>HGV Class 2</option>
						<option value="75t" <?=(isset($_SESSION['form']['suntype']) && $_SESSION['form']['suntype'] == '75t' ? 'selected' : '')?>>7.5 Tonne</option>
						<option value="35t" <?=(isset($_SESSION['form']['suntype']) && $_SESSION['form']['suntype'] == '35t' ? 'selected' : '')?>>3.5 Tonne</option>
						<option value="mate" <?=(isset($_SESSION['form']['suntype']) && $_SESSION['form']['suntype'] == 'mate' ? 'selected' : '')?>>Drivers Mate</option>
						<option value="special" <?=(isset($_SESSION['form']['suntype']) && $_SESSION['form']['suntype'] == 'special' ? 'selected' : '')?>>Specialist Driver</option>
					</select>
            	</div>
            	<div class="col-sm-6 labright">
                    <label for="mobile"></label>
                </div>
            	<div class="col-sm-5">
                	<input class="form-control input timeOnly" name="sunstart" placeholder="Start" value="<?php if (isset($_SESSION['form']['sunstart'])) echo htmlspecialchars($_SESSION['form']['sunstart'], ENT_QUOTES); ?>"/>
            	</div>
            	<div class="col-sm-5">
                	<input class="form-control input timeOnly" name="sunfinish" placeholder="Finish" value="<?php if (isset($_SESSION['form']['sunfinish'])) echo htmlspecialchars($_SESSION['form']['sunfinish'], ENT_QUOTES); ?>"/>
            	</div>
			</fieldset>
		</div>
	</div>
	<div class="col-sm-8 col-md-8 col-lg-5 form" >
        <div class="row">
    		<fieldset>
                    <div class="col-sm-6 labright">
                        <label for="details">Details:</label>
                    </div>
                    <div class="col-sm-10">	
                    	<textarea class="form-control input" rows="5" name="details" id="details" type="text"><?php if (isset($_SESSION['form']['details'])) echo $_SESSION['form']['details']; ?></textarea>
                	</div>

                    <div class="col-sm-6 labright">
                        <label for="further">Further Actions:</label>
                    </div>
                    <div class="col-sm-10">   
                    	<textarea class="form-control input" rows="5" name="further" id="further" type="text"><?php if (isset($_SESSION['form']['further'])) echo $_SESSION['form']['further']; ?></textarea>
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
                    </div>
                    <div class="col-sm-10">
                    	<button id="submit" name="submit" type="submit" class="btn btn-primary" style="width: 100%">Submit</button>
                    </div>

                    <div class="col-sm-6 labright">
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
                </div>
    		</form>
    	</div>
    <div class="col-lg-6" id="procDisp"></div>
</div>

<?php
if($_SESSION['login']['branchID'] == 27 ) {
    require_once $root.'/pages/footer.php';
}
?>