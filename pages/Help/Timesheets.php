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
<style type="text/css">
    .image img {
        border: 6px solid rgba(0,0,0,0.5);
        border-radius: 6px;
    }
    #timesheets h1 {
        text-align: center;
        font-size: 240%;
        padding-bottom: 50px;
    }
    #timesheets p {
        text-align: justify;
        font-size: 100%;
    }
    #timesheets p:first-of-type {
        padding-bottom: 50px;
    }
</style>
<!-- Start main content of the page -->
<div class="row form">
	<div class="col-sm-2 col-md-2 col-lg-2"></div>
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div id="help">
            <h1>Instructions for completing the timesheets for payroll</h1>
            <p id="help_info">To complete the timesheets ready to process for payroll you will need to go through the staffs timesheets and record the hours that they have worked, these need to be confirmed against the rota before processing and checked against the holiday form to ensure all details are correct.  Once you have confirmed all the details are sorrect and up to date you can proceed with the timesheets form.  The timesheets form will also update the recorded holidays for all staff and will present each member of staff with an up to date account of how many holidays they have left, it is important that this process be followed and completed each week.</p>
            <div class="col-sm-6">
                <p>First select the member of staff you wish to update.  You are only able to select a single member of staff.  Press submit to be taken to the next page.</p>
            </div>
            <div class="col-sm-10 image">
                <img src="/assets/img/help/timesheet_staff_select.jpg" />
            </div>

            <div class="col-sm-6">
                <p>First select the start of the working week, the date select will appear when clicked and provide only Sundays to select as this is the start of the working week.</p>
                <p>Once the date is selected insert the hours worked that week as well as any holidays taken.  You must make sure that you enter '0' if either no hours or no holiday has been taken.  Once all input fields have been entered click submit</p>
            </div>
            <div class="col-sm-10 image">
                <img src="/assets/img/help/staff_hours.jpg" />
            </div>

            <div class="col-sm-6">
                <p>Repeat the above steps for all members of staff that have worked in the previous week, this is to include fulltime members of staff.  Once all workers have been added select the week to email from the selector on the right of the staff list.  Once you have selected the correct week press the submit button and the email will be generated and sent to the payroll department.</p>
            </div>
            <div class="col-sm-10 image">
                <img src="/assets/img/help/ready_email.jpg" />
            </div>
        </div>
    </div>
    <div class="col-sm-2 col-md-2 col-lg-2"></div>
</div>

<?php
if($_SESSION['login']['branchID'] == 27 ) {
    require_once $root.'/pages/footer.php';
}
?>