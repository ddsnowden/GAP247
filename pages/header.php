<?php 
	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}

	if($_SESSION['login']['access'] == null) {
		$_SESSION = array();
		session_destroy();
		header("location: /index.php");
	}

	// Define the root of the server
	$root = realpath($_SERVER["DOCUMENT_ROOT"]); 
	// Load database connection
	require_once $root.'/assets/php/db.php';
	require_once $root.'/assets/php/class/Auth.class.php';

	$auth = new Auth();
?>
<!DOCTYPE html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>GAP 24/7</title>

	<!-- jQuery -->
	<script type="text/javascript" src="/assets/js/jquery-1.11.3.min.js"></script>
	<script src="/assets/js/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="/assets/js/jquery-ui.min.css" type="text/css" />

	<!-- Styling -->
	<link rel="stylesheet" type="text/css" href="/assets/bootstrap/css/bootstrap.min.css" />
	<script src="/assets/bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="/assets/bootstrap/custom.css" />
	<link rel="stylesheet" type="text/css" href="/assets/css/style.css" />

	<!-- DateTimePicker -->
	<link rel="stylesheet" type="text/css" href="/assets/css/jquery.datetimepicker.css" />
	<script type="text/javascript" src="/assets/js/datetime/jquery.datetimepicker.full.min.js"></script>

	<!-- Addons -->
	<script type="text/javascript" src="/assets/js/datetime/datetime.js"></script>  <!-- Custom datetime picker for forms -->
	<script type="text/javascript" src="/assets/js/jquery.easy-confirm-dialog.js"></script>  <!--  Easy confirm for emails and clearing  -->
	<script type="text/javascript" src="/assets/js/custom/slideOut.js"></script> <!-- Right slide out -->
	<link rel="stylesheet" type="text/css" href="/assets/css/slideOut.css" /> <!-- Right slide out -->
	<script type="text/javascript" src="/assets/js/custom/alerts.js"></script> <!-- Visual Alerts -->
	<script type="text/javascript" src="/assets/js/custom/typeTimer.js"></script> <!-- Auto Logout -->

	<?php if($_SESSION['login']['staffID'] == 46) { ?>
		<style type="text/css">
		.form select {
			background-color: #D9D9FF;
		}
		.form input {
			background-color: #D9D9FF;
		}
		.form textarea {
			background-color: #D9D9FF;
		}
		</style>
	<?php } ?>
</head>
	<body>
		<div id="checkAlert"></div>
			<!-- ---------------------------------------------------------------------------------  Menu  --------------------------------------------------------------------------------- -->
		    <nav class="navbar navbar-default">
			  <div class="container-fluid">
			    <!-- Brand and toggle get grouped for better mobile display -->
			    <div class="navbar-header">
			      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			      </button>
			      <a class="navbar-brand" href="#"><img style="max-width: 100px; margin-top: -9px;" src='/assets/img/247-logo.png' id="brandLogo" /></a>
			    </div>

			    <!-- Collect the nav links, forms, and other content for toggling -->
			    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			      <ul class="nav navbar-nav navbar-right">
			        <li><a href="/pages/Home.php">Home</a></li>

			        <?php if($_SESSION['login']['access'] <= 2) { ?>
				        <li class="dropdown">
				          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Client Calls <span class="caret"></span></a>
				          <ul class="dropdown-menu">
				            <li><a href='/pages/Bookings.php'><span>Bookings</span></a></li>
							<li><a href='/pages/Cancellations.php'><span>Cancellations</span></a></li>
							<li><a href='/pages/TempNoShow.php'><span>No Show</span></a></li>
							<li><a href='/pages/ClientOtherIssues.php'><span>Other client issues</span></a></li>
							<li><a href='/pages/Checkins.php'><span>Client Check Ins</span></a></li>
				          </ul>
				        </li>
				        
				        <li class="dropdown">
				          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Temp Calls <span class="caret"></span></a>
				          <ul class="dropdown-menu">
				            <li><a href='/pages/SicknessOrAbsence.php'><span>Sickness and Absence</span></a></li>
							<li><a href='/pages/WorkingTimes.php'><span>Working Times</span></a></li>
							<li><a href='/pages/PayQueries.php'><span>Pay Queries</span></a></li>
							<li><a href='/pages/OtherTempIssues.php'><span>Other temp issues</span></a></li>
				          </ul>
				        </li>

				        <li class="dropdown">
				          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Adverts <span class="caret"></span></a>
				          <ul class="dropdown-menu">
				            <li><a href='/pages/Advert.php'><span>Application Form</span></a></li>
						    <li><a href='/pages/MatalanAdvert.php'><span>Matalan Form</span></a></li>
				          </ul>
				        </li>

				        <li class="dropdown">
				          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Head Office <span class="caret"></span></a>
				          <ul class="dropdown-menu">
				            <li><a href='/pages/HeadOfficeClientCall.php'><span>Client Calls</span></a></li>
							<li><a href='/pages/HeadOfficeTempCall.php'><span>Temp Calls</span></a></li>
				          </ul>
				        </li>

				        <li class="dropdown">
				          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Personal Admin <span class="caret"></span></a>
				          <ul class="dropdown-menu">
				            <li><a href='/pages/Timesheet.php'><span>Timesheet</span></a></li>
						    <li><a href='/pages/Holiday.php'><span>Holiday Form</span></a></li>
						    <li><a href='/pages/Calendar.php'><span>Calendar</span></a></li>
						    <li><a href='/pages/PersonalStats.php'><span>Personal Statistics</span></a></li>
				          </ul>
				        </li>

				        <li><a href="/pages/Searching.php">Searching</a></li>

			        <?php } ?>
			        <?php if(($_SESSION['login']['access'] == 2) || ($_SESSION['login']['access'] >= 20)) { ?>
			        	<li class="dropdown">
				          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Branch Admin <span class="caret"></span></a>
				          <ul class="dropdown-menu">
				            <li><a href='/pages/BranchAdmin/ClientCheckins.php'><span>Client Checkins</span></a></li>
							<li><a href='/pages/BranchAdmin/OnCall.php'><span>On Call</span></a></li>
							<?php if(($_SESSION['login']['access'] == 2) || ($_SESSION['login']['access'] >= 21)) { ?>
								<li><a href='/pages/BranchAdmin/Procedures.php'><span>Procedures</span></a></li>
							<?php } ?>
							<li><a href='/pages/BranchAdmin/Statistics.php'><span>Statistics</span></a></li>
							<li><a href='/pages/BranchAdmin/Feedback.php'><span>Feedback</span></a></li>
							<li><a href='/pages/BranchAdmin/Cvsearch.php'><span>CV Search</span></a></li>
							<!-- <li><a href='/pages/BranchAdmin/JobAdvert.php'><span>Job Advert</span></a></li> -->
				          </ul>
				        </li>
				    <?php } ?>
				    <?php if(($_SESSION['login']['access'] <= 2) || ($_SESSION['login']['access'] == 21)) { ?>
			        	<li class="dropdown">
				          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin <span class="caret"></span></a>
				          <ul class="dropdown-menu multi-level">
				          <?php if($_SESSION['login']['access'] == 2) { ?>
				          	 <li class="dropdown-submenu">
				                <a tabindex="-1" href="#">Help Menu</a>
				                <ul class="dropdown-menu">
				                  <!-- <li><a tabindex="-1" href="#">Admin</a></li> -->
				                  <li class="dropdown-submenu">
				                    <a href="#">Admin</a>
				                    <ul class="dropdown-menu">
				                        <li><a href="/pages/Help/UserCreation.php">User Creation</a></li>
				                    	<li><a href="#">Branch Creation</a></li>
				                    	<li><a href="/pages/Help/Procedures.php">Procedures</a></li>
				                    	<li><a href="#">Feedback</a></li>
				                    	<li><a href="#">CV Search</a></li>
				                    	<li><a href="/pages/Help/Timesheets.php">Timesheets</a></li>
				                    </ul>
				                  </li>

				                  <li class="dropdown-submenu">
				                    <a href="#">GAP24/7 Staff</a>
				                    <ul class="dropdown-menu">
				                        <li><a href="#">3rd level</a></li>
				                    	<li><a href="#">3rd level</a></li>
				                    </ul>
				                  </li>

				                  <li class="dropdown-submenu">
				                    <a href="#">Branch Staff</a>
				                    <ul class="dropdown-menu">
				                        <li><a href="#">3rd level</a></li>
				                    	<li><a href="#">3rd level</a></li>
				                    </ul>
				                  </li>

				                  <!-- <li><a href="#">Second level</a></li> -->
				                  <!-- <li><a href="#">Second level</a></li> -->
				                </ul>
				              </li>
				              <li class="divider"></li>

				            <li><a href='/pages/Admin/UserCreation.php'><span>User Creation</span></a></li>
				            <li><a href='/pages/Admin/BranchCreation.php'><span>Branch Creation</span></a></li>
				            <li><a href='/assets/phpsysinfo/index.php'><span>System Information</span></a></li>
				          <?php } ?>
							<!-- <li><a href='/pages/BranchAdmin/OnCall.php'><span>On Call</span></a></li> -->
							<?php if(($_SESSION['login']['access'] == 2) || ($_SESSION['login']['access'] >= 21)) { ?>
								<!-- <li><a href='/pages/BranchAdmin/Procedures.php'><span>Procedures</span></a></li> -->
							<?php } ?>
							<?php if($_SESSION['login']['access'] == 2) { ?>
								<li><a href='/pages/Admin/DynamicStatistics.php'><span>Dynamic Statistics</span></a></li>
								<!-- <li><a href='/pages/BranchAdmin/Feedback.php'><span>Feedback</span></a></li> -->
							<?php } ?>
							<?php if(($_SESSION['login']['access'] == 2) || ($_SESSION['login']['access'] == 1)) { ?>
								<!-- <li><a href='/pages/BranchAdmin/Cvsearch.php'><span>CV Search</span></a></li> -->
							<?php } ?>
							<?php if($_SESSION['login']['access'] == 2) { ?>
								<li><a href='/pages/Admin/Timesheets.php'><span>Timesheets</span></a></li>
							<?php } ?>
				          </ul>
				        </li>
				    <?php } ?>
			        <li><a href="/assets/php/logout.php">Logout</a></li>
			        <li><a><?php echo $_SESSION['login']['staffNameFirst'].' '.$_SESSION['login']['staffNameLast']; ?></a></li>
			      </ul>
			    </div><!-- /.navbar-collapse -->
			  </div><!-- /.container-fluid -->
			</nav>
<script type="text/javascript">
$(document).ready(function(){
	$('.dropdown-submenu>a').unbind('click').click(function(e){

		$(this).next('ul').toggle();

		e.stopPropagation();
		e.preventDefault();
	});
});
</script>

		<!-- ---------------------------------------------------------------------------------  End Menu  ----------------------------------------------------------------------------- -->
		<!-- ---------------------------------------------------------------------------------  Main Content  ------------------------------------------------------------------------- -->
		<div class="row">
			<div class="col-sm-16 "> <!-- Main Content -->

				