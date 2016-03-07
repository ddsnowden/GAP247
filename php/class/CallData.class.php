<?php
	class CallData {

		public function branchID($DBH, $branch) {
			$branchID = $DBH->prepare('SELECT branchID FROM branches WHERE branchNameShort = ?');
			$branchID->execute(array($branch));
			$branchID = $branchID->fetch(PDO::FETCH_ASSOC);

			return $branchID['branchID'];
		}

		public function daysInMonth($DBH) {
			$days = $DBH->prepare('SELECT datefield FROM calendar WHERE datefield > last_day(date_sub(now(), INTERVAL 1 MONTH)) and datefield <= last_day(now()) ORDER BY datefield ASC');
		    $days->execute();
		    $days = $days->fetchAll(PDO::FETCH_ASSOC);

		   	return $days;
		}

		public function daysJoined($DBH) {
			foreach ($this->daysInMonth($DBH) as $key) {
		      $daysList[] = date('d', strtotime($key['datefield']));
		    }

		    $daysJoined = join(', ', $daysList);

		    return $daysJoined;
		}

		public function monthsPastYears($DBH) {
			$months = $DBH->prepare("SELECT DISTINCT DATE_FORMAT(datefield, '%Y-%m') AS yearMonth FROM calendar WHERE datefield BETWEEN DATE_SUB(NOW(), INTERVAL 2 YEAR) and CURDATE() ORDER BY yearMonth");
		    $months->execute();
		    $months = $months->fetchAll(PDO::FETCH_ASSOC);
		    
		    return $months;
		}

		public function monthsJoined($DBH) {
			foreach ($this->monthsPastYears($DBH) as $key) {
		      $month[] = $key['yearMonth'];
		    }

		    $monthsJoined = "'".join("','", $month)."'";

		    return $monthsJoined;
		}

		public function daysYear($DBH) {
			$daysYear = $DBH->prepare('SELECT datefield FROM calendar WHERE YEAR(calendar.datefield) = YEAR(now()) ORDER BY calendar.datefield ASC');
		    $daysYear->execute();
		    $daysYear = $daysYear->fetchAll(PDO::FETCH_ASSOC);

		    return $daysYear;
		}

		/****************************************************************************  Collect all months for the past two years *******************************************/
	    public function twoYearTotal($DBH) {
		    $twoYear = $DBH->prepare('SELECT count(callID) FROM callinfo WHERE DATE_FORMAT(dateInputted, "%Y-%m") = ?');
		    foreach ($this->monthsPastYears($DBH) as $key) {
		      $twoYear->execute(array($key['yearMonth']));
		      $twoYearResult[] = $twoYear->fetchAll(PDO::FETCH_ASSOC);
		    }

		    foreach ($twoYearResult as $key) {
		      $TYResults[] = $key[0]['count(callID)'];
		    }

		    $twoYearJoined = join(', ', $TYResults);

		    return $twoYearJoined;
		}

	    public function twoYearClientTotal($DBH, $branchID) {
		    $twoYearClient = $DBH->prepare('SELECT count(callID) FROM callinfo WHERE (DATE_FORMAT(dateInputted, "%Y-%m"), branchID) = (?, ?) AND (type = "Bookings" or type = "cancellations" or type = "Temp No Show" or type = "client other issues")');
		    foreach ($this->monthsPastYears($DBH) as $key) {
		      $twoYearClient->execute(array($key['yearMonth'], $branchID));
		      $twoYearClientresult[] = $twoYearClient->fetchAll(PDO::FETCH_ASSOC);
		    }

		    foreach ($twoYearClientresult as $key) {
		      $TYCResults[] = $key[0]['count(callID)'];
		    }

		    $twoYearClientJoined = join(', ', $TYCResults);

		    return $twoYearClientJoined;
		}

	    public function twoYearTempTotal($DBH, $branchID) {
		    $twoYearTemp = $DBH->prepare('SELECT count(callID) FROM callinfo WHERE (DATE_FORMAT(dateInputted, "%Y-%m"), branchID) = (?, ?)  AND (type = "Matalan Advert" or type = "sickness or absence" or type = "other temp issues" or type = "pay queries")');
		    foreach ($this->monthsPastYears($DBH) as $key) {
		      $twoYearTemp->execute(array($key['yearMonth'], $branchID));
		      $twoYearTempresult[] = $twoYearTemp->fetchAll(PDO::FETCH_ASSOC);
		    }

		    foreach ($twoYearTempresult as $key) {
		      $TYTResults[] = $key[0]['count(callID)'];
		    }

		    $twoYearTempJoined = join(', ', $TYTResults);

		    return $twoYearTempJoined;
		}

		/***********************************************************************************************************************************  Client Calls  *******************************************************************************************/
		public function bookings($DBH, $branchID) {
			$bookings = $DBH->prepare('SELECT count(callID) FROM callinfo WHERE (dateInputted, branchID) = (?, ?) AND type = "Bookings"');
			foreach ($this->daysInMonth($DBH) as $key) {
				$bookings->execute(array($key['datefield'], $branchID));
				$bookTotal[] = $bookings->fetchAll(PDO::FETCH_ASSOC);
			}

			foreach ($bookTotal as $key => $value) {
		      $bTotal[] = $value[0]['count(callID)'];
		    }
		    $bTotal = join(',', $bTotal);

		    return $bTotal;
		}

		public function cancel($DBH, $branchID) {
			$cancel = $DBH->prepare('SELECT count(callID) FROM callinfo WHERE (dateInputted, branchID) = (?, ?) AND type = "cancellations"');
			foreach ($this->daysInMonth($DBH) as $key) {
				$cancel->execute(array($key['datefield'], $branchID));
				$cancelTotal[] = $cancel->fetchAll(PDO::FETCH_ASSOC);
			}
			foreach ($cancelTotal as $key => $value) {
		      $cTotal[] = $value[0]['count(callID)'];
		    }
		    $cTotal = join(',', $cTotal);

		    return $cTotal;
		}

		public function noShow($DBH, $branchID) {
			$noShow = $DBH->prepare('SELECT count(callID) FROM callinfo WHERE (dateInputted, branchID) = (?, ?) AND type = "Temp No Show"');
			foreach ($this->daysInMonth($DBH) as $key) {
				$noShow->execute(array($key['datefield'], $branchID));
				$noShowTotal[] = $noShow->fetchAll(PDO::FETCH_ASSOC);
			}
			foreach ($noShowTotal as $key => $value) {
		      $NSTotal[] = $value[0]['count(callID)'];
		    }
		    $NSTotal = join(',', $NSTotal);

		    return $NSTotal;
		}

		public function clientOther($DBH, $branchID) {
			$clientIssue = $DBH->prepare('SELECT count(callID) FROM callinfo WHERE (dateInputted, branchID) = (?, ?) AND type = "client other issues"');
			foreach ($this->daysInMonth($DBH) as $key) {
				$clientIssue->execute(array($key['datefield'], $branchID));
				$clientIssueTotal[] = $clientIssue->fetchAll(PDO::FETCH_ASSOC);
			}
			foreach ($clientIssueTotal as $key => $value) {
		      $CITotal[] = $value[0]['count(callID)'];
		    }
		    $CITotal = join(',', $CITotal);

		    return $CITotal;
		}

		/***********************************************************************************************************************************  Temp Calls  *******************************************************************************************/
		public function matalan($DBH, $branchID) {
			$matalan = $DBH->prepare('SELECT count(callID) FROM callinfo WHERE (dateInputted, branchID) = (?, ?) AND type = "Matalan Advert"');
			foreach ($this->daysInMonth($DBH) as $key) {
				$matalan->execute(array($key['datefield'], $branchID));
				$matalanTotal[] = $matalan->fetchAll(PDO::FETCH_ASSOC);
			}
			foreach ($matalanTotal as $key => $value) {
		      $mTotal[] = $value[0]['count(callID)'];
		    }
		    $mTotal = join(',', $mTotal);

		    return $mTotal;
		}

		public function sick($DBH, $branchID) {
			$sick = $DBH->prepare('SELECT count(callID) FROM callinfo WHERE (dateInputted, branchID) = (?, ?) AND type = "sickness or absence"');
			foreach ($this->daysInMonth($DBH) as $key) {
				$sick->execute(array($key['datefield'], $branchID));
				$sickTotal[] = $sick->fetchAll(PDO::FETCH_ASSOC);
			}
			foreach ($sickTotal as $key => $value) {
		      $sTotal[] = $value[0]['count(callID)'];
		    }
		    $sTotal = join(',', $sTotal);

		    return $sTotal;
		}

		public function tempIssue($DBH, $branchID) {
			$tempIssues = $DBH->prepare('SELECT count(callID) FROM callinfo WHERE (dateInputted, branchID) = (?, ?) AND type = "other temp issues"');
			foreach ($this->daysInMonth($DBH) as $key) {
				$tempIssues->execute(array($key['datefield'], $branchID));
				$tempIssuesTotal[] = $tempIssues->fetchAll(PDO::FETCH_ASSOC);
			}
			foreach ($tempIssuesTotal as $key => $value) {
		      $tiTotal[] = $value[0]['count(callID)'];
		    }
		    $tiTotal = join(',', $tiTotal);

		    return $tiTotal;
		}

		public function pay($DBH, $branchID) {
			$pay = $DBH->prepare('SELECT count(callID) FROM callinfo WHERE (dateInputted, branchID) = (?, ?) AND type = "pay queries"');
			foreach ($this->daysInMonth($DBH) as $key) {
				$pay->execute(array($key['datefield'], $branchID));
				$payTotals[] = $pay->FetchAll(PDO::FETCH_ASSOC);
			}
			foreach ($payTotals as $key => $value) {
		      $PTotals[] = $value[0]['count(callID)'];
		    }
		    $PTotal = join(',', $PTotals);

		    return $PTotal;
		}

		/***********************************************************************************************************************************  Total Calls  *******************************************************************************************/
		public function clientTotal($DBH) {
			$callClientTotals = $DBH->prepare('SELECT count(callID) FROM `callinfo` where dateInputted = ? AND (type = "Bookings" or type = "cancellations" or type = "Temp No Show" or type = "client other issues")');
			foreach ($this->daysInMonth($DBH) as $key) {
		      $callClientTotals->execute(array($key['datefield']));
		      $totalClient[] = $callClientTotals->fetchAll(PDO::FETCH_ASSOC);
		    }
		    //Create the arrays
		    $clientData = array();

		    //Populate arrays from collected data
		    //Total
		    foreach ($totalClient as $key => $value) {
		      $clientData[] .= $value[0]['count(callID)'];
		    }

		    //Join array values into a string
		    $clientMonthJoined = join(',', $clientData);

		    return $clientMonthJoined;
		}

		public function tempTotal($DBH) {
			$callTempTotals = $DBH->prepare('SELECT count(callID) FROM `callinfo` where dateInputted = ? AND (type = "Matalan Advert" or type = "sickness or absence" or type = "other temp issues" or type = "pay queries")');
			foreach ($this->daysInMonth($DBH) as $key) {
		      $callTempTotals->execute(array($key['datefield']));
		      $totalTemp[] = $callTempTotals->fetchAll(PDO::FETCH_ASSOC);
		    }

		    //Create the arrays
		    $tData = array();

		    //Populate arrays from collected data
		    //Total
		    foreach ($totalTemp as $key => $value) {
		      $tData[] .= $value[0]['count(callID)'];
		    }

		    //Join array values into a string
		    $tempMonthJoined = join(',', $tData);

		    return $tempMonthJoined;
		}

		public function total($DBH) {
			$Totals = $DBH->prepare('SELECT count(callID) FROM `callinfo` where dateInputted = ?');
		    foreach ($this->daysYear($DBH) as $key) {
		      $Totals->execute(array($key['datefield']));
		      $totalCalls[] = $Totals->fetchAll(PDO::FETCH_ASSOC);
		    }

		    //Create the arrays
		    $TCData = array();

		    //Populate arrays from collected data
		    //Total
		    foreach ($totalCalls as $key => $value) {
		      $TCData[] .= $value[0]['count(callID)'];
		    }

		    //Join array values into a string
		    $totalYearJoined = join(',', $TCData);

		    return $totalYearJoined;
		}

		public function tempYearTotal($DBH) {
			$tempYearTotals = $DBH->prepare('SELECT count(callID) FROM `callinfo` WHERE dateInputted = ? AND (type = "Matalan Advert" or type = "sickness or absence" or type = "other temp issues" or type = "pay queries")');
		    foreach ($daysYear as $key) {
		      $tempYearTotals->execute(array($key['datefield']));
		      $tempTotalYear[] = $tempYearTotals->fetchAll(PDO::FETCH_ASSOC);
		    }

		    //Create the arrays
		    $tempYear = array();

		    //Populate arrays from collected data
		    //Total
		    foreach ($tempTotalYear as $key => $value) {
		      $tempYear[] .= $value[0]['count(callID)'];
		    }

		    //Join array values into a string
		    $tempYearJoined = join(',', $tempYear);

		    return $tempYearJoined;
		}

		public function clientYearTotal($DBH) {
			$clientYearTotals = $DBH->prepare('SELECT count(callID) FROM `callinfo` WHERE dateInputted = ? AND (type = "Bookings" or type = "cancellations" or type = "Temp No Show" or type = "client other issues")');
		    foreach ($daysYear as $key) {
		      $clientYearTotals->execute(array($key['datefield']));
		      $clientTotalYear[] = $clientYearTotals->fetchAll(PDO::FETCH_ASSOC);
		    }

		    //Create the arrays
		    $clientYear = array();

		    //Populate arrays from collected data
		    //Total
		    foreach ($clientTotalYear as $key => $value) {
		      $clientYear[] .= $value[0]['count(callID)'];
		    }

		    //Join array values into a string
		    $clientYearJoined = join(',', $clientYear);

		    return $clientYearJoined;
		}

		public function bookFillTotals($DBH, $branchID) {
			$bookfill = $DBH->prepare('SELECT sum(bookings.quantity) as booked, sum(bookings.filled) as filled FROM bookings 
											INNER JOIN callinfo as callinfo on bookings.callID = callinfo.callID
											WHERE branchID = ?');
			$bookfill->execute(array($branchID));
			$BFTotals = $bookfill->fetchAll(PDO::FETCH_ASSOC);

			return $BFTotals;
		}

		public function noshowFillTotals($DBH, $branchID) {
			$noShow = $DBH->prepare('SELECT sum(tempnoshow.noQuantity) as noQuant, sum(tempnoshow.fillQuantity) as filled FROM tempnoshow 
											INNER JOIN callinfo as callinfo on tempnoshow.callID = callinfo.callID
											WHERE branchID = ?');
			$noShow->execute(array($branchID));
			$NSTotals = $noShow->fetchAll(PDO::FETCH_ASSOC);

			return $NSTotals;
		}
	}