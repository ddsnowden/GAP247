<?php
    //Define root path
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
    //Include header
	require_once $root.'/pages/header.php';
    //Resrtrict to GAP24/7 Users
    include $root.'/assets/php/auth/branchUsers.php';
    //Include required classes
	require_once $root.'/assets/php/class/Checkins.class.php';
	$checkinsData = new Checkins();
    //Recall for existing calls
	$recall = $checkinsData->recall($DBH);
	$currentPage = "checkins";
?>
<!-- Load common scripts and call specific scripts -->
<script src="/assets/js/custom/commonScripts.js"></script>
<script src="/assets/js/custom/callScripts.js"></script>
<script src="/assets/js/custom/searching.js"></script>
<script type="text/javascript">var callType = 'Checkins';</script>
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
	<div class="col-sm-8 col-md-8 col-lg-5">
        
		<form method="POST" action="/assets/php/Checkins.php" role="form" class="form-horizontal" >
		    <div class="row">
        		<input class="hidden" type='hidden' id="callID" name='callID' value="<?php if (isset($_SESSION['form']['callID'])) echo htmlspecialchars($_SESSION['form']['callID'], ENT_QUOTES); ?>" />
    			<input class="hidden" type='hidden' name='type' value="Checkin" />
                
                <div class="col-sm-6 labright">
                    <label for="recall">Recall:</label>
                </div>
                <div class="col-sm-10">
    	            <select id="recall" class="form-control input">
    		            <option selected></option>
    		            <?php
    		            foreach ($recall as $key) {
    						echo '<option id='.htmlspecialchars($key['callID'], ENT_QUOTES).'>'.
                            htmlspecialchars($key['completed'], ENT_QUOTES).' '.
                            htmlspecialchars($key['branchName'], ENT_QUOTES).' - '.
                            htmlspecialchars($key['clientName'], ENT_QUOTES). ' - ' .
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
                    <label for="datetime">Date/Time:</label>
                </div>
                <div class="col-sm-10">	
                	<input class="form-control input" id="datetime" name="datetime" value="<?php if (isset($_SESSION['form']['datetime'])) echo htmlspecialchars($_SESSION['form']['datetime'], ENT_QUOTES); ?>" />
            	</div>

                <div class="col-sm-6 labright">
                    <label for="details">Details:</label>
                </div>
                <div class="col-sm-10">	
                	<textarea class="form-control input" rows="5" name=" details" id="details" type="text"><?php if (isset($_SESSION['form']['details'])) echo htmlspecialchars($_SESSION['form']['details'], ENT_QUOTES); ?></textarea>
            	</div>

                <div id="furtherActions">
                    <div class="col-sm-6 labright">
                        <label for="further">Further Actions:</label>
                    </div>
                    <div class="col-sm-10">   
                    	<textarea class="form-control input" rows="5" name="further" id="further" type="text"><?php if (isset($_SESSION['form']['further'])) echo htmlspecialchars($_SESSION['form']['further'], ENT_QUOTES); ?></textarea>
                	</div>
                </div>

                <div class="col-sm-6 labright">
                    <label for="status">Status:</label>
                </div>
                <div class="col-sm-10">
    	            <select class="form-control input" name='status' id="status" required>
    					<option value='' <?=(isset($_SESSION['form']['status']) && $_SESSION['form']['status'] == '' ? 'selected' : '')?>></option>
    					<option id="completed" value='Completed' <?=(isset($_SESSION['form']['status']) && $_SESSION['form']['status'] == 'Completed' ? 'selected' : '')?>>Completed</option>
    					<option value='Outstanding' <?=(isset($_SESSION['form']['status']) && $_SESSION['form']['status'] == 'Outstanding' ? 'selected' : '')?>>Outstanding</option>
    				</select>
            	</div>

                <input type="hidden" name="active" value="<?php if (isset($_SESSION['form']['active'])) echo htmlspecialchars($_SESSION['form']['active'], ENT_QUOTES); ?>">
                <input type="hidden" name="checkCall" value="<?php if (isset($_SESSION['form']['checkinCallID'])) echo htmlspecialchars($_SESSION['form']['checkinCallID'], ENT_QUOTES); ?>">

                <div id="insertButton">
                    <div class="col-sm-6 labright">
                	   <!-- <label for="submit"></label> -->
                    </div>
                    <div class="col-sm-10">
                    	<button name="nightAdd" class="btn btn-primary">Insert New Checkin</button>
                    </div>
                </div>

                <div id="submitButton">
                    <div class="col-sm-6 labright">
                       <!-- <label for="submit"></label> -->
                    </div>
                    <div class="col-sm-10">
                        <button name="nightSubmit" class="btn btn-primary">Submit</button>
                    </div>
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
	<div class="col-sm-8 col-md-8 col-lg-8">
		<div id="checkInSheet">
			<div id="checkOne" style="height: 800px; overflow: auto;">
			<h1>Todays Checkins</h1>
            <div class="running">
                <table id="running" style="width: 100%">
                    <th style="max-width: 8%">Call ID</th><th style="max-width: 20%">Branch</th><th style="max-width: 25%">Client Name</th><th style="max-width: 10%">Time/Date</th><th  class="checkinContacts" style="max-width: 12.5%">Landline</th><th  class="checkinContacts" style="max-width: 12.5%">Mobile</th><th style="max-width: 12%">State</th>
                        <tbody><?php
                            foreach ($checkinsData->runningCheckins($DBH) as $key) { 
                                if ($key['dateToCall'] == "0000/00/00") {
                                    $dateToCall = "";
                                }
                                else {
                                    $dateToCall = date('d/m/Y', strtotime($key['dateToCall']));
                                }
                        ?><tr>
                                <td><span style="cursor: pointer" onClick="slideRecall(this.innerHTML);"><?php echo htmlspecialchars($key['callID'], ENT_QUOTES); ?></span></td>
                                <td><?php $branch = explode('_', $key['branchNameShort']); 
                                        if(!empty(isset($branch[1]))) {
                                            echo htmlspecialchars($branch[1], ENT_QUOTES);
                                        }
                                        else {
                                            echo htmlspecialchars($branch[0], ENT_QUOTES);
                                        }
                                ?></td>
                                <td><?php echo htmlspecialchars($key['clientName'], ENT_QUOTES); ?></td>
                                <td><?php echo date("H:i", strtotime(htmlspecialchars($key['timeToCall'], ENT_QUOTES))).' - '.htmlspecialchars($dateToCall, ENT_QUOTES); ?></td>
                                <td class="checkinContacts"><?php echo htmlspecialchars($key['landline'], ENT_QUOTES); ?></td>
                                <td class="checkinContacts"><?php echo htmlspecialchars($key['mobile'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($key['status'], ENT_QUOTES); ?></td>
                            </tr><?php }; ?>
                    </tbody>
                </table>
            </div>
	   </div>

       <!-- <div id="checkOne" style="height: 400px; overflow: auto;">
            <h1>Blank Checkins</h1>
            <div class="running">
                <table id="running" style="width: 100%">
                    <th style="max-width: 8%">Call ID</th><th style="max-width: 20%">Branch</th><th style="max-width: 25%">Client Name</th><th style="max-width: 10%">Time/Date</th><th  class="checkinContacts" style="max-width: 12.5%">Landline</th><th  class="checkinContacts" style="max-width: 12.5%">Mobile</th><th style="max-width: 12%">State</th>
                        <tbody>
                        <?php
                            /*foreach ($checkinsData->blankCheckins($DBH) as $key) { 
                                if ($key['dateToCall'] == "0000/00/00") {
                                    $dateToCall = "";
                                }
                                else {
                                    $dateToCall = date('d/m/Y', strtotime($key['dateToCall']));
                                }*/
                        ?>
                            <tr>
                                <td><span style="cursor: pointer" onClick="slideRecall(this.innerHTML);"><?php //echo $key['callID']; ?></span></td>
                                <td>
                                <?php 
                                    /*$branch = explode('_', $key['branchNameShort']); 
                                    if(!empty(isset($branch[1]))) {
                                        echo $branch[1];
                                    }
                                    else {
                                        echo $branch[0];
                                    }*/
                                ?>
                                </td>
                                <td><?php //echo $key['clientName']; ?></td>
                                <td><?php //echo date("H:i", strtotime($key['timeToCall'])); ?></td>
                                <!-- <td><?php //echo $dateToCall; ?></td> .' - '$dateToCall-->
                                <!--<td class="checkinContacts"><?php //echo $key['landline']; ?></td>
                                <td class="checkinContacts"><?php //echo $key['mobile']; ?></td>
                                <td><?php //echo $key['status']; ?></td>
                            </tr>

                        <?php //}; ?>
                    </tbody>
                </table>
            </div>
       </div> -->

    </div>
    <div class="col-lg-3"></div>
    <script type="text/javascript">
        //Script for showing and hiding relavent divs depending on the session variables stored on recall
        $(document).ready(function (){
            if ($("#callID").val()=='') {
                $("#submitButton").hide();
                $("#furtherActions").hide();
                $("#completed").hide();
                $("#datetime").prop("readonly", false);
                $("#datetime").addClass("datetime");
            }
            else if ($("#callID").val()!='') {
                $("#insertButton").hide();
                $("#furtherActions").show();
                $("#datetime").prop("readonly", true);
                $("#datetime").removeClass("datetime");
            }
        });
    </script>
<?php
if($_SESSION['login']['branchID'] == 27 ) {
    require_once $root.'/pages/footer.php';
}
?>