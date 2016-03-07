
<table class="tableWhite">
<?php
//Define root path
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
session_start();

if ($_SESSION['search']['type'] == "temp") { 
	echo "<THEAD class='top'>";
	echo "<tr>";
	echo "<th colspan='7' style='font-size: 140%'>Call results for ".$_SESSION['search']['results'][0]['firstName']." ".$_SESSION['search']['results'][0]['lastName']."</th>";
	echo "</tr>";
	echo "<tr>";
	echo "<th>Call ID</th><th>Call Type</th><th>Details</th><th>Further</th><th>Date Time Inserted</th><th>Date Time Emailed</th><th>Staff Name</th>";
	echo "</tr>";
	echo "</THEAD>";
	foreach ($_SESSION['search']['results'] as $key) { ?>
		<tr>
	      <td><span style="cursor: pointer" onClick="slideRecall(this.innerHTML);"><?php echo htmlspecialchars($key['callID'], ENT_QUOTES); ?></span></td>
	      <td><?php echo htmlspecialchars(ucwords($key['type']), ENT_QUOTES); ?></td>
	      <td><?php echo htmlspecialchars($key['details'], ENT_QUOTES); ?></td>
	      <td><?php echo htmlspecialchars($key['further'], ENT_QUOTES); ?></td>
	      <td><?php echo htmlspecialchars($key['dateInputted'], ENT_QUOTES).' '.htmlspecialchars($key['timeInputted'], ENT_QUOTES); ?></td>
	      <td><?php echo htmlspecialchars($key['emailDateTime'], ENT_QUOTES); ?></td>
	      <td><?php echo htmlspecialchars($key['username'], ENT_QUOTES); ?></td>
	    </tr>
<?php } } 
elseif ($_SESSION['search']['type'] == "client") { 
	echo "<THEAD class='top'>";
	echo "<tr>";
	echo "<th colspan='7' style='font-size: 140%'>Call results for ".$_SESSION['search']['results'][0]['clientName']." ".$_SESSION['search']['results'][0]['lastName']."</th>";
	echo "</tr>";
	echo "<tr>";
	echo "<th>Call ID</th><th>Call Type</th><th>Details</th><th>Further</th><th>Date Time Inserted</th><th>Date Time Emailed</th><th>Staff Name</th>";
	echo "</tr>";
	echo "</THEAD>";
	foreach ($_SESSION['search']['results'] as $key) { ?>
		<tr>
	      <td><span style="cursor: pointer" onClick="slideRecall(this.innerHTML);"><?php echo htmlspecialchars($key['callID'], ENT_QUOTES); ?></span></td>
	      <td><?php echo htmlspecialchars(ucwords($key['type']), ENT_QUOTES); ?></td>
	      <td><?php echo htmlspecialchars($key['details'], ENT_QUOTES); ?></td>
	      <td><?php echo htmlspecialchars($key['further'], ENT_QUOTES); ?></td>
	      <td><?php echo htmlspecialchars($key['dateInputted'], ENT_QUOTES).' '.htmlspecialchars($key['timeInputted'], ENT_QUOTES); ?></td>
	      <td><?php echo htmlspecialchars($key['emailDateTime'], ENT_QUOTES); ?></td>
	      <td><?php echo htmlspecialchars($key['username'], ENT_QUOTES); ?></td>
	    </tr>
<?php } } 
elseif ($_SESSION['search']['type'] == "clientname") {
	echo "<THEAD class='top'>";
	echo "<tr>";
	echo "<th colspan='7' style='font-size: 140%'>Call results for ".$_SESSION['search']['results'][0]['clientName']."</th>";
	echo "</tr>";
	echo "<tr>";
	echo "<th>Call ID</th><th>Call Type</th><th>Details</th><th>Further</th><th>Date Time Inserted</th><th>Date Time Emailed</th><th>Staff Name</th>";
	echo "</tr>";
	echo "</THEAD>";
	foreach ($_SESSION['search']['results'] as $key) { ?>
		<tr>
	      <td><span style="cursor: pointer" onClick="slideRecall(this.innerHTML);"><?php echo htmlspecialchars($key['callID'], ENT_QUOTES); ?></span></td>
	      <td><?php echo htmlspecialchars(ucwords($key['type']), ENT_QUOTES); ?></td>
	      <td><?php echo htmlspecialchars($key['details'], ENT_QUOTES); ?></td>
	      <td><?php echo htmlspecialchars($key['further'], ENT_QUOTES); ?></td>
	      <td><?php echo htmlspecialchars($key['dateInputted'], ENT_QUOTES).' '.htmlspecialchars($key['timeInputted'], ENT_QUOTES); ?></td>
	      <td><?php echo htmlspecialchars($key['emailDateTime'], ENT_QUOTES); ?></td>
	      <td><?php echo htmlspecialchars($key['username'], ENT_QUOTES); ?></td>
	    </tr>
<?php } } ?>
</table>
