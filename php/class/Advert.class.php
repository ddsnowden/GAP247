<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class Advert {
	
	function recall($DBH) {
		$recall = $DBH->prepare('SELECT callinfo.callID, 
										callinfo.dateInputted, 
										callinfo.timeInputted, 
										callinfo.emailed, 
										branches.branchNameShort, 
										temp.firstName, 
										temp.lastName, 
										temp.landline, 
										temp.mobile 
								FROM callinfo
								INNER JOIN temp AS temp ON callinfo.tempID = temp.tempID
								INNER JOIN advert AS advert ON callinfo.callID = advert.callID
								LEFT JOIN branches AS branches ON callinfo.branchID = branches.branchID
								WHERE callinfo.type = "advert"
								ORDER BY callinfo.dateInputted DESC, callinfo.timeInputted DESC');
		$recall->execute();
		$recallResult = $recall->fetchALL(PDO::FETCH_ASSOC);
		return $recallResult;
	}

	function insert($DBH, $callID, $jobType, $position, $advertLocation,
								$disqual, $disqualDetails, $tacho, $other, $employed,
								$currentPos, $previousPos1, $previousPos2,
								$currentCompany, $previousCompany1, $previousCompany2,
								$agency1, $agency2, $agency3,
								$agencyName1, $agencyName2, $agencyName3,
								$supervisorName1, $supervisorName2, $supervisorName3,
								$transport, $preferHours, $travel, $salary, $age,
								$twelveMonths, $media, $licence) {
		$query = 'INSERT INTO advert (callID, jobType, position, advertLocation,
								disqual, disqualDetails, tacho, other, employed,
								currentPos, previousPos1, previousPos2,
								currentCompany, previousCompany1, previousCompany2,
								agency1, agency2, agency3,
								agencyName1, agencyName2, agencyName3,
								supervisorName1, supervisorName2, supervisorName3,
								transport, preferHours, travel, salary, age,
								twelveMonths, media, licence)
							VALUES (:callID, :jobType, :position, :advertLocation,
								:disqual, :disqualDetails, :tacho, :other, :employed,
								:currentPos, :previousPos1, :previousPos2,
								:currentCompany, :previousCompany1, :previousCompany2,
								:agency1, :agency2, :agency3,
								:agencyName1, :agencyName2, :agencyName3,
								:supervisorName1, :supervisorName2, :supervisorName3,
								:transport, :preferHours, :travel, :salary, :age,
								:twelveMonths, :media, :licence)';
			
			$BI = $DBH->prepare($query);
			$BI->bindParam(':callID', $callID);
			$BI->bindParam(':jobType', $jobType);
			$BI->bindParam(':position', $position);
			$BI->bindParam(':advertLocation', $advertLocation);
			$BI->bindParam(':disqual', $disqual);
			$BI->bindParam(':disqualDetails', $disqualDetails);
			$BI->bindParam(':tacho', $tacho);
			$BI->bindParam(':other', $other);
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
			$BI->bindParam(':preferHours', $preferHours);
			$BI->bindParam(':travel', $travel);
			$BI->bindParam(':salary', $salary);
			$BI->bindParam(':age', $age);
			$BI->bindParam(':twelveMonths', $twelveMonths);
			$BI->bindParam(':media', $media);
			$BI->bindParam(':licence', $licence);

			$BI->execute();
	}

	function update($DBH, $jobType, $position, $advertLocation, $disqual,
							$disqualDetails, $tacho, $other, $employed,
							$currentPos, $previousPos1, $previousPos2,
							$currentCompany, $previousCompany1, $previousCompany2,
							$agency1, $agency2, $agency3,
							$agencyName1, $agencyName2, $agencyName3,
							$supervisorName1, $supervisorName2, $supervisorName3,
							$transport, $preferHours, $travel, $salary, $age,
							$twelveMonths, $media, $licence, $callID) {
		$query = 'UPDATE advert SET jobType = ?, position = ?, advertLocation = ?,
											disqual = ?, disqualDetails = ?, tacho = ?, other = ?, 
											employed = ?, currentPos = ?, previousPos1 = ?, previousPos2 = ?,
											currentCompany = ?, previousCompany1 = ?, previousCompany2 = ?,
											agency1 = ?, agency2 = ?, agency3 = ?,
											agencyName1 = ?, agencyName2 = ?, agencyName3 = ?,
											supervisorName1 = ?, supervisorName2 = ?, supervisorName3 = ?,
											transport = ?, preferHours = ?, travel = ?, salary = ?, age =?,
											twelveMonths = ?, media = ?, licence = ?
										WHERE callID = ?';

		$BI = $DBH->prepare($query);

		$BI->execute(array($jobType, $position, $advertLocation, $disqual,
							$disqualDetails, $tacho, $other, $employed,
							$currentPos, $previousPos1, $previousPos2,
							$currentCompany, $previousCompany1, $previousCompany2,
							$agency1, $agency2, $agency3,
							$agencyName1, $agencyName2, $agencyName3,
							$supervisorName1, $supervisorName2, $supervisorName3,
							$transport, $preferHours, $travel, $salary, $age,
							$twelveMonths, $media, $licence, $callID));
	}

}