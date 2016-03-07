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
            <h1>Instructions for creating a new user</h1>
            <p id="help_info">The user creation page has three functions, the first is to find existing users, the second is the creation of new users and the third is to update existing users.  From this page it is possible to deal with all staff members that are currently able to access the GAP24/7 database.  One important factor to remember is when creating a new user for GAP24/7 the password used MUST be the same as the password that member of staff uses to access the GAP remote server.  If for some reason a member of staff wishes to have a new password you MUST speak to the IT guys and asked them to change the password to the same as the new one used here. </p>
            
            <div class="col-sm-6">
                <p>Starting with finding if a user exists in the database is important.  If the user already exists we can update the details instead of trying to insert a new user with the same details into the database.</p>
                <p>The information required to find a member of staff is the first and last name along with the branch that person works at.  Once you have inputted the required information press the 'Find User' button.</p>
            </div>
            <div class="col-sm-10 image">
                <img src="/assets/img/help/create_user_find.jpg" />
            </div>

            <div class="col-sm-6">
                <p>As you can see from the image right if the user exists then the form will be populated with all the information we hold on that person.  At this point you are able to edit any of the information you see on the form, leave the finish date set to '0000-00-00' if the person still works for the company, only change this when that person leaves.</p>
                <p>The amount of holidays that the staff member has left will also show, this is useful for fulltime members of staff when the year ends as you are able to reset it back to the full amount for the year.  Temp workers holiday will increase with the hours inserted into the timesheets.</p>
                <p>Once all the information needing changing has been altered press the 'Update User' button, if you do not need to update the password for this user leave it blank and they will maintain the same password, otherwise insert a new password to update.  Remeber that a password update will require the IT guys to update their password as well.</p>
            </div>
             <div class="col-sm-10 image">
                <img src="/assets/img/help/staff_info.jpg" />
            </div>

            <div class="col-sm-16">
            	<br />
            	<p>If you are creating a new user to access the database the start at the top of the form and filling in as much information as possible.  The username for any user if the first letter of their first name followed by their surname without a space, it does not need to be in capitals.</p>
            	<br />
            	<p>The access levels are as follows:  Standard GAP24/7 user = 0, Supervisor GAP24/7 = 1, Manager/Admin GAP24/7 = 2, Standard Branch staff = 20 and Branch Manager = 21</p>
            	<br />
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