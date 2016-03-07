<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once $root.'/assets/php/db.php';
require_once $root.'/assets/php/class/Branches.class.php';


class CallsEmail extends Branches{

	function diff($start, $finish) {
		$start = new DateTime($start);
		$finish = new DateTime($finish);
		$difference = $start->diff($finish);
		$elapsed = (float)$difference->format('%r%Y%m%d%H%i');
		return $difference;
	}

	function secondsToTime($seconds) {
	    $dtF = new DateTime("@0");
	    $dtT = new DateTime("@$seconds");
	    return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
	}

	function format($DBH, $data) {
		$result['first'] = reset($data);
		$result['last'] = end($data);
		$result['count'] = count($data);
		$sum = 0;
		foreach ($data as $key) {
			$sum += $key['diff'];
		}
		if($sum == 0) {
			$result['diff'] = 0;
		}
		else {
			$result['diff'] = (string)round($sum/$result['count'], 0);
		}

		return $result;
	}
}