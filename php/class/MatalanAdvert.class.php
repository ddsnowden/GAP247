<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class Matalan {
	
	function recall($DBH) {
		$query = $DBH->prepare('SELECT callinfo.callID, 
										callinfo.dateInputted, 
										callinfo.timeInputted, 
										callinfo.emailed, 
										branches.branchNameShort, 
										temp.firstName, 
										temp.lastName, 
										temp.landline, 
										temp.mobile 
										FROM callinfo
										inner join branches as branches on callinfo.branchID = branches.branchID
										inner join temp as temp on callinfo.tempID = temp.tempID
										inner join advert as advert on callinfo.callID = advert.callID
										WHERE callinfo.type = "Matalan Advert"
										AND callinfo.dateInputted >= (CURDATE() - INTERVAL 14 DAY)
										ORDER BY callinfo.dateInputted DESC, callinfo.timeInputted DESC');
		$query->execute();
		$result = $query->fetchALL(PDO::FETCH_ASSOC);
		return $result;
	}

	function insert($DBH, $callID, $jobType, $advertLocation, $employed,
								$currentPos, $previousPos1, $previousPos2,
								$currentCompany, $previousCompany1, $previousCompany2,
								$agency1, $agency2, $agency3,
								$agencyName1, $agencyName2, $agencyName3,
								$supervisorName1, $supervisorName2, $supervisorName3,
								$transport, $travel, $salary, $age,
								$workTimeMorn, $workTimeEve, $workTimeNight, $workTimeEnds,
								$twelveMonths, $pastMat, $otherPos, $dbs, $reference) {
		 $query = 'INSERT INTO advert (callID, jobType, advertLocation, employed, 
		 						currentPos, previousPos1, previousPos2,
								currentCompany, previousCompany1, previousCompany2,
								agency1, agency2, agency3,
								agencyName1, agencyName2, agencyName3, 
								supervisorName1, supervisorName2, supervisorName3,
								transport, travel, salary, age, 
								workTimeMorn, workTimeEve, workTimeNight, workTimeEnds,
								twelveMonths, pastMat, otherPos, dbs, reference)
							VALUES (:callID, :jobType, :advertLocation, :employed,
								:currentPos, :previousPos1, :previousPos2,
								:currentCompany, :previousCompany1, :previousCompany2,
								:agency1, :agency2, :agency3,
								:agencyName1, :agencyName2, :agencyName3,
								:supervisorName1, :supervisorName2, :supervisorName3,
								:transport, :travel, :salary, :age,
								:workTimeMorn, :workTimeEve, :workTimeNight, :workTimeEnds,
								:twelveMonths, :pastMat, :otherPos, :dbs, :reference)';
			
			$BI = $DBH->prepare($query);
			$BI->bindParam(':callID', $callID);
			$BI->bindParam(':jobType', $jobType);
			$BI->bindParam(':advertLocation', $advertLocation);
			$BI->bindParam(':employed', $employed);
			$BI->bindParam(':currentPos', $currentPos);
			$BI->bindParam(':previousPos1', $previousPos1);
			$BI->bindParam(':previousPos2', $previousPos2);
			$BI->bindParam(':currentCompany', $currentCompany);
			$BI->bindParam(':previousCompany1', $previousCompany1);
			$BI->bindParam(':previousCompany2', $previousCompany2);
			$BI->bindParam(':agency1', $agency1);
			$BI->bindParam(':agency2', $agency2);
			$BI->bindParam(':agency3', $agency3);
			$BI->bindParam(':agencyName1', $agencyName1);
			$BI->bindParam(':agencyName2', $agencyName2);
			$BI->bindParam(':agencyName3', $agencyName3);
			$BI->bindParam(':supervisorName1', $supervisorName1);
			$BI->bindParam(':supervisorName2', $supervisorName2);
			$BI->bindParam(':supervisorName3', $supervisorName3);
			$BI->bindParam(':transport', $transport);
			$BI->bindParam(':travel', $travel);
			$BI->bindParam(':salary', $salary);
			$BI->bindParam(':age', $age);
			$BI->bindParam(':workTimeMorn', $workTimeMorn);
			$BI->bindParam(':workTimeEve', $workTimeEve);
			$BI->bindParam(':workTimeNight', $workTimeNight);
			$BI->bindParam(':workTimeEnds', $workTimeEnds);
			$BI->bindParam(':twelveMonths', $twelveMonths);
			$BI->bindParam(':pastMat', $pastMat);
			$BI->bindParam(':otherPos', $otherPos);
			$BI->bindParam(':dbs', $dbs);
			$BI->bindParam(':reference', $reference);

			$BI->execute();
	}

	function update($DBH, $jobType, $advertLocation, $employed,
							$currentPos, $previousPos1, $previousPos2,
							$currentCompany, $previousCompany1, $previousCompany2,
							$agency1, $agency2, $agency3,
							$agencyName1, $agencyName2, $agencyName3,
							$supervisorName1, $supervisorName2, $supervisorName3,
							$transport, $travel, $age,
							$workTimeMorn, $workTimeEve, $workTimeNight, $workTimeEnds,
							$twelveMonths, $pastMat, $otherPos, $dbs, $reference, $callID) {
		$query = 'UPDATE advert SET jobType = ?, advertLocation = ?, employed = ?,
									currentPos = ?, previousPos1 = ?, previousPos2 = ?,
									currentCompany = ?, previousCompany1 = ?, previousCompany2 = ?,
									agency1 = ?, agency2 = ?, agency3 = ?,
									agencyName1 = ?, agencyName2 = ?, agencyName3 = ?,
									supervisorName1 = ?, supervisorName2 = ?, supervisorName3 = ?,
									transport = ?, travel = ?, age = ?,
									workTimeMorn = ?, workTimeEve = ?, workTimeNight = ?, workTimeEnds = ?,
									twelveMonths = ?, pastMat = ?, otherPos = ?, dbs = ?, reference = ?
								WHERE callID = ?';

		$BI = $DBH->prepare($query);

		$BI->execute(array($jobType, $advertLocation, $employed,
							$currentPos, $previousPos1, $previousPos2,
							$currentCompany, $previousCompany1, $previousCompany2,
							$agency1, $agency2, $agency3,
							$agencyName1, $agencyName2, $agencyName3,
							$supervisorName1, $supervisorName2, $supervisorName3,
							$transport, $travel, $age,
							$workTimeMorn, $workTimeEve, $workTimeNight, $workTimeEnds,
							$twelveMonths, $pastMat, $otherPos, $dbs, $reference, $callID));
	}

}