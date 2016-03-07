<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once $root.'/pages/header.php';

	// include $root.'/assets/php/auth/remoteUsers.php';

	require_once $root.'/assets/php/class/OnCall.class.php';
	require_once $root.'/assets/php/class/Branches.class.php';

	$oncall = new OnCall();
	$branch = new Branches();
	
	$list = $branch->branchList($DBH);

	if($_SESSION['login']['access'] != 2) {
		$branchOncall = $oncall->oncallList($DBH, $_SESSION['login']['branchID']);
	}
	else {
		if((isset($_SESSION['form']['OnCallRecall']) && ($_SESSION['form']['OnCallRecall'] != ''))) {
			$branchOncall = $_SESSION['form']['OnCallRecall'];
		}
		else {
			$branchOncall = $oncall->oncallList($DBH, $_SESSION['login']['branchID']);
		}
	}

	if($_SESSION['login']['access'] == 2) {
		$branchDetailsAdmin = $branchOncall[0]['branchNameShort'];
	}
	else {
		$branchDetails = $branch->branchDetailsID($DBH, $_SESSION['login']['branchID']);
	}
?>
<!-- Load common scripts and call specific scripts -->
<script src="/assets/js/custom/commonScripts.js"></script>
<script src="/assets/js/custom/callScripts.js"></script>
<script src="/assets/js/custom/searching.js"></script>
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
<script type="text/javascript">var callType = 'OnCall';</script>

<script>
	$(document).ready(function() {
	   	$('select[id=branchSelect]').on('change', function() {var branchGet = this.options[this.selectedIndex].value
			$.ajax({                                     
				url: '/assets/php/branchadmin/OnCallRecall.php',
				data: {branchGet: branchGet},
				type: 'POST',
				dataType: 'json',
				success: function(data)
				{
					if(data){
        				window.location.href = data;
    				}
				}
		  	});
		});
	});
</script>
<!-- Start main content of the page -->
<div class="row">
	<div class="col-sm-3 col-md-3 col-lg-3">
	<br /><br />
		<form>
			<fieldset>
				<div class="col-sm-6 labright">
                    <label for="branchSelect">Branch:</label>
                </div>
                <div class="col-sm-10">
    	            <select class="form-control input" name='branchSelect' id="branchSelect">
    	            	<option value='' ></option>
    	            	<?php foreach ($list as $key) { ?>
    						<option value='<?php echo $key['branchID']; ?>' ><?php echo $key['branchName']; ?></option>
    					<?php } ?>
    				</select>
            	</div>
			</fieldset>
		</form>
	</div>

	<div class="col-sm-10 col-md-10 col-lg-10">
		<div>
			<form class="oncall" action='/assets/php/branchadmin/OnCall.php' method='POST'>
				<fieldset>
					<table>
						<th></th><th></th><th>Employee First Name</th><th>Employee Last Name</th><th>Contact Number</th><th>Branch</th><th>In Use</th><?php if($_SESSION['login']['access'] == 2) { ?><th>Last Changed</th><?php } ?>
						<tbody>
						<?php $c = 0; 
							foreach ($branchOncall as $key) { $c++; ?>
							<tr>
								<td><input class="form-control input" type="hidden" name="count[]" value="<?php echo $c; ?>"></td>
								<td><input class="form-control input" type="hidden" id="ID" name="ID[]" value="<?php echo $key['contactID']; ?>" /></td>
								<td><input class="form-control input" type="text" id="nameFirst" name="nameFirst[]" value="<?php echo $key['contactNameFirst']; ?>" /></td>
								<td><input class="form-control input" type="text" id="nameLast" name="nameLast[]" value="<?php echo $key['contactNameLast']; ?>" /></td>
								<td><input class="form-control input" id="telephone" name="telephone[]" value="<?php echo $key['contactTelephone']; ?>" /></td>
								<td><input class="form-control input" id="branch" name="branchNameShort[]" value="<?php echo $key['branchNameShort']; ?>" readonly /></td>
								<td><input class="form-control input inUse" name="inUse[]" value="<?php echo $key['inUse']; ?>" /></td>
								<?php if($_SESSION['login']['access'] == 2) { ?><td><input class="form-control input" value="<?php echo date('d/m/Y H:i:s', strtotime($key['lastChanged'])); ?>"></td><?php } ?>
								<td><img id="<?php echo $key['contactID']; ?>" class="deleteButton" src="/assets/img/del_icon.png" alt="Delete" /></td>
							</tr>
						<?php } ?>
						<tr style="height: 46px;">
							<td></td>
							<td></td>
							<td>
								<input class="form-control input" id="nameFirst" name="newFirst" value="" />
							</td>
							<td>
								<input class="form-control input" id="newLast" name="newLast" value="" />
							</td>
							<td>
								<input class="form-control input" id="telephone" name="newTele" value="" />
							</td>
							<td>
								<input class="form-control input" id="branch" name="newBranch" value="<?php if(isset($branchDetailsAdmin)) {echo $branchDetailsAdmin; } else { echo $branchDetails['branchNameShort'];} ?>" readonly />
							</td>
							<td>
								
							</td>
							<td>
								<button class="btn btn-primary" name="add">&#8656; Add New User</button>
							</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td><label for="runningTotal">On Call Running Total &#8658;</label></td>
							<td><input class="form-control input" id="runningTotal" type="text" readonly /></td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td><button class="btn btn-primary" id="update" name="update">&#8657; Update</button></td>
							<td><?php if($_SESSION['login']['access'] < 3) { ?><button class="btn btn-primary" id="export" name="export">Export</button><?php } ?></td>
						</tr>
						</tbody>
					</table>
					<input type="hidden" name="page" id="page" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
				</fieldset>
			</form>
		</div>
	</div>
	<div class="col-sm-3 col-md-3 col-lg-3"></div>
</div>

<div class="row">
	<div class="col-sm-3 col-md-3 col-lg-3">
	</div>

	<div class="col-sm-10 col-md-10 col-lg-10">
		<div id="instructions">
			<h1>On Call Contact Information</h1>
			<br />
			<p>Please keep this information up to date so as to allow the on call team at GAP24/7 to contact the correct duty member as and when needed.<br /><br />

			To use the above form you are required to enter in the contact details of the duty on call members and select which members will be on call.<br /><br />

			When filling in the "In Use" section a ONE denotes the first point of contact and a TWO denotes the second point of contact.<br /><br />

			You are only able to select a first and second contact, all other contacts MUST be set to zero.</p><br /><br />
			
			<p>The running total should never exceed a total of 3.</p>
		</div>
	</div>
	<div class="col-sm-3 col-md-3 col-lg-3"></div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#runningTotal').css('background', 'green');
		var total = 0;
		i = 0;
		arr = [];
		$(".oncall .inUse").each(function() {
		    arr[i++] = $(this).val();
		});
		var total = 0;
		for (var i = 0; i < arr.length; i++) {
		    total += arr[i] << 0;
		}
		$('#runningTotal').val(total);
		$('.inUse').keyup(function(){
			i = 0;
			arr = [];
			$(".oncall .inUse").each(function() {
			    arr[i++] = $(this).val();
			});
			var total = 0;
			for (var i = 0; i < arr.length; i++) {
			    total += arr[i] << 0;
			}
			$('#runningTotal').val(total);
			
	        if($('#runningTotal').val() > 3) {
	        	$('#runningTotal').css('background', 'red');
	        	$('#update').hide();
	        }
	        else {
	        	$('#runningTotal').css('background', 'green');
	        	$('#update').show();
	        }
	    });
	    $(".inUse").keypress(function(event) {
		  if ( event.which == 45 || event.which == 189 ) {
		      event.preventDefault();
		   }
		});
	})
</script>

 <!-- Script for deleting selected checkins -->
<script>
    $(document).ready(function(){
        $('img').click(function(){
            var id = this.id;
            var type = "delete";
            var page = $('#page').val();
            $.ajax({                                     
                url: '/assets/php/branchadmin/OnCall.php',
                data: {id: id, type: type, page: page},
                type: 'POST',
                dataType: 'json',
                success: function(data)
                {
                    if(data == 'success') {
                        window.location.href = '/pages/BranchAdmin/OnCall.php';
                    }
                }
            });
        });
    });
</script>

<?php
if($_SESSION['login']['branchID'] == 27 ) {
    require_once $root.'/pages/footer.php';
}
?>