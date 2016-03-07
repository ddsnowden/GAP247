<?php
// Define the root of the server
$root = realpath($_SERVER["DOCUMENT_ROOT"]); 
// Load Auth logout and tracking
require_once $root.'/assets/php/class/Auth.class.php';
$auth = new Auth();
$auth->logout();