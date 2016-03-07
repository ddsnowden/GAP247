<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';

class WorkingTimes {

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
									FROM callinfo, temp, branches, working
									WHERE branches.branchID = callinfo.branchID
									AND callinfo.callID = working.callID
									AND callinfo.tempID = temp.tempID
									AND callinfo.type = "working times"
									GROUP BY callinfo.callID
									ORDER BY callinfo.dateInputted DESC, callinfo.timeInputted DESC');
		$query->execute();
		$result = $query->fetchALL(PDO::FETCH_ASSOC);
		return $result;
	}

	function workingInsert($DBH, $callID, $monclient, $montype, $monstart, $monfinish, $tueclient, $tuetype, $tuestart, $tuefinish, $wedclient, $wedtype, $wedstart, $wedfinish, $thuclient, $thutype, $thustart, $thufinish, $friclient, $fritype, $fristart, $frifinish, $satclient, $sattype, $satstart, $satfinish, $sunclient, $suntype, $sunstart, $sunfinish) {
		//insert into workingTimes table and collect last insert id
		$workingInput = 'INSERT INTO working (callID, 
						monclient, 
						montype,
						monstart,
						monfinish,
						tueclient, 
						tuetype,
						tuestart,
						tuefinish,
						wedclient, 
						wedtype,
						wedstart,
						wedfinish,
						thuclient, 
						thutype,
						thustart,
						thufinish,
						friclient, 
						fritype,
						fristart,
						frifinish,
						satclient, 
						sattype,
						satstart,
						satfinish,
						sunclient, 
						suntype,
						sunstart,
						sunfinish) 
					VALUES (:callID, 
						:monclient, 
						:montype,
						:monstart,
						:monfinish,
						:tueclient, 
						:tuetype,
						:tuestart,
						:tuefinish,
						:wedclient, 
						:wedtype,
						:wedstart,
						:wedfinish,
						:thuclient, 
						:thutype,
						:thustart,
						:thufinish,
						:friclient, 
						:fritype,
						:fristart,
						:frifinish,
						:satclient, 
						:sattype,
						:satstart,
						:satfinish,
						:sunclient, 
						:suntype,
						:sunstart,
						:sunfinish)';

		$BI = $DBH->prepare($workingInput);
		$BI->bindParam(':callID', $callID);

		$BI->bindParam(':monclient', $monclient);
		$BI->bindParam(':montype', $montype);
		$BI->bindParam(':monstart', $monstart);
		$BI->bindParam(':monfinish', $monfinish);

		$BI->bindParam(':tueclient', $tueclient);
		$BI->bindParam(':tuetype', $tuetype);
		$BI->bindParam(':tuestart', $tuestart);
		$BI->bindParam(':tuefinish', $tuefinish);

		$BI->bindParam(':wedclient', $wedclient);
		$BI->bindParam(':wedtype', $wedtype);
		$BI->bindParam(':wedstart', $wedstart);
		$BI->bindParam(':wedfinish', $wedfinish);

		$BI->bindParam(':thuclient', $thuclient);
		$BI->bindParam(':thutype', $thutype);
		$BI->bindParam(':thustart', $thustart);
		$BI->bindParam(':thufinish', $thufinish);

		$BI->bindParam(':friclient', $friclient);
		$BI->bindParam(':fritype', $fritype);
		$BI->bindParam(':fristart', $fristart);
		$BI->bindParam(':frifinish', $frifinish);

		$BI->bindParam(':satclient', $satclient);
		$BI->bindParam(':sattype', $sattype);
		$BI->bindParam(':satstart', $satstart);
		$BI->bindParam(':satfinish', $satfinish);

		$BI->bindParam(':sunclient', $sunclient);
		$BI->bindParam(':suntype', $suntype);
		$BI->bindParam(':sunstart', $sunstart);
		$BI->bindParam(':sunfinish', $sunfinish);
		$BI->execute();
	}

	function workingUpdate($DBH, $monclient, $montype, $monstart, $monfinish, $tueclient, $tuetype, $tuestart, $tuefinish, $wedclient, $wedtype, $wedstart, $wedfinish, $thuclient, $thutype, $thustart, $thufinish, $friclient, $fritype, $fristart, $frifinish, $satclient, $sattype, $satstart, $satfinish, $sunclient, $suntype, $sunstart, $sunfinish, $callID) {
		$workingUpdate = 'UPDATE working SET monclient = ?,
												montype = ?,
												monstart = ?,
												monfinish = ?,
												tueclient = ?,
												tuetype = ?,
												tuestart = ?,
												tuefinish = ?,
												wedclient = ?,
												wedtype = ?,
												wedstart = ?,
												wedfinish = ?,
												thuclient = ?,
												thutype = ?,
												thustart = ?,
												thufinish = ?,
												friclient = ?,
												fritype = ?,
												fristart = ?,
												frifinish = ?,
												satclient = ?,
												sattype = ?,
												satstart = ?,
												satfinish = ?,
												sunclient = ?,
												suntype = ?,
												sunstart = ?,
												sunfinish = ? 
												WHERE callID = ?';

		$BI = $DBH->prepare($workingUpdate);
		$BI->execute(array($monclient, $montype, $monstart, $monfinish, $tueclient, $tuetype, $tuestart, $tuefinish, $wedclient, $wedtype, $wedstart, $wedfinish, $thuclient, $thutype, $thustart, $thufinish, $friclient, $fritype, $fristart, $frifinish, $satclient, $sattype, $satstart, $satfinish, $sunclient, $suntype, $sunstart, $sunfinish, $callID));
	}

	function clientList($DBH) {
		$client = $DBH->prepare('SELECT * FROM clientname;');
		$client->execute();
		$clientResult = $client->fetchAll(PDO::FETCH_ASSOC);
		return $clientResult;
	}
}