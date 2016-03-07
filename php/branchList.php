<?php 
	require_once $root.'/assets/php/class/Branches.class.php';
	$branch = new Branches();
	$branchList = $branch->branchList($DBH);
?>
<select id="branch" name='branchNameShort' class="form-control input" required>
	<option value="" <?=(isset($_SESSION['form']['branchNameShort']) && $_SESSION['form']['branchNameShort'] == '' ? 'selected' : '')?>></option>
<?php
foreach ($branchList as $key) { 
	$branchName = str_replace('_', ' ', $key['branchNameShort']);
?>
	<option value="<?php echo htmlspecialchars($key['branchNameShort'], ENT_QUOTES); ?>" <?=(isset($_SESSION['form']['branchNameShort']) && $_SESSION['form']['branchNameShort'] == htmlspecialchars($key['branchNameShort'], ENT_QUOTES) ? 'selected' : '')?> ><?php echo htmlspecialchars(ucwords($branchName), ENT_QUOTES); ?></option>
<?php
}
?>
</select>