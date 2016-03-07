<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once $root.'/pages/header.php';

    include $root.'/assets/php/auth/remoteUsers.php';

	require_once $root.'/assets/php/class/Checkins.class.php';
    require_once $root.'/assets/php/class/Branches.class.php';

	$checkinsData = new Checkins();
    $branchData = new Branches();
	$recall = $checkinsData->recall($DBH);

	$currentPage = "checkins";
?>
<!-- Load common scripts and call specific scripts -->
<script src="/assets/js/custom/commonScripts.js"></script>
<script src="/assets/js/custom/callScripts.js"></script>
<script src="/assets/js/custom/searching.js"></script>
<script>
$(document).ready(function(){
    $('#clientResult').hide();
    $('body').click(function(){
        $('#clientResult').hide();
    })
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
<script type="text/javascript">var callType = 'Checkins';</script>

<!-- Start main content of the page -->
<div class="row form">
	<div class="col-sm-8 col-md-8 col-lg-5">
        
		<form method="POST" action="/assets/php/Checkins.php" role="form" class="form-horizontal" >
		    <div class="row">
        		<input class="hidden" type='hidden' id="callID" name='callID' value="<?php if (isset($_SESSION['form']['callID'])) echo $_SESSION['form']['callID']; ?>" />
    			<input class="hidden" type='hidden' name='type' value="Checkin" />
                
                <div class="col-sm-6 labright">
                    <label for="recall">Recall:</label>
                </div>
                <div class="col-sm-10">
    	            <select id="recall" class="form-control input">
    		            <option selected></option>
    		            <?php
                        if($_SESSION['login']['access'] == 2) {
        		            foreach ($recall as $key) {
        						echo '<option id='.$key['callID'].'>'.$key['completed'].' '.$key['branchName'].' - '.$key['clientName']. ' - ' .$key['emailed'].'</option>';
        					}
                        }
                        else {
                            foreach ($recall as $key) {
                                if($key['branchID'] == $_SESSION['login']['branchID']) {
                                    echo '<option id='.$key['callID'].'>'.$key['completed'].' '.$key['branchName'].' - '.$key['clientName']. ' - ' .$key['emailed'].'</option>';
                                } else {continue;}
                            }
                        }
    					?>
    		        </select>
    		    </div>
                <div class="col-sm-6 labright">
                    <label for="branchNameShort">Branch:</label>
                </div>
                <div class="col-sm-10">
                	<?php //require $root.'/assets/php/branchList.php'; ?>
                    <input class="form-control input" name="branchNameShort" id="branchNameShort" type="text" value="<?php $branchName = $branchData->branchDetailsID($DBH, $_SESSION['login']['branchID']); echo $branchName['branchNameShort']; ?>" readonly />
            	</div>

                <div class="col-sm-6 labright">
                    <label for="search">Client Search:</label>
                </div>
                <div class="col-sm-10">
                	<input type="text" name="clientSearch" id="clientSearch" class="form-control input" />
                    <div id="clientResult" style="z-index: 10000;">
                        <?php if(isset($_SESSION['form']['clientList'])) {
                            foreach ($_SESSION['form']['clientList'] as $key) { ?>
                                <p onclick="clientID($(this).attr('id'))" class="resultList" id="<?php echo $key['clientID']; ?>"><?php echo $key['clientName'].' - '.ucwords($key['firstName']).' '.ucwords($key['lastName']).' - '.$key['landline'].' - '.$key['mobile'].' - '.$key['postcode']; ?></p>
                        <?php } } ?>
                    </div>
                </div>   
  
                <div id="clientDetails">
                    <input class="form-control input" name="clientID" id="clientID" type="hidden" value="<?php if (isset($_SESSION['form']['clientID'])) echo $_SESSION['form']['clientID']; ?>" required />
                    <input class="form-control input" name="clientNameID" id="clientNameID" type="hidden" value="<?php if (isset($_SESSION['form']['clientNameID'])) echo $_SESSION['form']['clientNameID']; ?>" required />

                    <div class="col-sm-6 labright">
                        <label for="clientName">Client Name:</label>
                    </div>
                    <div class="col-sm-10">
                    	<input class="form-control input" name="clientName" id="clientName" type="text" value="<?php if (isset($_SESSION['form']['clientName'])) echo $_SESSION['form']['clientName']; ?>" required />
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
                    	<input class="form-control input letters" name="firstName" id="firstName" type="text" value="<?php if (isset($_SESSION['form']['firstName'])) echo $_SESSION['form']['firstName']; ?>" />
                	</div>

                    <div class="col-sm-6 labright">
                        <label for="lastName">Last Name:</label>
                    </div>
                    <div class="col-sm-10">
                    	<input class="form-control input letters" name="lastName" id="lastName" type="text" value="<?php if (isset($_SESSION['form']['lastName'])) echo $_SESSION['form']['lastName']; ?>" />
                	</div>

                    <div class="col-sm-6 labright">
                        <label for="landline">Landline:</label>
                    </div>
                    <div class="col-sm-10">
                    	<input class="form-control input number" name="landline" id="landline" type="text" value="<?php if (isset($_SESSION['form']['landline'])) echo $_SESSION['form']['landline']; ?>" />
                	</div>

                    <div class="col-sm-6 labright">
                        <label for="mobile">Mobile:</label>
                    </div>
                    <div class="col-sm-10">
                    	<input class="form-control input number" name="mobile" id="mobile" type="text" value="<?php if (isset($_SESSION['form']['mobile'])) echo $_SESSION['form']['mobile']; ?>" />
                	</div>
                </div>

                <div id="dateRange">
                    <div class="col-sm-6 labright">
                        <label for="datetime">Start Date/Time:</label>
                    </div>
                    <div class="col-sm-10">	
                    	<input class="form-control input datetime" name="dateToStart" value="<?php if (isset($_SESSION['form']['dateToStart'])) echo $_SESSION['form']['dateToStart']; ?>" readonly/>
                	</div>

                    <div class="col-sm-6 labright">
                        <label for="datetime">Finish Date/Time:</label>
                    </div>
                    <div class="col-sm-10"> 
                        <input class="form-control input" id="dateOnly" name="dateToFinish" value="<?php if (isset($_SESSION['form']['dateToFinish'])) echo $_SESSION['form']['dateToFinish']; ?>" />
                    </div>
                </div>
                
                <div class="col-sm-6 labright">
                    <label for="details">Details:</label>
                </div>
                <div class="col-sm-10">	
                	<textarea class="form-control input" rows="5" name=" details" id="details" type="text"><?php if (isset($_SESSION['form']['details'])) echo $_SESSION['form']['details']; ?></textarea>
            	</div>

                <div id="furtherActions">
                    <div class="col-sm-6 labright">
                        <label for="further">Further Actions:</label>
                    </div>
                    <div class="col-sm-10">   
                    	<textarea class="form-control input" rows="5" name="further" id="further" type="text"><?php if (isset($_SESSION['form']['further'])) echo $_SESSION['form']['further']; ?></textarea>
                	</div>
                </div>

                <div id="activeOption">
                    <div class="col-sm-6 labright">
                        <label for="active">Status:</label>
                    </div>
                    <div class="col-sm-10">
        	            <select class="form-control input" name='active' id="active">
                            <option value='' <?=(isset($_SESSION['form']['active']) && $_SESSION['form']['active'] == '' ? 'selected' : '')?>></option>
                            <option value='Inactive' <?=(isset($_SESSION['form']['active']) && $_SESSION['form']['active'] == 'Inactive' ? 'selected' : '')?>>Inactive</option>
                            <option value='Active' <?=(isset($_SESSION['form']['active']) && $_SESSION['form']['active'] == 'Active' ? 'selected' : '')?>>Active</option>
                        </select>
                	</div>
                </div>

                <!-- <input type="hidden" name="active" value="<?php if (isset($_SESSION['form']['active'])) echo $_SESSION['form']['active']; ?>"> -->
                <input type="hidden" name="checkCall" value="<?php if (isset($_SESSION['form']['checkinCallID'])) echo $_SESSION['form']['checkinCallID']; ?>">

                <div id="newButton">
                    <div class="col-sm-6 labright">
                	   <!-- <label for="submit"></label> -->
                    </div>
                    <div class="col-sm-10">
                    	<button name="branchAdd" class="btn btn-primary">Insert New Checkin</button>
                    </div>
                </div>

                <div id="updateButton">
                    <div class="col-sm-6 labright">
                        <label></label>
                    </div>
                    <div class="col-sm-10">
                        <button name="branchUpdate" class="btn btn-primary">Update</button>
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
    	            	<button id="email" name="" type="submit" class="btn btn-primary">Email</button>
    	            </div>
                <?php } ?>
                <div class="col-sm-6">
                   <!-- <label for="clear"></label> -->
                </div>
                <div class="col-sm-10">
                    <br /><p style="text-align: justify;">When inserting a new checkin please select both the date and the time from the start checkin field on the form.  If you do not select the time with the date then the checkin will be submitted with your current time not the time you want the checkin processing.</p>
                </div>
		</form>
        
        </div>
	</div>
	<div class="col-sm-8 col-md-8 col-lg-8">
		<div id="checkInSheet">
			<div id="checkOne" style="height: 400px; overflow: auto;">
			<h1>Stored Checkins</h1>
            <div class="running">
                <table id="running" style="width: 100%">
                    <th style="max-width: 8%">Call ID</th><th style="max-width: 25%">Client Name</th><th  class="checkinContacts" style="max-width: 12.5%">Landline</th><th  class="checkinContacts" style="max-width: 12.5%">Mobile</th><th style="max-width: 12%">State</th><th>Delete</th>
                        <tbody>
                        <?php
                            foreach ($checkinsData->storedCheckins($DBH, $_SESSION['login']['branchID']) as $key) { 
                                if ($key['dateToCall'] == "0000/00/00") {
                                    $dateToCall = "";
                                }
                                else {
                                    $dateToCall = date('d/m/Y', strtotime($key['dateToCall']));
                                }
                        ?>
                            <tr>
                                <td><span style="cursor: pointer" onClick="branchCheckinRecall(this.innerHTML);"><?php echo $key['callID']; ?></span></td>
                                
                                <td><?php echo $key['clientName']; ?></td>
                                <td class="checkinContacts"><?php echo $key['landline']; ?></td>
                                <td class="checkinContacts"><?php echo $key['mobile']; ?></td>
                                <td><?php echo $key['status']; ?></td>
                                <td><img id="<?php echo $key['callID']; ?>" class="deleteButton" src="/assets/img/del_icon.png" alt="Delete" /></td>
                            </tr>

                        <?php }; ?>
                    </tbody>
                </table>
            </div>
	   </div>

       <div id="checkOne" style="height: 400px; overflow: auto;">
            <h1>Active Checkins</h1>
            <div class="running">
                <table id="running" style="width: 100%">
                    <th style="max-width: 8%">Call ID</th><th style="max-width: 25%">Client Name</th><th style="max-width: 10%">Time/Date</th><th  class="checkinContacts" style="max-width: 12.5%">Landline</th><th  class="checkinContacts" style="max-width: 12.5%">Mobile</th><th style="max-width: 12%">State</th>
                        <tbody>
                        <?php
                            foreach ($checkinsData->runningCheckinsBranch($DBH, $_SESSION['login']['branchID']) as $key) { 
                                if ($key['dateToCall'] == "0000/00/00") {
                                    $dateToCall = "";
                                }
                                else {
                                    $dateToCall = date('d/m/Y', strtotime($key['dateToCall']));
                                }
                        ?>
                            <tr>
                                <td><span><?php echo $key['callID']; ?></span></td>
                                
                                <td><?php echo $key['clientName']; ?></td>
                                <td><?php echo date("H:i", strtotime($key['timeToCall'])).' - '.$dateToCall; ?></td>
                                <!-- <td><?php echo $dateToCall; ?></td> -->
                                <td class="checkinContacts"><?php echo $key['landline']; ?></td>
                                <td class="checkinContacts"><?php echo $key['mobile']; ?></td>
                                <td><?php echo $key['status']; ?></td>
                            </tr>

                        <?php }; ?>
                    </tbody>
                </table>
            </div>
       </div>

    </div>
    <div class="col-lg-3"></div>

    <!-- Script for deleting selected checkins -->
    <script>
        $(document).ready(function(){
            $('img').click(function(){
                var id = this.id;
                var type = "delete";
                console.log(id);
                $.ajax({                                     
                    url: '/assets/php/branchadmin/Checkins.php',
                    data: {id: id, type: type},
                    type: 'POST',
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

    <script type="text/javascript">
    //Script for showing and hiding relavent divs depending on the session variables stored on recall
        $(document).ready(function (){
            var id = $("#callID").val();
            console.log(id);
            $('#furtherActions').hide();
            if (id.length != 0) {
                $("#updateButton").show();
                $("#dateRange").show();
                $("#activeOption").show();  
                $("#newButton").hide();

            }
            else {
                $("#updateButton").hide();
                $("#dateRange").hide();
                $("#activeOption").hide();
                $("#newButton").show();
                $('#furtherActions').hide();
            }

        });
        </script>

<?php
	require_once $root.'/pages/footer.php';
?>