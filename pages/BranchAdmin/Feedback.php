<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once $root.'/pages/header.php';

	include $root.'/assets/php/auth/remoteUsers.php';

	require_once $root.'/assets/php/class/Feedback.class.php';
	require_once $root.'/assets/php/class/Branches.class.php';
	
	$feedback = new Feedback();
	$branch = new Branches();
	$recall = $feedback->recall($DBH);
	$branch = $branch->branchDetailsID($DBH, $_SESSION['login']['branchID']);
?>
<style type="text/css">
	textarea {
		min-height: 400px;
	}
	.vresize {
  resize: vertical; 
}
</style>
<!-- Load common scripts and call specific scripts -->
<script src="/assets/js/custom/commonScripts.js"></script>
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
<script type="text/javascript">
//Capatilize each word in string
function capitalizeEachWord(str) {
    return str.replace(/\w\S*/g, function(txt) {
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    });
}

$(document).ready(function(){
	$('select[id=recall]').on('change', function() {var recallID = this.options[this.selectedIndex].id
		$.ajax({        
			url: '/assets/php/branchadmin/' + capitalizeEachWord(callType).replace(/ /g,'') + '.php',
			data: {recallID: recallID, callType: callType},
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

<!-- Value stored for defining current page -->
<script>
	var callType = "feedback";
</script>

<!-- Show and hide options depending on selection -->
<script>
    $(document).ready(function (){
    	$("#callID").hide();
        $("#complaintType").change(function() {
            if ($(this).val() == "procedure") {
                $("#callID").show();
            } 
            else {
            	$("#callID").hide();
            }


        });
    });
</script>

<!--This script populates the form from the recall list-->
<script>
	$(document).ready(function(){
		$('select[name=recall]').on('change', function() {var recallGet = this.options[this.selectedIndex].id
			$.ajax({                                     
				url: '../../php/branchadmin/feedback.php',
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

<!-- Start main content of the page -->
<div class="row">
	<div class="col-sm-3 col-md-3 col-lg-3"></div>

	<div class="col-sm-10 col-md-10 col-lg-10">
		<form id='form' action='/assets/php/branchadmin/Feedback.php' method='POST' role="form" class="form-horizontal" >
			<fieldset>
				<input class="hidden" type='hidden' name='feedID' value="<?php if (isset($_SESSION['form']['feedID'])) echo $_SESSION['form']['feedID']; ?>" />
				<input class="hidden" type='hidden' name='type' value="feedback" />
				
				<div class="col-sm-4 labright">
                    <label for="recall">Recall:</label>
                </div>
                <div class="col-sm-10">
    	            <select id="recall" class="form-control input">
    		            <option selected></option>
    		            <?php
    		            foreach ($recall as $key) {
							echo '<option id='.$key['feedID'].'>'.$key['feedID'].' - '.date("d-m-Y", strtotime($key['dateInputted'])).'/'.date("H:i:s", strtotime($key['timeInputted'])) . ' - ' .$key['branchNameShort']. ' - ' .$key['staffNameFirst'].' '.$key['staffNameLast'].' - '.$key['feedbackType'].'</option>';
						}
						?>
					</select>
				</div>
				<div class="col-sm-2"></div>
				
				<div class="col-sm-4 labright">
					<label for="nameFirst">First Name:</label>
				</div>
				<div class="col-sm-10">
					<input type='text' class="form-control input" name='nameFirst' placeholder='First Name' value="<?php if (isset($_SESSION['form']['staffNameFirst'])) { echo $_SESSION['form']['staffNameFirst']; } else { echo ucwords($_SESSION['login']['staffNameFirst']); } ?>" readonly/>
				</div>
				<div class="col-sm-2"></div>

				<div class="col-sm-4 labright">
					<label for="nameLast">Last Name:</label>
				</div>
				<div class="col-sm-10">
					<input type='text' class="form-control input" name='nameLast' placeholder='Last Name' value="<?php if (isset($_SESSION['form']['staffNameLast'])) { echo $_SESSION['form']['staffNameLast'];} else { echo $_SESSION['login']['staffNameLast']; } ?>" readonly/>
				</div>
				<div class="col-sm-2"></div>

				<div class="col-sm-4 labright">
					<label for="feedbackType">Feedback Type:</label>
				</div>
				<div class="col-sm-10">
					<select class="form-control input" name="feedbackType" id="feedbackType">
						<option value="" <?=(isset($_SESSION['form']['feedbackType']) && $_SESSION['form']['feedbackType'] == '' ? 'selected' : '')?>></option>
						<option value="complaint" <?=(isset($_SESSION['form']['feedbackType']) && $_SESSION['form']['feedbackType'] == 'complaint' ? 'selected' : '')?>>Complaints</option>
						<option value="systems" <?=(isset($_SESSION['form']['feedbackType']) && $_SESSION['form']['feedbackType'] == 'systems' ? 'selected' : '')?>>Systems Issues</option>
						<option value="suggest" <?=(isset($_SESSION['form']['feedbackType']) && $_SESSION['form']['feedbackType'] == 'suggest' ? 'selected' : '')?>>Suggestions</option>
						<option value="other" <?=(isset($_SESSION['form']['feedbackType']) && $_SESSION['form']['feedbackType'] == 'other' ? 'selected' : '')?>>Other</option>
					</select>
				</div>
				<div class="col-sm-2"></div>

				<!--  Suggestions -->
				<div id="procType">
					<div class="col-sm-4 labright">
						<label for="procType">Suggestion Type:</label>
					</div>
					<div class="col-sm-10">
						<select class="form-control input" name="procType" id="suggest">
							<option value="" <?=(isset($_SESSION['form']['procType']) && $_SESSION['form']['procType'] == '' ? 'selected' : '')?>></option>
							<option value="newService" <?=(isset($_SESSION['form']['procType']) && $_SESSION['form']['procType'] == 'newService' ? 'selected' : '')?>>New Service Ideas</option>
							<option value="newProc" <?=(isset($_SESSION['form']['procType']) && $_SESSION['form']['procType'] == 'newProc' ? 'selected' : '')?>>New Procedures</option>
							<option value="newOther" <?=(isset($_SESSION['form']['procType']) && $_SESSION['form']['procType'] == 'newOther' ? 'selected' : '')?>>Other Suggestions</option>
						</select>
					</div>
					<div class="col-sm-2"></div>
				</div>

				<!-- Complaints list -->
				<div id="complaint">
					<div class="col-sm-4 labright">
						<label for="complaintType">Complaint Type</label>
					</div>
					<div class="col-sm-10">
						<select class="form-control input" name="complaintType" id="complaintType">
							<option value="" <?=(isset($_SESSION['form']['complaintType']) && $_SESSION['form']['complaintType'] == '' ? 'selected' : '')?>></option>
							<option value="operator" <?=(isset($_SESSION['form']['complaintType']) && $_SESSION['form']['complaintType'] == 'operator' ? 'selected' : '')?>>Personnel Issues</option>
							<option value="procedure" <?=(isset($_SESSION['form']['complaintType']) && $_SESSION['form']['complaintType'] == 'procedure' ? 'selected' : '')?>>Procedural/Call Issues</option>
							<option value="otherIssue" <?=(isset($_SESSION['form']['complaintType']) && $_SESSION['form']['complaintType'] == 'otherIssue' ? 'selected' : '')?>>Other Issues</option>
						</select>
					</div>
					<div class="col-sm-2"></div>
				</div>

				<!-- Staff List -->
				<div id="staff">
					<div class="col-sm-4 labright">
						<label for="operator">Operator Name:</label>
					</div>
					<div class="col-sm-10">
						<select class="form-control input" id="operator" name="operator" >
							<option value="" <?=(isset($_SESSION['form']['operatorID']) && $_SESSION['form']['operatorID'] == '' ? 'selected' : '')?>></option>
							<?php foreach ($feedback->staffList($DBH) as $staff) {
								echo '<option value="'.$staff['staffID'].'"';
								if (isset($_SESSION['form']['operatorID']) && ($_SESSION['form']['operatorID'] == $staff['staffID'])) {echo 'selected'; };
								echo '>'.$staff['staffNameFirst'].' '.$staff['staffNameLast'].'</option>';
							}

							?>
						</select>
					</div>
					<div class="col-sm-2"></div>
				</div>

				<!-- Call ID -->
				<div id="callID">	
					<div class="col-sm-4 labright">
						<label for="callIDRef">Call ID:</label>
					</div>
					<div class="col-sm-10">
						<input class="form-control input" type='text' class='number' name='callIDRef' placeholder='Call ID Number' value="<?php if (isset($_SESSION['form']['callIDRef'])) echo $_SESSION['form']['callIDRef']; ?>"/>
					</div>
					<div class="col-sm-2"></div>
				</div>
					
				<div class="col-sm-4 labright">
					<label>Details:</label>
				</div>
				<div class="col-sm-10">
					<textarea class="form-control hresize"  name='details' placeholder='Enter Details Here...' ><?php if (isset($_SESSION['form']['details'])) echo $_SESSION['form']['details']; ?></textarea>
				</div>
				<div class="col-sm-2"></div>

				<input type="hidden" name="page" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
				
				<div class="col-sm-4 labright">
            	   <!-- <label for="submit"></label> -->
                </div>
                <div class="col-sm-10">
                	<button id="submit" name="submit" type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-2"></div>

                <div class="col-sm-4 labright">
                   <!-- <label for="clear"></label> -->
                </div>
                <div class="col-sm-10">
                	<a id="clearConfirm"><button name="" type="submit" class="btn btn-primary">Clear</button></a>
                </div>
                <div class="col-sm-2"></div>
			</fieldset>
		</form>
	</div>
	<div class="col-sm-3 col-md-3 col-lg-3"></div>
</div>

<script type="text/javascript">
//Script for showing and hiding relavent divs depending on the session variables stored on recall
$(document).ready(function (){
	var feedbackType = $("#feedbackType").val();
	
	if (feedbackType == "") {
		$("#complaint").hide();
		$("#procType").hide();
	}
	else if (feedbackType == "complaint") {
		$("#complaint").show();
		$("#procType").hide();
	}
	else if (feedbackType == "systems") {
		$("#complaint").hide();
		$("#procType").hide();
	}
	else if (feedbackType == "suggest") {
		$("#procType").show();
		$("#complaint").hide();
	}
	else if (feedbackType == "other") {
		$("#complaint").hide();
		$("#procType").hide();
	}

	var complaintType = $("#complaintType").val();

	if (complaintType == "") {
		$("#staff").hide();
		$("#callID").hide();
	}
	else if (complaintType == "operator") {
		$("#staff").show();
		$("#callID").hide();
	}
	else if (complaintType == "procedure") {
		$("#callID").show();
		$("#staff").hide();
	}
	else if (complaintType == "otherIssue") {
		$("#callID").hide();
		$("#staff").hide();
	}
});
</script>
<script type="text/javascript">
$(document).ready(function (){
	$("#feedbackType").change(function() {
		var feedbackType = $("#feedbackType").val();
	
	if (feedbackType == "") {
		$("#complaint").hide();
		$("#procType").hide();
	}
	else if (feedbackType == "complaint") {
		$("#complaint").show();
		$("#procType").hide();
	}
	else if (feedbackType == "systems") {
		$("#complaint").hide();
		$("#procType").hide();
		$("#callID").hide();
		$("#staff").hide();
	}
	else if (feedbackType == "suggest") {
		$("#procType").show();
		$("#complaint").hide();
		$("#callID").hide();
		$("#staff").hide();
	}
	else if (feedbackType == "other") {
		$("#complaint").hide();
		$("#callID").hide();
		$("#staff").hide();
		$("#procType").hide();
	}
	});
});
</script>
<script type="text/javascript">
$(document).ready(function (){
	$("#complaintType").change(function() {
		var complaintType = $("#complaintType").val();

	if (complaintType == "") {
		$("#staff").hide();
		$("#callID").hide();
	}
	else if (complaintType == "operator") {
		$("#staff").show();
		$("#callID").hide();
	}
	else if (complaintType == "procedure") {
		$("#callID").show();
		$("#staff").hide();
	}
	else if (complaintType == "otherIssue") {
		$("#callID").hide();
		$("#staff").hide();
	}
	});
});
</script>

<?php
if($_SESSION['login']['branchID'] == 27 ) {
    require_once $root.'/pages/footer.php';
}
?>