<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class Common
{
	//Clear session array are return to referring page
	function clearReturn($page) {
		$_SESSION['form'] = array();
		header('location: '.$page);
	}

	//BranchID
	function branchID($DBH, $branchName) {
		$query = $DBH->prepare('SELECT branchID FROM branches WHERE branchNameShort = ?');
		$query->execute(array($branchName));
		$result = $query->fetch(PDO::FETCH_ASSOC);

		return $result['branchID'];
	}

	//Check if call exists
	function callCheck($DBH, $timeInputted, $dateInputted) {
		$callSearch = $DBH->prepare('SELECT callID FROM callinfo WHERE (timeInputted, dateInputted) = (?, ?)');
		$callSearch->execute(array($timeInputted, $dateInputted));
		$CSResult = $callSearch->fetch(PDO::FETCH_ASSOC);
		$result = $CSResult['callID'];
		return $result;
	}

	//Compare Client Details
	function clientCompare($DBH, $clientID, $clientNameID, $title, $firstName, $lastName, $landline, $mobile) {
		if(isset($clientID) && ($clientID != '')) {	//Check if there is a client ID and that it is not null
			$this->clientUpdate($DBH, $clientNameID, $title, $firstName, $lastName, $landline, $mobile, $clientID);
		}
		else{
			$clientID = $this->clientInsert($DBH, $title, $firstName, $lastName, $landline, $mobile, $clientNameID);
		}
		return $clientID;
	}

	//Compare Client Name Details
	function clientNameCompare($DBH, $clientNameID, $clientName, $postcode) {
		if(isset($clientNameID) && ($clientNameID != '')) {	//Check if there is a client name ID and that it is not null
			$this->clientNameUpdate($DBH, $clientName, $postcode, $clientNameID);
		}
		else {
			if(isset($clientName) && ($clientName != '')){
				$clientNameID = $this->clientNameInsert($DBH, $clientName, $postcode);
			}
			else{
				$clientNameID = NULL;
			}
		}
		return $clientNameID;
	}

	//Insert client details to table 																			
	function clientInsert($DBH, $title, $firstName, $lastName, $landline, $mobile, $clientNameID) {
		$insert = 'INSERT INTO client (title,
										firstName,
										lastName,
										landline,
										mobile, 
										clientNameID) 
								VALUES (:title,
										:firstName,
										:lastName,
										:landline,
										:mobile,
										:clientNameID)';

		$CTI = $DBH->prepare($insert);
		$CTI->bindParam(':title', $title);
		$CTI->bindParam(':firstName', ucwords($firstName));
		$CTI->bindParam(':lastName', ucwords($lastName));
		$CTI->bindParam(':landline', $landline);
		$CTI->bindParam(':mobile', $mobile);
		$CTI->bindParam(':clientNameID', $clientNameID);
		$CTI->execute();
		$ID = $DBH->lastInsertId();
		return $ID;
	}

	//Update client details
	function clientUpdate($DBH, $clientNameID, $title, $firstName, $lastName, $landline, $mobile, $clientID) {
		$clientUpdate = 'UPDATE client 
							SET clientNameID = ?,
								title =?, 
								firstName = ?, 
								lastName = ?, 
								landline = ?, 
								mobile = ?
							WHERE clientID = ?';
		$CU = $DBH->prepare($clientUpdate);
		$CU->execute(array(	$clientNameID,
							$title, 
							ucwords($firstName), 
							ucwords($lastName), 
							$landline, 
							$mobile, 
							$clientID));
	}

	//Insert ClientName
	function clientNameInsert($DBH, $clientName, $postcode) {
		$insert = 'INSERT INTO clientname (clientName, postcode)
										VALUES (:clientName, :postcode)';
		$CNI = $DBH->prepare($insert);
		$CNI->bindParam(':clientName', ucwords($clientName));
		$CNI->bindParam(':postcode', strtoupper($postcode));
		$CNI->execute();

		$ID = $DBH->lastInsertId();

	    return $ID;
	}

	//Update clientName
	function clientNameUpdate($DBH, $clientName, $postcode, $clientNameID) {
		$clientUpdate = 'UPDATE clientname SET clientName = ?, postcode = ? WHERE clientNameID = ?';
		$CNU = $DBH->prepare($clientUpdate);
		$CNU->execute(array(ucwords($clientName), strtoupper($postcode), $clientNameID));
	}

	function tempCompareAddress($DBH, $title, $firstName, $lastName, $landline, $mobile, $addressOne, $addressTwo, $city, $postcode, $branchID, $tempID) {
		if(isset($tempID) && ($tempID != '')) {
			$this->tempUpdateAddress($DBH, $title, $firstName, $lastName, $landline, $mobile, $addressOne, $addressTwo, $city, $postcode, $branchID, $tempID);

			$tempID = $tempID;
		}
		else{
			$tempID = $this->tempInsertAddress($DBH, $title, $firstName, $lastName, $landline, $mobile, $addressOne, $addressTwo, $city, $postcode, $branchID);
		}
		return $tempID;
	}

	//Insert temp details to table
	function tempInsertAddress($DBH, $title, $firstName, $lastName, $landline, $mobile, $addressOne, $addressTwo, $city, $postcode, $branchID) {
	    	$tempInput = 'INSERT INTO temp (title,
										firstName,
										lastName,
										landline,
										mobile,
										addressOne, 
										addressTwo, 
										city, 
										postcode,
										branchID
										) 
								VALUES (:title,
										:firstName,
										:lastName,
										:landline,
										:mobile,
										:addressOne, 
										:addressTwo, 
										:city, 
										:postcode,
										:branchID)';
			$TTI = $DBH->prepare($tempInput);
			$TTI->bindParam(':title', $title);
			$TTI->bindParam(':firstName', ucwords($firstName));
			$TTI->bindParam(':lastName', ucwords($lastName));
			$TTI->bindParam(':landline', $landline);
			$TTI->bindParam(':mobile', $mobile);
			$TTI->bindParam(':addressOne', ucwords($addressOne));
			$TTI->bindParam(':addressTwo', ucwords($addressTwo));
			$TTI->bindParam(':city', ucwords($city));
			$TTI->bindParam(':postcode', strtoupper($postcode));
			$TTI->bindParam(':branchID', $branchID);
			$TTI->execute();
			$tempID = $DBH->lastInsertId();
			return $tempID;		
		}

	//Update temp details
	function tempUpdateAddress($DBH, $title, $firstName, $lastName, $landline, $mobile, $addressOne, $addressTwo, $city, $postcode, $branchID, $tempID) {
		$tempUpdate = 'UPDATE temp SET 
								title =?, 
								firstName = ?, 
								lastName =?, 
								landline = ?, 
								mobile = ?,
								addressOne = ?, 
								addressTwo = ?, 
								city = ?, 
								postcode = ?,
								branchID = ?
								WHERE tempID = ?';
		$CU = $DBH->prepare($tempUpdate);
		$CU->execute(array($title, 
							ucwords($firstName), 
							ucwords($lastName), 
							$landline, 
							$mobile,
							ucwords($addressOne), 
							ucwords($addressTwo), 
							ucwords($city), 
							strtoupper($postcode),
							$branchID, 
							$tempID));
	}

	function tempCompare($DBH, $title, $firstName, $lastName, $landline, $mobile, $branchID, $tempID) {
		if(isset($tempID) && ($tempID != '')) {
			$this->tempUpdate($DBH, $title, $firstName, $lastName, $landline, $mobile, $branchID, $tempID);

			$tempID = $tempID;
		}
		else{
			$tempID = $this->tempInsert($DBH, $title, $firstName, $lastName, $landline, $mobile, $branchID);
		}
		return $tempID;
	}

	//Insert temp details to table
	function tempInsert($DBH, $title, $firstName, $lastName, $landline, $mobile, $branchID) {
	    	$tempInput = 'INSERT INTO temp (title,
										firstName,
										lastName,
										landline,
										mobile,
										branchID
										) 
								VALUES (:title,
										:firstName,
										:lastName,
										:landline,
										:mobile,
										:branchID)';
			$TTI = $DBH->prepare($tempInput);
			$TTI->bindParam(':title', $title);
			$TTI->bindParam(':firstName', ucwords($firstName));
			$TTI->bindParam(':lastName', ucwords($lastName));
			$TTI->bindParam(':landline', $landline);
			$TTI->bindParam(':mobile', $mobile);
			$TTI->bindParam(':branchID', $branchID);
			$TTI->execute();
			$tempID = $DBH->lastInsertId();
			return $tempID;		
		}

	//Update temp details
	function tempUpdate($DBH, $title, $firstName, $lastName, $landline, $mobile, $branchID, $tempID) {
		$tempUpdate = 'UPDATE temp SET 
								title =?, 
								firstName = ?, 
								lastName =?, 
								landline = ?, 
								mobile = ?,
								branchID = ?
								WHERE tempID = ?';
		$CU = $DBH->prepare($tempUpdate);
		$CU->execute(array($title, 
							ucwords($firstName), 
							ucwords($lastName), 
							$landline, 
							$mobile,
							$branchID, 
							$tempID));
	}

	//Insert call details to table
	function callInsert($DBH, $clientID, $clientNameID, $tempID, $branchID, $contact, $staffID, $type, $status, $details, $further, $currentTime, $currentDate) {
		$callInput = 'INSERT INTO callinfo (clientID, 
											clientNameID, 
											tempID, 
											branchID, 
											contact,
											staffID, 
											type, 
											status, 
											details,
											further,
											timeInputted,
											dateInputted) 
									VALUES (:clientID, 
											:clientNameID, 
											:tempID, 
											:branchID, 
											:contact, 
											:staffID, 
											:type, 
											:status, 
											:details,
											:further,
											:timeInputted,
											:dateInputted)';
			
		$CI = $DBH->prepare($callInput);
		$CI->bindParam(':clientID', $clientID);
		$CI->bindParam(':clientNameID', $clientNameID);
		$CI->bindParam(':tempID', $tempID);
		$CI->bindParam(':branchID', $branchID);
		$CI->bindParam(':contact', $contact);
		$CI->bindParam(':staffID', $staffID);
		$CI->bindParam(':type', $type);
		$CI->bindParam(':status', $status);
		$CI->bindParam(':details', $details);
		$CI->bindValue(':further', $further);
		$CI->bindParam(':timeInputted', $currentTime);
		$CI->bindParam(':dateInputted', $currentDate);
		$CI->execute();
		$callID = $DBH->lastInsertId();

		if($status == 'Completed') {
			$datetime = date('Y-m-d H:i:s');
			$query = 'UPDATE callinfo SET completed = ? WHERE callID = ?';
			$Q = $DBH->prepare($query);
			$Q->execute(array($datetime, $callID));
		}

		return $callID;
	}

	//Update call details
	function callUpdate($DBH, $clientID, $clientNameID, $tempID, $branchID, $contact, $status, $details, $further, $callID) {
		$callUpdate = 'UPDATE callinfo SET clientID = ?, 
											clientNameID = ?, 
											tempID = ?, 
											branchID = ?, 
											contact = ?,
											status = ?, 
											details = ?,
											further = ?
											WHERE callID = ?';
			
		$CI = $DBH->prepare($callUpdate);
		$CI->execute(array($clientID, 
							$clientNameID, 
							$tempID, 
							$branchID, 
							$contact,
							$status, 
							$details, 
							$further,
							$callID));

		

		if($status == 'Completed') {
			$datetime = date('Y-m-d H:i:s');
			$query = 'UPDATE callinfo SET completed = ? WHERE callID = ?';
			$Q = $DBH->prepare($query);
			$Q->execute(array($datetime, $callID));
		}
	}

	function further($DBH, $further, $currentTime, $currentDate, $staffID) {
		if ($further == "") {
			return $further;
		}
		else {
			$further = $further." - ".$staffID." ".$currentTime."-".$currentDate;
			return $further;
		}
	}

	//Subtraction String from string
	function furtherExtra($DBH, $callID, $further, $currentTime, $currentDate, $staffID) {
		
		if (isset($callID) && ($callID != '') && ($further != '')) {
			$currentFurther = $DBH->prepare('SELECT further FROM callinfo WHERE callID = ?');
		    $currentFurther->execute(array($callID));
		    $CFResult = $currentFurther->fetch(PDO::FETCH_ASSOC);

		    //Subtraction String from string
		    $existingFurther = $CFResult['further'];
			//echo "<br /> Database further: ".$existingFurther."<br />";
			$str = $further;
			//echo "str = ".$str."<br />";
			$str2 = substr($str, strlen($existingFurther));
			//echo "str2 = ".$str2."<br />";
			$newFurther = $existingFurther.$str2." - ".$staffID." ".$currentTime."-".$currentDate;
			//$CFResult['further'].$str2;

			return $newFurther;
		}
		else {
			$newFurther = $further;
			return $newFurther;
		}
	}
}