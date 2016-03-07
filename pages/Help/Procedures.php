<?php 
	//Define root path
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    //Include header
    require_once $root.'/pages/header.php';
    //Resrtrict to GAP24/7 Users
    include $root.'/assets/php/auth/branchUsers.php';
?>
<!-- Load common scripts and call specific scripts -->
<script src="/assets/js/custom/commonScripts.js"></script>
<script src="/assets/js/custom/callScripts.js"></script>
<script src="/assets/js/custom/searching.js"></script>

<!-- Start main content of the page -->
<div class="row form">
	<div class="col-sm-2 col-md-2 col-lg-2"></div>
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div id="help">
            <h1>Instructions for updating branch procedures</h1>
            <p id="help_info">Updating branch procedures must only be done if the branch has specifically asked for the procedure to be change by GAP24/7, you need to get emailed confirmation of the request before continuing so that the branch can not dispute the change later.  If you are asked to update the procedures simply select the branch from the drop down list of the left hand side.</p>
            <br />
            <p>Once the branch has been selected the various boxes will be filled with the procedures required for each call type, simply edit the information held within the call type you are interested in and scroll to the bottom of the screen and press the 'Submit' button.  An automatic email will be sent to Dean Langford informing him of the update and you will be returned to the same page but with a blank form.</p>
            
            
        </div>
    </div>
    <div class="col-sm-2 col-md-2 col-lg-2"></div>
</div>

<?php
if($_SESSION['login']['branchID'] == 27 ) {
    require_once $root.'/pages/footer.php';
}
?>