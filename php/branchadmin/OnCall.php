<?php
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';
require_once $root.'/assets/php/class/OnCall.class.php';
require_once $root.'/assets/php/class/Branches.class.php';
require_once $root.'/assets/php/class/Common.class.php';
require_once $root.'/kint/Kint.class.php';
$oncall = new OnCall();
$branch = new Branches();
$common = new Common();

$form = $_POST;

if(isset($_POST['update'])) {
	$count = count($form['count']);

	$total = 0;
	foreach ($form['inUse'] as $key) {
		if($form['inUse'] == '') {
			$form['inUse'] = 0;
		}
		$total += $key;
	}
	if ($total > 3)  {
		echo "<script>
				 alert('Please select ONLY one primary and one secondary contact'); 
				 window.history.go(-1);
		 </script>";
		 exit();
	}
	$lastChanged = date('Y-m-d H:i:s');

	//Loop for checking the arrays against each other
	for ($i=0; $i < $count; $i++) { 
		$array = array("contactID" => $_POST['ID'][$i], "contactNameFirst" => $_POST['nameFirst'][$i], "contactNameLast" => $_POST['nameLast'][$i], "contactTelephone" => $_POST['telephone'][$i], "branchNameShort" => $_POST['branchNameShort'][$i], "inUse" => $_POST['inUse'][$i]);

		$oncall->update($DBH, $array['contactNameFirst'], 
									$array['contactNameLast'], 
									$array['contactTelephone'], 
									$array['inUse'],
									$lastChanged,
									$array['contactID'],
									$_SESSION['login']['staffID']);
	}
	$common->clearReturn($form['page']);	
}
elseif (isset($_POST['add'])) {
	$lastChanged = date('Y-m-d H:i:s');
	$branchID = $branch->branchDetails($DBH, $form['newBranch']);
	$oncall->insert($DBH, $form['newFirst'], $form['newLast'], $form['newTele'], $branchID['branchID'], $lastChanged, $_SESSION['login']['staffID']);
	$common->clearReturn($form['page']);
}
elseif (isset($_POST['export'])) {
	$query = $DBH->prepare('SELECT branches.branchNameShort, contacts.contactNameFirst, contacts.contactNameLast, contacts.inUse, contacts.contactTelephone
	FROM contacts
	INNER JOIN branches AS branches ON contacts.branchID = branches.branchID
	WHERE contacts.inUse IN (1,2)
	ORDER BY branches.branchName, contacts.inUse');
	$query->execute();
	$result = $query->fetchAll(PDO::FETCH_ASSOC);

	require $root.'/assets/fpdf/fpdf.php';

	$pdf = new FPDF('L');
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',12);

	foreach($result as $row) {
	$pdf->SetFont('Arial','',12);	
	$pdf->Ln();
	foreach($row as $column)
		$pdf->Cell(45,10,$column,1);
		}
		$pdf->Output();
	
}
elseif(isset($_POST['type'])) {

	$oncall->delete($DBH, $_POST['id']);
	//unset($_SESSION['form']);
	$data = 'success';
	echo json_encode($data);
}