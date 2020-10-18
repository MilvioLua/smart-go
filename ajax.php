<?php
# -------------------------------------------------#
#¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤#
#	¤                                            ¤   #
#	¤         Puerto Premium Survey 1.0          ¤   #
#	¤--------------------------------------------¤   #
#	¤              By Khalid Puerto              ¤   #
#	¤--------------------------------------------¤   #
#	¤                                            ¤   #
#	¤  Facebook : fb.com/prof.puertokhalid       ¤   #
#	¤  Instagram : instagram.com/khalidpuerto    ¤   #
#	¤  Site : http://www.puertokhalid.com        ¤   #
#	¤  Whatsapp: +212 654 211 360                ¤   #
#	¤                                            ¤   #
#	¤--------------------------------------------¤   #
#	¤                                            ¤   #
#	¤  Last Update: 26/05/2020                   ¤   #
#	¤                                            ¤   #
#¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤#
# -------------------------------------------------#

include __DIR__ . "/configs.php";

if(!isset($_SERVER['HTTP_REFERER'])){
	echo '<meta http-equiv="refresh" content="0;url='.path.'">';
	exit;
}

$alert = [];

if($pg == 'rapport-stats') {
	include __DIR__ . "/ajax/showrapportdetails.php";
} elseif($pg == 'respense') {
	include __DIR__ . "/ajax/showresponsedetails.php";
} elseif($pg == 'send-survey-answers') {
	include __DIR__ . "/ajax/sendsurveyanswers.php";
} elseif($pg == 'sendnewsurvey') {
	include __DIR__ . "/ajax/sendnewsurvey.php";
} elseif($pg == 'login') {
	include __DIR__ . "/ajax/sendsignin.php";
} elseif($pg == 'register') {
	include __DIR__ . "/ajax/sendsignup.php";
} elseif($pg == 'exexcel'){

	$ss = explode('|', sc_sec($request));
	header('Content-Type: application/csv');
	header('Content-disposition: attachment; filename=export_data'.rand().'.csv');
	foreach($ss as $row) {
		echo sc_sec($row)." \n";
	}

} elseif($pg == 'surveystats'){
	if(us_level == 6 || db_rows("survies WHERE id = '{$id}' && author = '".us_id."'")){
		if($request == "daily"){
			$start    = new DateTime('now');
			$end      = new DateTime('- 7 day');
			$diff     = $end->diff($start);
			$interval = DateInterval::createFromDateString('-1 day');
			$period   = new DatePeriod($start, $interval, $diff->days);

			foreach ($period as $date) {
				$aa['data'][] = db_rows("responses WHERE survey = '{$id}' &&  FROM_UNIXTIME(date,'%m-%d-%Y') = '".$date->format('m-d-Y')."' GROUP BY ip");
				$aa['labels'][] = $date->format('M d');
			}

		  $aa['data'] = array_reverse($aa['data']);
		  $aa['labels'] = array_reverse($aa['labels']);
		  $aa['title'] = $lang['rapports']['stats_d'];
		} elseif($request == "monthly"){
			$aa = [];
			for ($i=1; $i <=12 ; $i++) {
				$aa['data'][] = db_rows("responses WHERE survey = '{$id}' &&  MONTH(FROM_UNIXTIME(date)) = '{$i}' GROUP BY ip");
				$aa['labels'][] = date('F', mktime(0, 0, 0, $i, 10));
			}
		  $aa['title'] = $lang['rapports']['stats_d'];
		}

		echo json_encode($aa);
	}
} elseif($pg == 'adminstats'){
	if(us_level == 6){
		if($request == "daily"){
			$start = new DateTime('now');
			$end = new DateTime('- 7 day');
			$diff = $end->diff($start);
			$interval = DateInterval::createFromDateString('-1 day');
			$period = new DatePeriod($start, $interval, $diff->days);

			foreach ($period as $date) {
				$aa['data'][] = db_rows("responses WHERE FROM_UNIXTIME(date,'%m-%d-%Y') = '".$date->format('m-d-Y')."' GROUP BY ip");
				$aa['labels'][] = $date->format('M d');
			}

		  $aa['data'] = array_reverse($aa['data']);
		  $aa['labels'] = array_reverse($aa['labels']);
		  $aa['title'] = "Responses ".$lang['dashboard']['stats_line_d'];
		} elseif($request == "monthly"){
			$aa = [];
			for ($i=1; $i <=12 ; $i++) {
				$aa['data'][] = db_rows("responses WHERE MONTH(FROM_UNIXTIME(date)) = '{$i}' GROUP BY ip");
				$aa['labels'][] = date('F', mktime(0, 0, 0, $i, 10));
			}
		  $aa['title'] = "Responses ".$lang['dashboard']['stats_line_m'];
		}
		echo json_encode($aa);
	}
} elseif($pg == 'adminstatsbars'){
	if(us_level == 6){
		if($request == "daily"){
			$start = new DateTime('now');
			$end = new DateTime('- 7 day');
			$diff = $end->diff($start);
			$interval = DateInterval::createFromDateString('-1 day');
			$period = new DatePeriod($start, $interval, $diff->days);

			foreach ($period as $date) {
				$aa['data'][] = db_rows("survies WHERE FROM_UNIXTIME(date,'%m-%d-%Y') = '".$date->format('m-d-Y')."'");
				$aa['labels'][] = $date->format('M d');
				$colors = randomColor();
				$aa['colors'][] = "#".$colors['hex'];
			}

		  $aa['data'] = array_reverse($aa['data']);
		  $aa['labels'] = array_reverse($aa['labels']);
		  $aa['title'] = "Surveys ".$lang['dashboard']['stats_line_d'];
		} elseif($request == "monthly"){
			$aa = [];
			for ($i=1; $i <=12 ; $i++) {
				$aa['data'][] = db_rows("survies WHERE MONTH(FROM_UNIXTIME(date)) = '{$i}'");
				$aa['labels'][] = date('F', mktime(0, 0, 0, $i, 10));
				$colors = randomColor();
				$aa['colors'][] = "#".$colors['hex'];
			}
		  $aa['title'] = "Surveys ".$lang['dashboard']['stats_line_m'];
		}
		echo json_encode($aa);
	}
} elseif($pg == 'logout'){

	if(us_level){
		session_destroy();
		unset($_COOKIE['login']);
		setcookie('login', null, -1);
	}

} elseif($pg == 'changesurveystatus'){

	if(us_level == 6 || db_rows("survies WHERE id = '{$id}' && author = '".us_id."'")){
		$stat = db_get("survies", "status", $id);
		db_update("survies", ['status' => ($stat ? 0 : 1)], $id);
	}
} elseif($pg == 'changeuserstatus'){

	if(us_level == 6 || db_rows("users WHERE id = '{$id}' && level != '6'")){
		$stat = db_get("users", "moderat", $id);
		db_update("users", ['moderat' => ($stat ? 0 : 1)], $id);
	}

} elseif($pg == 'delete' || $pg == 'trush'){
	if($request != "user"){
		switch ($request) {
			case 'question': $tb = 'questions'; break;
			case 'answer': $tb = 'answers'; break;
			case 'survey':  $tb = 'survies'; break;
			default: $tb = ''; break;
		}
		if((us_level && db_rows("{$tb} WHERE id = '{$id}' && author = '".us_id."'")) || us_level == 6){
			if($pg == 'delete') db_delete("{$tb}", $id);
			elseif($pg == 'trush') db_trush("{$tb}", $id);
		}
	} else {
		if(us_level == 6){
			db_delete("users", $id);
		}
	}
} elseif($pg == 'senduserdetails'){
	include __DIR__ . "/ajax/senduserdetails.php";
} elseif($pg == 'imageupload'){
	if(us_level){
		include __DIR__.'/configs/class.upload.php';
		$imgurl = '';
		$dir_dest = 'uploads';

		$handle = new \Verot\Upload\Upload($_FILES['file']);
		if ($handle->uploaded) {
			$handle->file_safe_name = true;
			$fileNewName = base64_encode($handle->file_src_name_body)."_".time();
			$handle->file_new_name_body = $fileNewName;

			$handle->image_resize          = true;
			$handle->image_ratio_crop      = true;
			$handle->image_y               = 250;
			$handle->image_x               = 250;

		  $handle->process($dir_dest);
		  if ($handle->processed) {
				$imgurl = $dir_dest.'/' . $handle->file_dst_name;
		  } else {

		  }
			$handle->clean();
		}

		echo path."/".$imgurl;
	}

} elseif($pg == 'sendsettings'){

	if($_SERVER['REQUEST_METHOD'] === 'POST' && us_level == 6){

		$pg_title       = sc_sec($_POST['site_title']);
		$pg_description = sc_sec($_POST['site_description']);
		$pg_keywords    = sc_sec($_POST['site_keywords']);
		$pg_url         = sc_sec($_POST['site_url']);

		$site_noreply         = sc_sec($_POST['site_noreply']);
		$site_register        = isset($_POST['site_register']) ? (int)($_POST['site_register']) : 0;
		$login_facebook       = isset($_POST['login_facebook']) ? (int)($_POST['login_facebook']) : 0;
		$login_twitter        = isset($_POST['login_twitter']) ? (int)($_POST['login_twitter']) : 0;
		$login_google         = isset($_POST['login_google']) ? (int)($_POST['login_google']) : 0;
		$site_paypal_live     = isset($_POST['site_paypal_live']) ? (int)($_POST['site_paypal_live']) : 0;
		$site_smtp            = isset($_POST['site_smtp']) ? 1 : 0;
		$login_fbAppId        = sc_sec($_POST['login_fbAppId']);
		$login_fbAppSecret    = sc_sec($_POST['login_fbAppSecret']);
		$login_fbAppVersion   = sc_sec($_POST['login_fbAppVersion']);
		$login_twConKey       = sc_sec($_POST['login_twConKey']);
		$login_twConSecret    = sc_sec($_POST['login_twConSecret']);
		$login_ggClientId     = sc_sec($_POST['login_ggClientId']);
		$login_ggClientSecret = sc_sec($_POST['login_ggClientSecret']);
		$site_paypal_id       = sc_sec($_POST['site_paypal_id']);
		$site_currency_name   = sc_sec($_POST['site_currency_name']);
		$site_currency_symbol = sc_sec($_POST['site_currency_symbol']);
		$site_smtp_host       = sc_sec($_POST['site_smtp_host']);
		$site_smtp_username   = sc_sec($_POST['site_smtp_username']);
		$site_smtp_password   = sc_sec($_POST['site_smtp_password']);
		$site_smtp_encryption = sc_sec($_POST['site_smtp_encryption']);
		$site_smtp_auth = sc_sec($_POST['site_smtp_auth']);
		$site_smtp_port = sc_sec($_POST['site_smtp_port']);

		if(empty($pg_title) || empty($pg_description)){
			$alert = [
				'type'  =>'danger',
				'alert' => fh_alerts($lang['alerts']['required'])
			];
		} else {
			db_update_global('site_title', $pg_title);
			db_update_global('site_description', $pg_description);
			db_update_global('site_keywords', $pg_keywords);
			db_update_global('site_url', $pg_url);

			db_update_global('site_noreply', $site_noreply);
			db_update_global('site_register', $site_register);
			db_update_global('login_facebook', $login_facebook);
			db_update_global('login_twitter', $login_twitter);
			db_update_global('login_google', $login_google);
			db_update_global('site_paypal_live', $site_paypal_live);
			db_update_global('site_smtp', $site_smtp);
			db_update_global('login_fbAppId', $login_fbAppId);
			db_update_global('login_fbAppSecret', $login_fbAppSecret);
			db_update_global('login_fbAppVersion', $login_fbAppVersion);
			db_update_global('login_twConKey', $login_twConKey);
			db_update_global('login_twConSecret', $login_twConSecret);
			db_update_global('login_ggClientId', $login_ggClientId);
			db_update_global('login_ggClientSecret', $login_ggClientSecret);
			db_update_global('site_paypal_id', $site_paypal_id);
			db_update_global('site_currency_name', $site_currency_name);
			db_update_global('site_currency_symbol', $site_currency_symbol);
			db_update_global('site_smtp_host', $site_smtp_host);
			db_update_global('site_smtp_username', $site_smtp_username);
			db_update_global('site_smtp_password', $site_smtp_password);
			db_update_global('site_smtp_encryption', $site_smtp_encryption);
			db_update_global('site_smtp_auth', $site_smtp_auth);
			db_update_global('site_smtp_port', $site_smtp_port);

			$alert = [
				'type'  =>'success',
				'alert' => fh_alerts($lang['dashboard']['alert']['success'], 'success')
			];
		}
		echo json_encode($alert);
	}
} elseif($pg == 'lang'){

	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$id = isset($_POST['id']) ? sc_sec($_POST['id']):'en';
		setcookie( "lang" , $id, time()+3600*24*30*6 );
	}

}


elseif($pg == 'sendplans'){

	if($_SERVER['REQUEST_METHOD'] === 'POST' && us_level == 6){

		$site_plans = isset($_POST['site_plans']) ? 1 : 0;

		for($x=1; $x<=4;$x++){
			$sql = $db->query("DESCRIBE ".prefix."plans");
			while($row = $sql->fetch_array()){
				if($row['Field'] != 'id'){
					if($row['Type'] == "tinyint(1)"){
						$vv = isset($_POST[$row['Field']][$x]) ? 1 : 0;
					}
					elseif($row['Type'] == "int(11)"){
						$vv = isset($_POST[$row['Field']][$x]) ? (int)($_POST[$row['Field']][$x]) : 0;
					}
					else{
						$vv = isset($_POST[$row['Field']][$x]) ? sc_sec($_POST[$row['Field']][$x]) : '';
					}
					db_update("plans", ["{$row['Field']}" => $vv], $x);
				}
			}
		}

		db_update_global('site_plans', $site_plans);

		$alert = [
			'type'  =>'success',
			'alert' => fh_alerts($lang['dashboard']['alert']['success'], 'success')
		];

		echo json_encode($alert);
	}

}

elseif($pg == "sendsurveyemail"){
	if($_SERVER['REQUEST_METHOD'] === 'POST'){

		$pg_subject = sc_sec($_POST['subject']);
		$pg_email   = $_POST['email'];
		$pg_message = sc_sec($_POST['message']);
		$pg_id      = isset($_POST['id']) ? (int)($_POST['id']) : 0;

		if(empty($pg_subject) || empty($pg_email) || empty($pg_message)){
			$alert = [
				'type'  =>'danger',
				'alert' => fh_alerts($lang['alerts']['required'])
			];
		} else {
			$e_title = db_get("survies", "title", $pg_id);

			$emails = $pg_email;
			foreach ($emails as $em) {
				$pg_username = db_get("users", "username", sc_sec($em), "email");
				$e_url = path."/survey.php?id={$pg_id}&request=su&token=".base64_encode(sc_sec($em));
				$mail->addAddress(sc_sec($em), "{$pg_username}");
				$mail->isHTML(true);
				$mail->Subject = $pg_subject;
				$mail->Body    = fh_email_p(fh_bbcode($pg_message), $e_url, ['', '', $e_title]);
				if( $mail->send() ){
					$alert = [
						'type'  =>'success',
						'alert' => fh_alerts("Send succesfully.", 'success')
					];
				} else {
					$alert = [
						'type'  =>'danger',
						'alert' => fh_alerts($lang['alerts']['wrong'])
					];
				}
			}

		}
		echo json_encode($alert);
	}

}
