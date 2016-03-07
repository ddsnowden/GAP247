<?php 
session_start();

$procedure = '';

if (isset($_SESSION['form']['type']) && (strtolower($_SESSION['form']['type']) == "bookings")) {
	$procedure = $_SESSION['form']['procedure']['bookings'];
}
elseif (isset($_SESSION['form']['type']) && (strtolower($_SESSION['form']['type']) == "cancellations")) {
	$procedure = $_SESSION['form']['procedure']['cancellations'];
}
elseif (isset($_SESSION['form']['type']) && (strtolower($_SESSION['form']['type']) == "client other issues")) {
	$procedure = $_SESSION['form']['procedure']['otherclient'];
}
elseif (isset($_SESSION['form']['type']) && (strtolower($_SESSION['form']['type']) == "temp no show")) {
	$procedure = $_SESSION['form']['procedure']['tempnoshow'];
}
elseif (isset($_SESSION['form']['type']) && (strtolower($_SESSION['form']['type']) == "sickness or absence")) {
	$procedure = $_SESSION['form']['procedure']['sick'];
}
elseif (isset($_SESSION['form']['type']) && (strtolower($_SESSION['form']['type']) == "working times")) {
	$procedure = $_SESSION['form']['procedure']['working'];
}
elseif (isset($_SESSION['form']['type']) && (strtolower($_SESSION['form']['type']) == "pay queries")) {
	$procedure = $_SESSION['form']['procedure']['pay'];
}
elseif (isset($_SESSION['form']['type']) && (strtolower($_SESSION['form']['type']) == "other temp issues")) {
	$procedure = $_SESSION['form']['procedure']['othertemp'];
}

?>
<div>
	<div id="branchAddress">
		<h1><?php if (isset($_SESSION['form']['branchName'])) echo $_SESSION['form']['branchName']; ?></h1>
	
		<h2><?php 
				if (isset($_SESSION['form']['branchAddressOne']) && !empty($_SESSION['form']['branchAddressOne'])) echo $_SESSION['form']['branchAddressOne'].', ';
				if (isset($_SESSION['form']['branchAddressTwo']) && !empty($_SESSION['form']['branchAddressTwo'])) echo $_SESSION['form']['branchAddressTwo'].', ';
				if (isset($_SESSION['form']['branchAddressThree']) && !empty($_SESSION['form']['branchAddressThree'])) echo $_SESSION['form']['branchAddressThree'].', ';
				if (isset($_SESSION['form']['branchCity']) && !empty($_SESSION['form']['branchCity'])) echo $_SESSION['form']['branchCity'].', ';
				if (isset($_SESSION['form']['branchPostcode']) && !empty($_SESSION['form']['branchPostcode'])) echo $_SESSION['form']['branchPostcode']; ?>
		</h2>
		<h2><?php if (isset($_SESSION['form']['branchTelephone'])) echo $_SESSION['form']['branchTelephone']; ?></h2>
	</div>
	
	<div class="dutyNumber first">
		<h4><span>First Contact:</span>&nbsp;&nbsp;</h4> <p style="display: inline";><?php if (isset($_SESSION['form']['duty'][0]['contactNameFirst'])) echo $_SESSION['form']['duty'][0]['contactNameFirst'].' '.$_SESSION['form']['duty'][0]['contactNameLast'].' - '.$_SESSION['form']['duty'][0]['contactTelephone']; ?></p>
	</div>
	<div class="dutyNumber second">
		<h4><span>Second Contact:</span>&nbsp;&nbsp;</h4><?php if (isset($_SESSION['form']['duty'][1]['contactNameFirst'])) echo $_SESSION['form']['duty'][1]['contactNameFirst'].' '.$_SESSION['form']['duty'][1]['contactNameLast'] .' - '.$_SESSION['form']['duty'][1]['contactTelephone']; ?>
	</div>
	<div class="dutyNumber divert">
		<h4><span>Divert Number:</span>&nbsp;&nbsp;</h4><p style="display: inline;"><?php if (isset($_SESSION['form']['divertNumber'])) echo $_SESSION['form']['divertNumber']; ?></p>
	</div>

	<div id="callType">
		<h3 id="typeHeading">
			<script type="text/javascript">
				document.getElementById("typeHeading").innerHTML = callType;
			</script>
		</h3>
	</div>
	<br />
	<p id="procedure">

	<?php
		if (isset($procedure)) {
			$array = explode(PHP_EOL, $procedure);
			foreach ($array as $key) {
				$output = $key.'<br /><br />';
				echo $output;
			}
		}
	?>
	</p>
</div>