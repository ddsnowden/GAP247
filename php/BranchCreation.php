<?php
session_start();
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';
require_once $root.'/assets/php/class/BranchCreation.class.php';
require_once $root.'/assets/php/class/Common.class.php';

$create = new BranchCreation();
$common = new Common();

$form = $_POST;

if(isset($form['insert'])) {
	//Create branchNameShort
	$string = " ";
	if(strpos(trim($form['branchName']), $string) !== false) {
		$branchNameShort = $form['type'].str_replace(' ', '_', $form['branchName']);
	}
	else {
		$branchNameShort = $form['type'].$form['branchName'];
	}

	//Create branchName
	$branchName = str_replace('_', ' ', $form['type']).$form['branchName'];

	//Insert call
	$create->insert($DBH, $branchNameShort, $branchName, $form['addressOne'], $form['addressTwo'], $form['addressThree'], $form['city'], $form['postcode'], $form['telephone'], $form['email'], $form['divertNumber']);

	//Clear and return
	$common->clearReturn($form['page']);
}