<?php

$answers = (isset($_POST['answer']) ? $_POST['answer'] : []);
foreach ($answers as $key => $value) {
	$a_arr      = fh_get_num($key);
	$a_arr_c    = count($a_arr);
	$a_survey   = (int)($a_arr[0]);
	$a_id       = ($a_arr_c != 3 ? (int)($a_arr[1]) : 0 );
	$a_type     = ($a_arr_c != 3 ? db_get("answers", "type", $a_id) : 'check' );
	$a_step     = ($a_arr_c != 3 ? db_get("answers", "step", $a_id) : (int)($a_arr[1]) );
	$a_question = ($a_arr_c != 3 ? db_get("answers", "question", $a_id) : (int)($a_arr[2]) );
	$a_question = db_get("questions", "id", $a_question, "sort", "&& survey = '{$a_survey}'&& step = '{$a_step}'");
	$a_status   = db_get("questions", "status", $a_question);
	$a_byip     = db_get("survies", "byip", $a_survey);

	$break      = false;

	if($a_type == 'check') {
		$value = preg_replace('/^,/', '', $value);
		if($a_status && !$value){
			$alert = ["alert" => $lang['survey']['alert']['error'], "type" => "error"];
			$break = true;
		} else {
			$alert = ["alert" => "success!", "type" => "success"];
		}
	} else {
		$value = ( $a_type == "phone" ? ($value['value'] ? "{$value['select']}{$value['value']}" : '') : $value );

		if(($a_status && !$value) || ($a_status && strlen($value) < 13 && $a_type == "phone") ) {
			$alert = ["alert" => $lang['survey']['alert']['error'], "type" => "error"];
			$break = true;
		} else {
			$alert = ["alert" => "success!", "type" => "success"];
		}
	}

	if($break) break;
	else {
		if($a_byip && db_rows("responses WHERE ip = '".get_ip."' && answer = '{$a_id}'")){
		} else if(!isset($_COOKIE["answer_".sc_sec($key)])) {
			if($value){
				setcookie("answer_".sc_sec($key), sc_sec($value), time() + (86400 * 365));
				$query_re = "INSERT INTO ".prefix."responses
									(response, date, author, survey, step, question, answer, cook, ip, os, browser, device) VALUES
									('".sc_sec($value)."', '".time()."', '".us_id."', '{$a_survey}', '{$a_step}', '{$a_question}', '{$a_id}', '{$key}', '".get_ip."', '".get_os."', '".get_browser."', '".get_device."')";
				$db->query($query_re) or die($db->error);
			}
		} else {
		}
	}
}

echo json_encode($alert);
