<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root.'/pages/header.php';
    
    include $root.'/assets/php/auth/remoteUsers.php';

	require_once $root.'/assets/php/class/Cvsearch.class.php';
	require_once $root.'/assets/php/class/Staff.class.php';
	require_once $root.'/assets/php/class/Branches.class.php';

	$cvData = new CVSearch();
	$staff = new Staff();
	$branchData = new Branches();

	$recall = $cvData->recall($DBH);

	$currentPage = "cvsearch";
?>
<!-- Load common scripts and call specific scripts -->
<script src="/assets/js/custom/commonScripts.js"></script>
<script src="/assets/js/custom/callScripts.js"></script>
<script src="/assets/js/custom/searching.js"></script>
<script type="text/javascript" src="/assets/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		tinymce.init({ selector:'textarea', menubar: false });
	})
</script>
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
<script type="text/javascript">var callType = 'cvsearch';</script>

<!-- Start main content of the page -->
<div class="row form">
	<div class="col-sm-5 col-md-5 col-lg-5" >
		<form method="POST" action="/assets/php/Cvsearch.php" role="form" class="form-horizontal" >
        		<input class="hidden" type='hidden' name='callID' value="<?php if (isset($_SESSION['form']['callID'])) echo $_SESSION['form']['callID']; ?>" />
    			<input class="hidden" type='hidden' name='type' value="cvsearch" />

    			<div class="col-sm-4 labright">
                    <label for="recall">Recall:</label>
                </div>
                <div class="col-sm-9">
    	            <select id="recall" class="form-control input">
    		            <option selected></option>
    		            <?php
    		            if($_SESSION['login']['access'] == 2) {
    		            	foreach ($recall as $key) {
    		            		echo '<option id='.$key['callID'].'>'.date("d-m-Y", strtotime($key['dateInputted'])).' - CV'.$key['callID'].' - '.$key['clientName'].' - '.$key['position'].' - '.$key['status'].'</option>';
    		            	}
    		            }
    		            else {
	    		            foreach ($recall as $key) {
	    		            	if($key['branchID'] == $_SESSION['login']['branchID']) {
									echo '<option id='.$key['callID'].'>'.date("d-m-Y", strtotime($key['dateInputted'])).' - CV'.$key['callID'].' - '.$key['clientName'].' - '.$key['position'].' - '.$key['status'].'</option>';
	    		            	}else {continue;}
							}
						}
						?>
					</select>
				</div>
				<div class="col-sm-4 labright">	
					<label for="cvsearchref">CV Search Ref:</label>
				</div>
				<div class="col-sm-9">
					<input class="form-control input" type="text" name="cvsearchref" value="<?php if (isset($_SESSION['form']['callID'])) echo 'CV'.$_SESSION['form']['callID']; ?>" readonly/>
				</div>
				<div class="col-sm-4 labright">
					<label>Branch:</label>
				</div>
				<div class="col-sm-9">
					<input class="form-control input" name="branchNameShort" id="branchNameShort" type="text" value="<?php $branchName = $branchData->branchDetailsID($DBH, $_SESSION['login']['branchID']); echo $branchName['branchNameShort']; ?>" readonly />
				</div>
				<div class="col-sm-4 labright">
					<label>Staff Name:</label>
				</div>
				<div class="col-sm-9">
					<input class="form-control input" type="text" name="staffname" value="<?php if (isset($_SESSION['form']['staffNameFirst'])) { echo $_SESSION['form']['staffNameFirst'].' '.$_SESSION['form']['staffNameLast']; } else {echo $_SESSION['login']['staffNameFirst'].' '.$_SESSION['login']['staffNameLast']; } ?>" readonly/>
				</div>

				<div class="col-sm-4 labright">
                    <label for="clientNameSearch">Client Search:</label>
                </div>
                <div class="col-sm-9">
                	<input type="text" name="clientNameSearch" id="clientNameSearch" class="form-control input" required />
                    <div id="clientResult" style="z-index: 10000;">
                        <?php if(isset($_SESSION['form']['clientList'])) {
                            foreach ($_SESSION['form']['clientList'] as $key) { ?>
                                <p onclick="clientNameID($(this).attr('id'))" class="resultList" id="<?php echo $key['clientNameID']; ?>"><?php echo $key['clientName']; ?></p>
                        <?php } } ?>
                    </div>
                </div>  
				<div id="clientDetails">
                    <input class="form-control input" name="clientID" id="clientID" type="hidden" value="<?php if (isset($_SESSION['form']['clientID'])) echo $_SESSION['form']['clientID']; ?>"  />
                    <input class="form-control input" name="clientNameID" id="clientNameID" type="hidden" value="<?php if (isset($_SESSION['form']['clientNameID'])) echo $_SESSION['form']['clientNameID']; ?>"  />

                    <div class="col-sm-4 labright">
                        <label for="clientName">Client Name:</label>
                    </div>
                    <div class="col-sm-9">
                    	<input class="form-control input" name="clientName" id="clientName" type="text" value="<?php if (isset($_SESSION['form']['clientName'])) echo $_SESSION['form']['clientName']; ?>" required />
                	</div>
                	<div class="col-sm-4 labright">
                        <label for="postcode">Client Postcode:</label>
                    </div>
                    <div class="col-sm-9">
                    	<input class="form-control input" type='text' name='postcode' placeholder='Client Postcode' value="<?php if (isset($_SESSION['form']['postcode'])) echo $_SESSION['form']['postcode']; ?>" required/>
                    </div>
                </div>
					
				<div class="col-sm-4 labright">
					<label for="position">Position:</label>
				</div>
				<div class="col-sm-9">
					<select class="form-control input" name='position'>
						<option value="" <?=(isset($_SESSION['form']['position']) && $_SESSION['form']['position'] == '' ? 'selected' : '')?>></option>
						<option value="Production" <?=(isset($_SESSION['form']['position']) && $_SESSION['form']['position'] == 'Production' ? 'selected' : '')?>>Production Operative</option>
						<option value="Forklift" <?=(isset($_SESSION['form']['position']) && $_SESSION['form']['position'] == 'Forklift' ? 'selected' : '')?>>Forklift Operator</option>
						<option value="HGV1" <?=(isset($_SESSION['form']['position']) && $_SESSION['form']['position'] == 'HGV1' ? 'selected' : '')?>>HGV Class One</option>
						<option value="HGV2" <?=(isset($_SESSION['form']['position']) && $_SESSION['form']['position'] == 'HGV2' ? 'selected' : '')?>>HGV Class Two</option>
						<option value="35t" <?=(isset($_SESSION['form']['position']) && $_SESSION['form']['position'] == '35t' ? 'selected' : '')?>>3.5 Tonne</option>
						<option value="Van" <?=(isset($_SESSION['form']['position']) && $_SESSION['form']['position'] == 'Van' ? 'selected' : '')?>>Van Driver</option>
					</select>
				</div>
				<?php if ($_SESSION['login']['access'] < 10) { ?>
					<div class="col-sm-4 labright">
						<label for="staff">Assigned To:</label>
					</div>
					<div class="col-sm-9">
						<select class="form-control input" name='staff' required>
							<option value='' <?=(isset($_SESSION['form']['staff']) && $_SESSION['form']['staff'] == '' ? 'selected' : '')?>></option>
						<?php
							foreach ($staff->staffList($DBH) as $key) { 
								$name = $key['staffNameFirst'].' '.$key['staffNameLast'];
								?>
								<option value='<?php echo $key['staffID']; ?>' <?=(isset($_SESSION['form']['assign']) && ($_SESSION['form']['assign'] == $key['staffID']) ? 'selected' : '' )?> ><?php echo $name; ?></option>
								<?php
							}
						?>
						</select>
					</div>
				<?php } ?>

				<div id="statusLabel">
					<div class="col-sm-4 labright">
						<label>Current Status:</label>
					</div>
					<div class="col-sm-9">
						<?php if ($_SESSION['login']['access'] > 10) { ?>
							<input class="form-control input" type='text' id="status" name='status' value="<?php if (isset($_SESSION['form']['status'])) echo $_SESSION['form']['status']; ?>" readonly />
						<?php } else { ?>
							<select class="form-control input" name='status' id="status" required>
								<option value='' <?=(isset($_SESSION['form']['status']) && $_SESSION['form']['status'] == '' ? 'selected' : '')?>></option>
								<option value='Outstanding' <?=(isset($_SESSION['form']['status']) && $_SESSION['form']['status'] == 'Outstanding' ? 'selected' : '')?>>Outstanding</option>
								<option value='Searching' <?=(isset($_SESSION['form']['status']) && $_SESSION['form']['status'] == 'Searching' ? 'selected' : '')?>>Searching</option>
								<option value='Completed' <?=(isset($_SESSION['form']['status']) && $_SESSION['form']['status'] == 'Completed' ? 'selected' : '')?>>Completed</option>
								<option value='Declined' <?=(isset($_SESSION['form']['status']) && $_SESSION['form']['status'] == 'Declined' ? 'selected' : '')?>>Declined</option>
							</select>
						<?php } ?>
					</div>
				</div>
				
				<div class="col-sm-4 labright">
					<label></label>
				</div>
				<div class="col-sm-9">
					<button id="submit" name="submit" type="submit" class="btn btn-primary">Submit</button>
				</div>
				
				<div class="col-sm-4 labright">
					<label></label>
				</div>
				<div class="col-sm-9">
					<a id="clearConfirm"><button name="" type="submit" class="btn btn-primary">Clear</button></a>
				</div>

				<div class="col-sm-4 labright">
					<label></label>
				</div>
				<div class="col-sm-9">
					<br /><p style="text-align: justify">To complete this form you must first search for your client using the 'Client Search' field within the above form.  If your client does not exist within the form please insert the details as required.  Both the clients company name and postcode are required to submit the CV search.</p>
				</div>

	</div>
	<div class="col-sm-7 col-md-7 col-lg-7">

				<div class="col-sm-3 labright">
					<label for="jobdesc">Job Description:</label>
				</div>
				<div class="col-sm-12">
					<textarea class="form-control input" style="min-height: 250px" id="jobdesc" name='jobdesc' placeholder='Enter Job Desc.....    Job Criteria.....'><?php if (isset($_SESSION['form']['jobdesc'])) echo $_SESSION['form']['jobdesc']; ?></textarea>
				</div>
				<div class="col-sm-3 labright">
					<label>Other Information:</label>
				</div>
				<div class="col-sm-12">
					<textarea class="form-control input" style="min-height: 250px" name='other' placeholder='Enter other job information....'><?php if (isset($_SESSION['form']['other'])) echo $_SESSION['form']['other']; ?></textarea>
				</div>
					
				<input type="hidden" name="page" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
					
				
			</fieldset>
		</form>
	</div>
	<div class="col-sm-4 col-md-4 col-lg-4">
		<div class="tableWhite">
			<table>
				<th class="top">CV ID</th><th class="top">Client</th><th class="top">Position</th><th class="top">Status</th><?php if($_SESSION['login']['access'] < 10): ?><th class="top">Assigned To</th><?php Endif; ?>
				<tbody>
				<?php
					if($_SESSION['login']['access'] < 10) {
						$data = $cvData->cvListAll($DBH);
					}
					else {
						$data = $cvData->cvList($DBH, $_SESSION['login']['branchID']);
					}
					foreach ($data as $key) { ?>
					<tr>
						<td style="cursor: pointer" onClick="cvRecall(this.innerHTML);">CV<?php echo $key['callID']; ?></td>
						<td><?php echo $key['clientName']; ?></td>
						<td><?php echo $key['position']; ?></td>
						<td><?php echo $key['status']; ?></td>
						<?php if($_SESSION['login']['access'] < 10): ?>
							<td><?php  if(isset($key['assign']) && ($key['assign'] != '')) { $temp = $staff->details($DBH, $key['assign']); echo $temp[0]['staffNameFirst'].' '.$temp[0]['staffNameLast'];} ?></td>
						<?php Endif; ?>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php if($_SESSION['login']['access'] > 10) { ?>
	<script type="text/javascript">
		$(document).ready(function() {
			var status = $('#status').val();
			console.log(status);
			if(status == 'Outstanding') {
				$('#submit').show();
			}
			else if(status == '') {
				$('#submit').show();
			}
			else {
				alert("This CV Search has either been Started/Completed or Declined, please contact GAP24/7 directly for more information, thank you.");
				$('#submit').hide();
			}
		})
	</script>
<?php } ?>

<?php
if($_SESSION['login']['branchID'] == 27 ) {
    require_once $root.'/pages/footer.php';
}
?>