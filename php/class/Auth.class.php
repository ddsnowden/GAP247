<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

require_once 'Branches.class.php';
require_once 'Tracking.class.php';

class Auth
{
	function login($DBH, $username, $password) {
		$branches = new Branches();
		$tracking = new Tracking();

	    $stmt = $DBH->prepare("SELECT * FROM `staff` WHERE `username` = ?");
		$stmt->execute([$_POST['username']]);
       
		if ($user = $stmt->fetch(PDO::FETCH_ASSOC))  /**** Select If ****/
		{    
			if (password_verify($_POST['password'], $user['password']))
			{
				if (password_needs_rehash($user['password'], PASSWORD_DEFAULT))
				{
				// This code won't run for a while, but once there's a new default hashing...
				// ... method, this will update the user's current hash with a better one.
					$newHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
					$stmt = $DBH->prepare("UPDATE `staff` SET `password` = ? WHERE `staffID` = ?");

				try
				{    
					$stmt->execute([$newHash, $user['staffID']]);
				}
				catch (PDOException $e) {
					print "Error!: " . $e->getMessage() . "<br/>";
					die();
					}
				}

				// All good at this point. Start your session or whatever and continue...
				/******************   Local Staff *********************************/
				if (isset($user['access'])) {
					$timestamp = time();
					$_SESSION['login'] = array('access' => $user['access'], 
												'fulltime' => $user['fulltime'], 
												'staffNameFirst' => $user['staffNameFirst'], 
												'staffNameLast' => $user['staffNameLast'], 
												'staffID' => $user['staffID'], 
												'username' => $user['username'], 
												'branchID' => $user['branchID'],
												'timestamp' => $timestamp);
					
					header("location: /pages/Home.php");
				}
				else {
					$_SESSION['login']['access'] = '';
					header('location: /Error/');
				}
				return true;
			}
			else
			{
				// Wrong password
				$errmsg_arr[] = 'Password is incorrect';
				$errflag = true;

				if($errflag) {
					$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
					session_write_close();
					//exit();
				}
				header('location: /');
			}   

		}  //End third IF
		else {
			$errmsg_arr[] = 'Username/Password where not found';
			$errflag = true;

			if($errflag) {
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
				session_write_close();
				//exit();
			}
			header('location: /');
		}  
	}

	function logout() {
		$_SESSION = array();
		session_destroy();
		header("location: /index.php");
	}
}