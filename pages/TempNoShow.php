<?php 
    //Define root path
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
    //Include header
	require_once $root.'/pages/header.php';
    //Resrtrict to GAP24/7 Users
    include $root.'/assets/php/auth/branchUsers.php';
    //Include required classes
	require_once $root.'/assets/php/class/TempNoShow.class.php';
    $noShowData = new TempNoShow();
    //Recall for existing calls
	$recall = $noShowData->recall($DBH);
	$currentPage = "tempnoshow";
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
<!-- Load common scripts and call specific scripts -->
<script src="/assets/js/custom/commonScripts.js"></script>
<script src="/assets/js/custom/callScripts.js"></script>
<script src="/assets/js/custom/searching.js"></script>

<script type="text/javascript">var callType = 'temp no show';</script>
<!-- Start main content of the page -->
<div class="row form">
	<div class="col-sm-8 col-md-8 col-lg-5">
        
		<form method="POST" action="/assets/php/TempNoShow.php" role="form" class="form-horizontal" >
		    <div class="row">
        		<input class="hidden" type='hidden' name='callID' value="<?php if (isset($_SESSION['form']['callID'])) echo htmlspecialchars($_SESSION['form']['callID'], ENT_QUOTES); ?>" />
    			<input class="hidden" type='hidden' name='type' value="Temp No Show" />
                
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
                            date("H:i:s", strtotime(htmlspecialchars($key['timeInputted'], ENT_QUOTES))). ' - ' .
                            htmlspecialchars($key['branchNameShort'], ENT_QUOTES).' - '.
                            htmlspecialchars($key['clientName'], ENT_QUOTES). ' - ' .
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
                    <label for="search">Client Search:</label>
                </div>
                <div class="col-sm-10">
                	<input type="text" name="clientSearch" id="clientSearch" class="form-control input" />
                    <div id="clientResult" style="z-index: 10000;">
                        <?php if(isset($_SESSION['form']['clientList'])) {
                            foreach ($_SESSION['form']['clientList'] as $key) { ?>
                                <p onclick="clientID($(this).attr('id'))" class="resultList" id="<?php echo htmlspecialchars($key['clientID'], ENT_QUOTES); ?>"><?php echo htmlspecialchars($key['clientName'], ENT_QUOTES).' - '.ucwords(htmlspecialchars($key['firstName'], ENT_QUOTES)).' '.ucwords(htmlspecialchars($key['lastName'], ENT_QUOTES)).' - '.htmlspecialchars($key['landline'], ENT_QUOTES).' - '.htmlspecialchars($key['mobile'], ENT_QUOTES).' - '.htmlspecialchars($key['postcode'], ENT_QUOTES); ?></p>
                        <?php } } ?>
                    </div>
                </div>   

                <div id="clientDetails">
                    <input class="form-control input" name="clientID" id="clientID" type="hidden" value="<?php if (isset($_SESSION['form']['clientID'])) echo htmlspecialchars($_SESSION['form']['clientID'], ENT_QUOTES); ?>" required />
                    <input class="form-control input" name="clientNameID" id="clientNameID" type="hidden" value="<?php if (isset($_SESSION['form']['clientNameID'])) echo htmlspecialchars($_SESSION['form']['clientNameID'], ENT_QUOTES); ?>" required />

                    <div class="col-sm-6 labright">
                        <label for="clientName">Client Name:</label>
                    </div>
                    <div class="col-sm-10">
                    	<input class="form-control input" name="clientName" id="clientName" type="text" value="<?php if (isset($_SESSION['form']['clientName'])) echo htmlspecialchars($_SESSION['form']['clientName'], ENT_QUOTES); ?>" required />
                	</div>

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
                    <label>No Shows:</label>
                </div>
                <div class="col-sm-10"> 
                    <select name='noQuantity' id="noQuantity" class="form-control input" required>
                        <option value='' <?=(isset($_SESSION['form']['noQuantity']) && $_SESSION['form']['noQuantity'] == '' ? 'selected' : '')?>></option>
                        <?php
                            for ($i=1; $i < 25; $i++) { ?>
                                <option value='<?php echo $i; ?>' <?=(isset($_SESSION['form']['noQuantity']) && $_SESSION['form']['noQuantity'] == $i ? 'selected' : '') ?>><?php echo $i; ?></option>;
                        <?php }
                        ?>
                    </select>
                </div>

                <div class="col-sm-6 labright">
                    <label for="datetime">Date/Time:</label>
                </div>
                <div class="col-sm-10"> 
                    <input class="form-control input datetime" name="datetime" value="<?php if (isset($_SESSION['form']['datetime'])) echo htmlspecialchars($_SESSION['form']['datetime'], ENT_QUOTES); ?>" required/>
                </div>

                <div class="col-sm-6 labright">
                    <label>Positions filled:</label>
                </div>
                <div class="col-sm-10">
                    <select name='fillQuantity' id="fillQuantity" class="form-control input" required>
                        <option value='' <?=(isset($_SESSION['form']['fillQuantity']) && $_SESSION['form']['fillQuantity'] == '' ? 'selected' : '')?>></option>
                        <?php
                        for ($j=0; $j < 25; $j++) { ?>
                            <option value='<?php echo $j; ?>' <?=(isset($_SESSION['form']['fillQuantity']) && $_SESSION['form']['fillQuantity'] == $j ? 'selected' : '') ?>><?php echo $j; ?></option>;
                    <?php }
                    ?>
                    </select>
                </div>

                <div class="col-sm-6 labright">
                    <label for="details">Details:</label>
                </div>
                <div class="col-sm-10">	
                	<textarea class="form-control input" rows="5" name=" details" id="details" type="text"><?php if (isset($_SESSION['form']['details'])) echo htmlspecialchars($_SESSION['form']['details'], ENT_QUOTES); ?></textarea>
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
                	<button id="submit" name="submit" type="submit" class="btn btn-primary">Submit</button>
                </div>

                <div class="col-sm-6 labright">
                   <!-- <label for="clear"></label> -->
                </div>
                <div class="col-sm-10">
                	<a id="clearConfirm"><button name="" type="submit" class="btn btn-primary">Clear</button></a>
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
            </div>
		</form>
	</div>
	<div class="col-sm-8 col-md-8 col-lg-6" id="procDisp"></div>
    <div class="col-lg-5"></div>
</div>

<?php
if($_SESSION['login']['branchID'] == 27 ) {
    require_once $root.'/pages/footer.php';
}
?>