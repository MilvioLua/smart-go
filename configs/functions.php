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

function db_rows($table, $field = 'id'){
	global $db;
	$sql = $db->query("SELECT {$field} FROM ".prefix."{$table}") or die($db->error);
	$rs  = $sql->num_rows;
	$sql->close();
	return $rs;
}

function db_get($table, $field, $id, $where='id', $other=false){
	global $db;
	$sql = $db->query("SELECT {$field} FROM ".prefix."{$table} WHERE {$where} = '{$id}' {$other}") or die($db->error);
	if($sql->num_rows > 0){
		$rs = $sql->fetch_row();
		$sql->close();
		return $rs[0];
	}
}

function db_insert($table, $array) {
	global $db;
	$columns = implode(',', array_keys($array));
	$values  = "'" . implode("','", array_values($array)) . "'";;
	$query   = "INSERT INTO ".prefix."{$table} ({$columns}) VALUES ({$values})";
	return $db->query($query) or die($db->error);
}

function db_update($table, $array, $id, $id_col = 'id', $other = '') {
	global $db;
	$columns = array_keys($array);
	$values  = array_values($array);
	$count   = count($columns);

	$update  = '';
	for($i=0;$i<$count;$i++)
		$update .= "{$columns[$i]} = '{$values[$i]}'" . ($count == $i+1 ? '' : ', ');

	$query   = "UPDATE ".prefix."{$table} SET {$update} WHERE {$id_col} = '{$id}' {$other}";
	return $db->query($query) or die($db->error);
}

function db_delete($table, $id, $id_col = 'id', $more = '') {
	global $db;
	$query = "DELETE FROM ".prefix."{$table} WHERE {$id_col} = '{$id}' {$more}";
	return $db->query($query) or die($db->error);
}

function db_global(){
	global $db;
	$sql = $db->query("SELECT * FROM ".prefix."configs") or die($db->error);
	if($sql){
		while( $rs = $sql->fetch_assoc() )
			define( $rs['variable'], $rs['value'] );

		$sql->close();
	}
}

function db_update_global($var, $val){
	return db_update("configs", ['value' => "{$val}"], $var, 'variable');
}

function db_login_details(){
	global $db;
	$log_session = ( isset($_SESSION['login']) ? (int)$_SESSION['login'] : ( isset($_COOKIE['login']) ? (int)$_COOKIE['login'] : 0 ) );

  if( isset($log_session) && $log_session != 0 ){
   $sql = $db->query( "SELECT * FROM ".prefix."users WHERE id = '{$log_session}'" ) or die($db->error);
   $rs  = $sql->fetch_assoc();
   foreach ( $rs as $key => $val )
         define( 'us_'. $key, $val);

   $sql->close();
  } else {
		$sql = $db->query( "DESCRIBE ".prefix."users" ) or die($db->error);
		while( $rs = $sql->fetch_assoc() ){
			define( 'us_' . $rs['Field'], (in_array(str_replace(' unsigned', '', $rs['Type']), ['tinyint(1)','int(11)','int(10)']) ? 0 : ''));
		}

		$sql->close();
  }
}

function sc_check_email($email){
	$address = strtolower(trim($email));
	return (preg_match("/^[a-zA-Z0-9_.-]{1,40}+@([a-zA-Z0-9_-]){2,30}+\.([a-zA-Z0-9]){2,20}$/i",$address));
}

function sc_pass($data) {
	return sha1($data);
}

function strip_tags_content($text, $tags = '', $invert = FALSE){
    preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
    $tags = array_unique($tags[1]);

    if(is_array($tags) AND count($tags) > 0) {
        if($invert == FALSE) {
            return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
        } else {
            return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
        }
    } elseif($invert == FALSE) {
        return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
    }
    return $text;
}


function sc_sec($data, $html = false) {
	global $db;
	$post = $db->real_escape_string($data);
	$post = trim($post);
	$post = ($html) ? htmlspecialchars($post) : htmlspecialchars(strip_tags_content($post));
	return $post;
}

function fh_title(){
	global $id;
	$title = '';
	switch (page) {
		case 'survey': $title = db_get("survies", "title", $id).' - '.site_title; break;
		case 'plans': $title = 'Plans - '.site_title; break;
		case 'dashboard': $title = 'Dashboard - '.site_title; break;
		case 'rapport': $title = 'Rapport - '.site_title; break;
		case 'responses': $title = 'Responses - '.site_title; break;
		case 'newsurvey': $title = 'New Survey - '.site_title; break;
		case 'userdetails': $title = 'Details - '.site_title; break;

		default: $title = site_title; break;
	}
	return $title;
}

function fh_access($type) {
	global $db;
	$access = true;
	if(us_level == 6) $access = true;
	else {
		if($type == "survey" && db_rows("survies WHERE author = '".us_id."'") >= surveys_month ) $access = false;
		elseif($type == "design" && !survey_design ) $access = false;
		elseif($type == "rapport" && !surveys_rapport ) $access = false;
		elseif($type == "export" && !surveys_export ) $access = false;
		elseif($type == "iframe" && !surveys_iframe ) $access = false;
	}
	return $access;
}

if (! function_exists('array_column')) {
  function array_column(array $input, $columnKey, $indexKey = null) {
    $array = array();
    foreach ($input as $value) {
      if ( !array_key_exists($columnKey, $value)) {
        trigger_error("Key \"$columnKey\" does not exist in array");
        return false;
      }
      if (is_null($indexKey)) {
        $array[] = $value[$columnKey];
      }
      else {
        if ( !array_key_exists($indexKey, $value)) {
          trigger_error("Key \"$indexKey\" does not exist in array");
          return false;
        }
        if ( ! is_scalar($value[$indexKey])) {
          trigger_error("Key \"$indexKey\" does not contain scalar value");
          return false;
        }
        $array[$value[$indexKey]] = $value[$columnKey];
      }
    }
    return $array;
  }
}

function fh_email_p($text, $link = '#', $rep = ''){
	$wrapper = '
		width: 480px;
		margin: 12px auto;
		color: #666;
		font-size: 16px;
		border: 1px solid #EEE;
		padding: 24px;
		border-radius: 3px;
	';
	$button = '
		display: block;
		background: #f43438;
		color: #fff;
		height: 48px;
		line-height: 48px;
		padding: 0 24px;
		font-size: 18px;
		border-radius: 3px;
		text-align: center;
		text-decoration: none;
	';
	$text = '<div style="'.$wrapper.'">'.$text.'</div>';
	$match = [
		'/\{button\}/',
		'/\{button bg=\#([A-Za-z0-9]+)\}/',
		'/\{\/button\}/',
	];
	$replace = [
		'<a href="'.$link.'" style="'.$button.'">',
		'<a href="'.$link.'" style="'.$button.'background:#$1">',
		'</a>',
	];

	$pr_r = preg_replace($match, $replace, $text);
	$pr_r = str_replace('\r\n', '<br>', $pr_r);

	if(!$rep)
		return $pr_r;
	else
		return preg_replace(['/\{name\}/', '/\{email\}/', '/\{title\}/'], $rep, $pr_r);
}

function fh_user($id, $link = true, $cut = false, $count = 25){
	global $db;
	if(!$id){
		return false;
	}
  $sql = $db->query("SELECT id, username, plan FROM ".prefix."users WHERE id = '{$id}'");
  $rs = $sql->fetch_assoc();
	$color = ( $rs['plan']==1 ? '#00cec9' : ( $rs['plan']==2 ? '#ff7675' : ( $rs['plan']==3 ? '#6c5ce7' : '')));
	$username = $rs['username'];
	return ($link) ? '<a href="#"'.($color?' style="color:'.$color.'"':'').'>'.$username.'</a>' : $username;
}

function fh_alerts($alert, $type = 'danger', $redirect = false, $html = true) {
	global $lang;

	$title = $lang['alerts'][$type];
  return ($html) ? '<div class="alert alert-'.$type.'">
            <strong>'.$title.'</strong> '.$alert.'
          </div>'. ($redirect ? '<meta http-equiv="refresh" content="1;url='.$redirect.'">' : false) : '<strong>'.$title.'</strong> '.$alert;
}

function randomColor(){
  $result = array('rgb' => '', 'hex' => '');
  foreach(array('r', 'b', 'g') as $col){
    $rand = mt_rand(0, 255);
    $dechex = dechex($rand);
    if(strlen($dechex) < 2){
      $dechex = '0' . $dechex;
    }
    $result['hex'] .= $dechex;
  }
  return $result;
}

function fh_ip(){
  foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
    if (array_key_exists($key, $_SERVER) === true){
    	foreach (explode(',', $_SERVER[$key]) as $ip){
        $ip = trim($ip); // just to be safe

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
          return $ip;
        }
      }
    }
  }
}

function fh_get_num($str) {
  preg_match_all('/\d+/', $str, $matches);
  return $matches[0];
}

function fh_social_login( $socialname, $profile ){
	global $lang, $db;

	switch($socialname){
		case 'facebook':
			$socialid  = $profile['id'];
			$username  = $profile['name'];
			$firstname = $profile['first_name'];
			$lastname  = $profile['last_name'];
			$email     = $profile['email'];
			$photo     = $profile['picture']['url'];
			$description  = '';
		break;
		case 'google':
			$socialid  = $profile['id'];
			$username  = $profile['name'];
			$firstname = $profile['given_name'];
			$lastname  = $profile['family_name'];
			$email     = $profile['email'];
			$photo     = $profile['picture'];
			$description  = '';
		break;
		case 'twitter':
			$socialid  = $profile->id;
			$username  = $profile->name;
			$firstname = '';
			$lastname  = '';
			$email     = 'no email address';
			$photo     = $profile->profile_image_url;
			$description  = $profile->description;
		break;
	}


	if(db_rows("users WHERE username = '{$username}' || email = '{$email}'")){
		$sql = $db->query("SELECT id, moderat FROM ".prefix."users WHERE (username = '{$username}' || email = '{$email}') && social_name = '{$socialname}' && social_id = '{$socialid}'");
		if($sql->num_rows){
			$rs = $sql->fetch_assoc();
			$_SESSION['login']  = $rs['id'];
			db_update('users', ["photo"=> $photo], $rs['id']);
			echo "<div class='padding'>".fh_alerts($lang['login']['alert']['success'], "success", path."/index.php")."</div>";
		} else {
			echo "<div class='padding'>".fh_alerts($lang['login']['alert']['social'], "danger", path."/index.php")."</div>";
		}
	} else {
		db_insert('users', [
			"username"    => $username,
			"firstname"   => $firstname,
			"lastname"    => $lastname,
			"email"       => $email,
			"social_id"   => $socialid,
			"social_name" => $socialname,
			"photo"       => $photo,
			"date"        => time(),
			"level"       => 1
		]);
		$_SESSION['login']  = db_get('users', 'id', $username, 'username', "&& social_name = '{$socialname}' && social_id = '{$socialid}'");
		echo "<div class='padding'>".fh_alerts($lang['login']['alert']['success'], "success", path."/index.php")."</div>";
	}
}

function fh_go($href = '',$tm = 0){
	echo '<meta http-equiv="refresh" content="'.$tm.'; URL='.$href.'">';
}


function fh_ago($tm = '', $at = true, $rcs = 0) {
	global $lang;
	$cur_tm = time();
	$pr_year = $cur_tm - 3600*24*365;
	$pr_month = $cur_tm - 3600*24*31;
	if( $tm > $pr_month ){
		$dif    = $cur_tm-$tm;
		$pds = array();
		foreach ($lang['timedate'] as $kk){
			$pds[] = $kk;
			if( $kk == 'decade' ) break;
		}

		$lngh   = array(1,60,3600,86400,604800,2630880,31570560,315705600);
		for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);

		$no = floor($no); if($no <> 1 && !$lang['rtl']) $pds[$v] .=($lang['lang'] == 'en' ? 's': ''); $x=sprintf("%d %s ",$no,$pds[$v]);
		if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm);
		if($lang['rtl']) return " {$lang['timedate']['time_ago']} {$x}";
		else return "{$x} {$lang['timedate']['time_ago']}";
	} else {
    if($lang['lang'] == 'en'){
        return ($at?date('d M, Y \a\t H:i', $tm):date('d M, Y', $tm));
    } else {
        return ($at?date('d M, Y \a\t H:i', $tm):date('d M, Y', $tm));
    }
	}
}

function fh_bbcode($text){
	$match = [
		'/\[B\]/isU',
		'/\[\/B\]/isU',
		'/\[I\]/isU',
		'/\[\/I\]/isU',
		'/\[S\]/isU',
		'/\[\/S\]/isU',
		'/\[U\]/isU',
		'/\[\/U\]/isU',

		'/\[IMG width=(.*) height=(.*)\](.*)\[\/IMG\]/isU',
		'/\[IMG\](.*)\[\/IMG\]/isU',
		'/\[URL=(.+)\]/isU',
		'/\[\/URL\]/isU',

		'/\[COLOR=(.*)\]/isU',
		'/\[\/COLOR\]/isU',
		'/\[SIZE=1\]/isU',
		'/\[SIZE=2\]/isU',
		'/\[SIZE=3\]/isU',
		'/\[SIZE=4\]/isU',
		'/\[SIZE=5\]/isU',
		'/\[SIZE=6\]/isU',
		'/\[SIZE=7\]/isU',
		'/\[\/SIZE\]/isU',

		'/\[LEFT\](.*)\[\/LEFT\]/isU',
		'/\[RIGHT\](.*)\[\/RIGHT\]/isU',
		'/\[CENTER\]/isU',
		'/\[\/CENTER\]/isU',
		'/\[quote\](.*)\[\/quote\]/isU',
		'/\[CODE\](.*)\[\/CODE\]/isU',

		'/\[video\](.*)\[\/video\]/isU',
		'/\[youtube\](.*)\[\/youtube\]/isU',

		'/\[list=1\](.*)\[\/list\]/isU',
		'/\[ul\](.*)\[\/ul\]/isU',
		'/\[ol\](.*)\[\/ol\]/isU',
		'/\[\*\](.*)\[\/\*\]/isU',
		'/\[li\](.*)\[\/li\]/isU',

		'/\[\TR\]/isU',
		'/\[\/\TR\]/isU',
		'/\[\TD\]/isU',
		'/\[\/\TD\]/isU',
		'/\[\TABLE\]/isU',
		'/\[\/\TABLE\]/isU',

		'/\[HR\]/isU',
	];

	$replace = [
		'<b>',
		'</b>',
		'<i>',
		'</i>',
		'<strike>',
		'</strike>',
		'<u>',
		'</u>',

		'<img src="$3" style="width:$1px;height:$2px;" />',
		'<img src="$1" />',
		'<a href="$1">',
		'</a>',

		'<span style="color:$1">',
		'</span>',
		'<span style="font-size:8px">',
		'<span style="font-size:12px">',
		'<span style="font-size:14px">',
		'<span style="font-size:16px">',
		'<span style="font-size:18px">',
		'<span style="font-size:20px">',
		'<span style="font-size:22px">',
		'</span>',

		'<p class="text-left">$1</p>',
		'<p class="text-right">$1</p>',
		'<p class="text-center">',
		'</p>',
		'<blockquote>$1</blockquote>',
		'<pre>$1</pre>',

		'<iframe src="https://www.youtube.com/embed/$1" width="560" height="420" frameborder="0"></iframe>',
		'<iframe src="https://www.youtube.com/embed/$1" width="560" height="420" frameborder="0"></iframe>',

		'<ul class="decimal">$1</ul>',
		'<ul class="circle">$1</ul>',
		'<ol class="decimal">$1</ol>',
		'<li>$1</li>',
		'<li>$1</li>',
		'<tr>',
		'</tr>',
		'<td>',
		'</td>',
		'<table>',
		'</table>',

		'<hr/>',
	];


	$regex = '/\[font=.*?\]|\[\/font\]/i';
	$text = preg_replace($regex, '', $text);

	return nl2br(preg_replace($match, $replace, $text));
}


function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
  $output = NULL;
  if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
    $ip = $_SERVER["REMOTE_ADDR"];
    if ($deep_detect) {
      if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
      if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
  }
  $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
  $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
  $continents = array(
    "AF" => "Africa",
    "AN" => "Antarctica",
    "AS" => "Asia",
    "EU" => "Europe",
    "OC" => "Australia (Oceania)",
    "NA" => "North America",
    "SA" => "South America"
  );
  if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
    $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
    if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
      switch ($purpose) {
        case "location":
          $output = array(
              "city"           => @$ipdat->geoplugin_city,
              "state"          => @$ipdat->geoplugin_regionName,
              "country"        => @$ipdat->geoplugin_countryName,
              "country_code"   => @$ipdat->geoplugin_countryCode,
              "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
              "continent_code" => @$ipdat->geoplugin_continentCode
          );
          break;
        case "address":
          $address = array($ipdat->geoplugin_countryName);
          if (@strlen($ipdat->geoplugin_regionName) >= 1)
              $address[] = $ipdat->geoplugin_regionName;
          if (@strlen($ipdat->geoplugin_city) >= 1)
              $address[] = $ipdat->geoplugin_city;
          $output = implode(", ", array_reverse($address));
          break;
        case "city":
          $output = @$ipdat->geoplugin_city;
          break;
        case "state":
          $output = @$ipdat->geoplugin_regionName;
          break;
        case "region":
          $output = @$ipdat->geoplugin_regionName;
          break;
        case "country":
          $output = @$ipdat->geoplugin_countryName;
          break;
        case "countrycode":
          $output = @$ipdat->geoplugin_countryCode;
          break;
      }
    }
  }
  return $output;
}



function fh_get_answer($rs, $rs_s) {
	global $countries, $phones, $a, $_COOKIE;

	$html = '';
	if(in_array($rs['type'], ['checkbox', 'radio'])){
		$co   = "answer_s{$rs['survey']}st{$rs['step']}q{$rs['question']}";
		$cook = isset($_COOKIE[$co]) ? sc_sec($_COOKIE[$co]) : '';
		$rr   = explode(',', $cook);
		$rr_a = array_combine(range(1, count($rr)), $rr);
	} else {
		$co   = "answer_s{$rs['survey']}a{$rs['id']}";
		$cook = isset($_COOKIE[$co]) ? sc_sec($_COOKIE[$co]) : '';
	}

	switch ($rs['type']) {
		case 'input':
			$html = ( $rs_s['inline'] ? '<div class="col">' : '') .'
				<div class="pt-survey-answers">
					<div'. ($rs['icon'] ? ' class="pt-form-i"' : '') .'>
						'. ($rs['icon'] ? '<span class="pt-icon"><i class="'.$rs['icon'].'"></i></span>' : '') .'
						<input type="text" name="answer[s'.$rs['survey'].'a'.$rs['id'].']" value="'.$cook.'" placeholder="'.$rs['title'].'">
					</div>
				</div>
			'. ( $rs_s['inline'] ? '</div>' : '') ;
		break;
		case 'email':
			$html = ( $rs_s['inline'] ? '<div class="col">' : '') .'
				<div class="pt-survey-answers">
					<div'. ($rs['icon'] ? ' class="pt-form-i"' : '') .'>
						'. ($rs['icon'] ? '<span class="pt-icon"><i class="'.$rs['icon'].'"></i></span>' : '') .'
						<input type="email" name="answer[s'.$rs['survey'].'a'.$rs['id'].']" value="'.$cook.'" placeholder="'.$rs['title'].'">
					</div>
				</div>
			'. ( $rs_s['inline'] ? '</div>' : '') ;
		break;
		case 'textarea':
			$html = '
				<div class="pt-survey-answers">
					<div'. ($rs['icon'] ? ' class="pt-form-i"' : '') .'>
						'. ($rs['icon'] ? '<span class="pt-icon"><i class="'.$rs['icon'].'"></i></span>' : '') .'
						<textarea name="answer[s'.$rs['survey'].'a'.$rs['id'].']" placeholder="'.$rs['title'].'">'.$cook.'</textarea>
					</div>
				</div>
			';
		break;
		case 'date':
			$html = '
				<div class="pt-survey-answers">
					<div'. ($rs['icon'] ? ' class="pt-form-i"' : '') .'>
						'. ($rs['icon'] ? '<span class="pt-icon"><i class="'.$rs['icon'].'"></i></span>' : '') .'
						<input type="text" name="answer[s'.$rs['survey'].'a'.$rs['id'].']" value="'.$cook.'" class="datepicker-here" placeholder="'.$rs['title'].'">
					</div>
				</div>
			';
		break;
		case 'phone':
			$html = '
				<div class="pt-survey-answers">
					<div class="pt-form-i pt-form-phone">
						<span class="pt-icon"><i class="fas fa-phone-alt"></i></span>
						<select class="selectpicker" name="answer[s'.$rs['survey'].'a'.$rs['id'].'][select]" data-live-search="true">';
							foreach ($phones as $key => $value):
								$html .= '<option value="'.$key.'" data-icon="flag-icon flag-icon-'.strtolower($key).'" data-tokens="'.$key.' '.$value['code'].' '.$value['name'].'"'.( $cook ? (preg_match("/{$key}/i", $cook)?' selected':'') : ($key==c_code?' selected':'') ).'>(+'.$value['code'].')</option>';
							endforeach;
						$html .= '</select>
						<input type="phone" name="answer[s'.$rs['survey'].'a'.$rs['id'].'][value]" value="'.preg_replace('/([A-Z])/', '', $cook).'" placeholder="'.$rs['title'].'">
					</div>
				</div>
			';
		break;
		case 'country':
			$ccode = ($cook ? $cook : c_code);
			$html = ( $rs_s['inline'] ? '<div class="col">' : '') . '
				<div class="pt-survey-answers">
					<div class="pt-form-i pt-countries">
						<span class="pt-icon"><i class="flag-icon flag-icon-'.strtolower($ccode).'"></i></span>
						<select class="selectpicker" name="answer[s'.$rs['survey'].'a'.$rs['id'].']" data-live-search="true">';
							foreach ($countries as $key => $value):
								$html .= '<option value="'.$key.'" data-tokens="'.$key.' '.$value.'"'.($key==$ccode?' selected':'').'>'.$value.'</option>';
							endforeach;
						$html .= '</select>
					</div>
				</div>
			'. ( $rs_s['inline'] ? '</div>' : '') ;
		break;
		case 'checkbox':
			$chkd = (in_array($rs['id'], $rr_a)?' checked':'');
			$html = '
				<div class="form-group">
					'. ($a==1 ? '<input type="hidden" name="answer[s'.$rs['survey'].'st'.$rs['step'].'q'.$rs['question'].']" value="'.$cook.'">' : '' ) .'
					<input type="checkbox" name="answers[q'.$rs['question'].']" rel="answer[s'.$rs['survey'].'st'.$rs['step'].'q'.$rs['question'].']" value="s'.$rs['survey'].'a'.$rs['id'].'" id="a'.$rs['id'].'" class="choice"'.$chkd.'>
					<label for="a'.$rs['id'].'">'.$rs['title'].'</label>
				</div>
			';
		break;
		case 'radio':
			$chkd = (in_array($rs['id'], $rr_a)?' checked':'');
			$html = '
				<div class="form-group">
				'. ($a==1 ? '<input type="hidden" name="answer[s'.$rs['survey'].'st'.$rs['step'].'q'.$rs['question'].']" value="'.$cook.'">' : '' ) .'
					<input type="radio" name="answers[q'.$rs['question'].']" rel="answer[s'.$rs['survey'].'st'.$rs['step'].'q'.$rs['question'].']" value="s'.$rs['survey'].'a'.$rs['id'].'" id="a'.$rs['id'].'" class="choice"'.$chkd.'>
					<label for="a'.$rs['id'].'">'.$rs['title'].'</label>
				</div>
			';
		break;
		case 'stars':
			$html = '
				<div class="pt-survey-answers">
					'.rating_inp('answer[s'.$rs['survey'].'a'.$rs['id'].']', $cook).'
				</div>
			';
		break;

		default:
			$html = '';
		break;
	}

	return $html;
}

function fh_get_answer_start($rs_a, $rs_s){
	$html = '';
	if(in_array($rs_a['type'], ['checkbox', 'radio'])){
		$html = '<div class="pt-survey-answers '. ($rs_s['inline'] ? 'inline-answer"><div class="form-inline' : 'pt-choice-tc' ) .'">';
	} elseif($rs_a['type'] == 'input' || $rs_a['type'] == 'country'){
		$html = ($rs_s['inline'] ? '<div class="row">' : '' );
	}
	return $html;
}

function fh_get_answer_end($rs_a, $rs_s){
	$html = '';
	if(in_array($rs_a['type'], ['checkbox', 'radio'])){
		$html = '</div>'. ($rs_s['inline'] ? '</div>' : '' );
	} elseif($rs_a['type'] == 'input' || $rs_a['type'] == 'country'){
		$html = ($rs_s['inline'] ? '</div>' : '' );
	}
	return $html;
}


function rating_inp($name, $vl){
	return '<div class="rating">
		<input type="hidden" name="'.$name.'" value="'.$vl.'">
		<input type="radio"'.($vl==5?' checked':'').' rel="'.$name.'" value="5" id="rating-5">
		<label for="rating-5"></label>
		<input type="radio"'.($vl==4?' checked':'').' rel="'.$name.'" value="4" id="rating-4">
		<label for="rating-4"></label>
		<input type="radio"'.($vl==3?' checked':'').' rel="'.$name.'" value="3" id="rating-3">
		<label for="rating-3"></label>
		<input type="radio"'.($vl==2?' checked':'').' rel="'.$name.'" value="2" id="rating-2">
		<label for="rating-2"></label>
		<input type="radio"'.($vl==1?' checked':'').' rel="'.$name.'" value="1" id="rating-1">
		<label for="rating-1"></label>
		<div class="emoji-wrapper"><div class="emoji"><svg class="rating-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><circle cx="256" cy="256" r="256" fill="#ffd93b"/><path d="M512 256c0 141.44-114.64 256-256 256-80.48 0-152.32-37.12-199.28-95.28 43.92 35.52 99.84 56.72 160.72 56.72 141.36 0 256-114.56 256-256 0-60.88-21.2-116.8-56.72-160.72C474.8 103.68 512 175.52 512 256z" fill="#f4c534"/><ellipse transform="scale(-1) rotate(31.21 715.433 -595.455)" cx="166.318" cy="199.829" rx="56.146" ry="56.13" fill="#fff"/><ellipse transform="rotate(-148.804 180.87 175.82)" cx="180.871" cy="175.822" rx="28.048" ry="28.08" fill="#3e4347"/><ellipse transform="rotate(-113.778 194.434 165.995)" cx="194.433" cy="165.993" rx="8.016" ry="5.296" fill="#5a5f63"/><ellipse transform="scale(-1) rotate(31.21 715.397 -1237.664)" cx="345.695" cy="199.819" rx="56.146" ry="56.13" fill="#fff"/><ellipse transform="rotate(-148.804 360.25 175.837)" cx="360.252" cy="175.84" rx="28.048" ry="28.08" fill="#3e4347"/><ellipse transform="scale(-1) rotate(66.227 254.508 -573.138)" cx="373.794" cy="165.987" rx="8.016" ry="5.296" fill="#5a5f63"/><path d="M370.56 344.4c0 7.696-6.224 13.92-13.92 13.92H155.36c-7.616 0-13.92-6.224-13.92-13.92s6.304-13.92 13.92-13.92h201.296c7.696.016 13.904 6.224 13.904 13.92z" fill="#3e4347"/></svg><svg class="rating-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><circle cx="256" cy="256" r="256" fill="#ffd93b"/><path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/><path d="M328.4 428a92.8 92.8 0 0 0-145-.1 6.8 6.8 0 0 1-12-5.8 86.6 86.6 0 0 1 84.5-69 86.6 86.6 0 0 1 84.7 69.8c1.3 6.9-7.7 10.6-12.2 5.1z" fill="#3e4347"/><path d="M269.2 222.3c5.3 62.8 52 113.9 104.8 113.9 52.3 0 90.8-51.1 85.6-113.9-2-25-10.8-47.9-23.7-66.7-4.1-6.1-12.2-8-18.5-4.2a111.8 111.8 0 0 1-60.1 16.2c-22.8 0-42.1-5.6-57.8-14.8-6.8-4-15.4-1.5-18.9 5.4-9 18.2-13.2 40.3-11.4 64.1z" fill="#f4c534"/><path d="M357 189.5c25.8 0 47-7.1 63.7-18.7 10 14.6 17 32.1 18.7 51.6 4 49.6-26.1 89.7-67.5 89.7-41.6 0-78.4-40.1-82.5-89.7A95 95 0 0 1 298 174c16 9.7 35.6 15.5 59 15.5z" fill="#fff"/><path d="M396.2 246.1a38.5 38.5 0 0 1-38.7 38.6 38.5 38.5 0 0 1-38.6-38.6 38.6 38.6 0 1 1 77.3 0z" fill="#3e4347"/><path d="M380.4 241.1c-3.2 3.2-9.9 1.7-14.9-3.2-4.8-4.8-6.2-11.5-3-14.7 3.3-3.4 10-2 14.9 2.9 4.9 5 6.4 11.7 3 15z" fill="#fff"/><path d="M242.8 222.3c-5.3 62.8-52 113.9-104.8 113.9-52.3 0-90.8-51.1-85.6-113.9 2-25 10.8-47.9 23.7-66.7 4.1-6.1 12.2-8 18.5-4.2 16.2 10.1 36.2 16.2 60.1 16.2 22.8 0 42.1-5.6 57.8-14.8 6.8-4 15.4-1.5 18.9 5.4 9 18.2 13.2 40.3 11.4 64.1z" fill="#f4c534"/><path d="M155 189.5c-25.8 0-47-7.1-63.7-18.7-10 14.6-17 32.1-18.7 51.6-4 49.6 26.1 89.7 67.5 89.7 41.6 0 78.4-40.1 82.5-89.7A95 95 0 0 0 214 174c-16 9.7-35.6 15.5-59 15.5z" fill="#fff"/><path d="M115.8 246.1a38.5 38.5 0 0 0 38.7 38.6 38.5 38.5 0 0 0 38.6-38.6 38.6 38.6 0 1 0-77.3 0z" fill="#3e4347"/><path d="M131.6 241.1c3.2 3.2 9.9 1.7 14.9-3.2 4.8-4.8 6.2-11.5 3-14.7-3.3-3.4-10-2-14.9 2.9-4.9 5-6.4 11.7-3 15z" fill="#fff"/></svg><svg class="rating-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><circle cx="256" cy="256" r="256" fill="#ffd93b"/><path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/><path d="M336.6 403.2c-6.5 8-16 10-25.5 5.2a117.6 117.6 0 0 0-110.2 0c-9.4 4.9-19 3.3-25.6-4.6-6.5-7.7-4.7-21.1 8.4-28 45.1-24 99.5-24 144.6 0 13 7 14.8 19.7 8.3 27.4z" fill="#3e4347"/><path d="M276.6 244.3a79.3 79.3 0 1 1 158.8 0 79.5 79.5 0 1 1-158.8 0z" fill="#fff"/><circle cx="340" cy="260.4" r="36.2" fill="#3e4347"/><g fill="#fff"><ellipse transform="rotate(-135 326.4 246.6)" cx="326.4" cy="246.6" rx="6.5" ry="10"/><path d="M231.9 244.3a79.3 79.3 0 1 0-158.8 0 79.5 79.5 0 1 0 158.8 0z"/></g><circle cx="168.5" cy="260.4" r="36.2" fill="#3e4347"/><ellipse transform="rotate(-135 182.1 246.7)" cx="182.1" cy="246.7" rx="10" ry="6.5" fill="#fff"/></svg><svg class="rating-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><circle cx="256" cy="256" r="256" fill="#ffd93b"/><path d="M407.7 352.8a163.9 163.9 0 0 1-303.5 0c-2.3-5.5 1.5-12 7.5-13.2a780.8 780.8 0 0 1 288.4 0c6 1.2 9.9 7.7 7.6 13.2z" fill="#3e4347"/><path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/><g fill="#fff"><path d="M115.3 339c18.2 29.6 75.1 32.8 143.1 32.8 67.1 0 124.2-3.2 143.2-31.6l-1.5-.6a780.6 780.6 0 0 0-284.8-.6z"/><ellipse cx="356.4" cy="205.3" rx="81.1" ry="81"/></g><ellipse cx="356.4" cy="205.3" rx="44.2" ry="44.2" fill="#3e4347"/><g fill="#fff"><ellipse transform="scale(-1) rotate(45 454 -906)" cx="375.3" cy="188.1" rx="12" ry="8.1"/><ellipse cx="155.6" cy="205.3" rx="81.1" ry="81"/></g><ellipse cx="155.6" cy="205.3" rx="44.2" ry="44.2" fill="#3e4347"/><ellipse transform="scale(-1) rotate(45 454 -421.3)" cx="174.5" cy="188" rx="12" ry="8.1" fill="#fff"/></svg><svg class="rating-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><circle cx="256" cy="256" r="256" fill="#ffd93b"/><path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/><path d="M232.3 201.3c0 49.2-74.3 94.2-74.3 94.2s-74.4-45-74.4-94.2a38 38 0 0 1 74.4-11.1 38 38 0 0 1 74.3 11.1z" fill="#e24b4b"/><path d="M96.1 173.3a37.7 37.7 0 0 0-12.4 28c0 49.2 74.3 94.2 74.3 94.2C80.2 229.8 95.6 175.2 96 173.3z" fill="#d03f3f"/><path d="M215.2 200c-3.6 3-9.8 1-13.8-4.1-4.2-5.2-4.6-11.5-1.2-14.1 3.6-2.8 9.7-.7 13.9 4.4 4 5.2 4.6 11.4 1.1 13.8z" fill="#fff"/><path d="M428.4 201.3c0 49.2-74.4 94.2-74.4 94.2s-74.3-45-74.3-94.2a38 38 0 0 1 74.4-11.1 38 38 0 0 1 74.3 11.1z" fill="#e24b4b"/><path d="M292.2 173.3a37.7 37.7 0 0 0-12.4 28c0 49.2 74.3 94.2 74.3 94.2-77.8-65.7-62.4-120.3-61.9-122.2z" fill="#d03f3f"/><path d="M411.3 200c-3.6 3-9.8 1-13.8-4.1-4.2-5.2-4.6-11.5-1.2-14.1 3.6-2.8 9.7-.7 13.9 4.4 4 5.2 4.6 11.4 1.1 13.8z" fill="#fff"/><path d="M381.7 374.1c-30.2 35.9-75.3 64.4-125.7 64.4s-95.4-28.5-125.8-64.2a17.6 17.6 0 0 1 16.5-28.7 627.7 627.7 0 0 0 218.7-.1c16.2-2.7 27 16.1 16.3 28.6z" fill="#3e4347"/><path d="M256 438.5c25.7 0 50-7.5 71.7-19.5-9-33.7-40.7-43.3-62.6-31.7-29.7 15.8-62.8-4.7-75.6 34.3 20.3 10.4 42.8 17 66.5 17z" fill="#e24b4b"/></svg><svg class="rating-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><g fill="#ffd93b"><circle cx="256" cy="256" r="256"/><path d="M512 256A256 256 0 0 1 56.8 416.7a256 256 0 0 0 360-360c58 47 95.2 118.8 95.2 199.3z"/></g><path d="M512 99.4v165.1c0 11-8.9 19.9-19.7 19.9h-187c-13 0-23.5-10.5-23.5-23.5v-21.3c0-12.9-8.9-24.8-21.6-26.7-16.2-2.5-30 10-30 25.5V261c0 13-10.5 23.5-23.5 23.5h-187A19.7 19.7 0 0 1 0 264.7V99.4c0-10.9 8.8-19.7 19.7-19.7h472.6c10.8 0 19.7 8.7 19.7 19.7z" fill="#e9eff4"/><path d="M204.6 138v88.2a23 23 0 0 1-23 23H58.2a23 23 0 0 1-23-23v-88.3a23 23 0 0 1 23-23h123.4a23 23 0 0 1 23 23z" fill="#45cbea"/><path d="M476.9 138v88.2a23 23 0 0 1-23 23H330.3a23 23 0 0 1-23-23v-88.3a23 23 0 0 1 23-23h123.4a23 23 0 0 1 23 23z" fill="#e84d88"/><g fill="#38c0dc"><path d="M95.2 114.9l-60 60v15.2l75.2-75.2zM123.3 114.9L35.1 203v23.2c0 1.8.3 3.7.7 5.4l116.8-116.7h-29.3z"/></g><g fill="#d23f77"><path d="M373.3 114.9l-66 66V196l81.3-81.2zM401.5 114.9l-94.1 94v17.3c0 3.5.8 6.8 2.2 9.8l121.1-121.1h-29.2z"/></g><path d="M329.5 395.2c0 44.7-33 81-73.4 81-40.7 0-73.5-36.3-73.5-81s32.8-81 73.5-81c40.5 0 73.4 36.3 73.4 81z" fill="#3e4347"/><path d="M256 476.2a70 70 0 0 0 53.3-25.5 34.6 34.6 0 0 0-58-25 34.4 34.4 0 0 0-47.8 26 69.9 69.9 0 0 0 52.6 24.5z" fill="#e24b4b"/><path d="M290.3 434.8c-1 3.4-5.8 5.2-11 3.9s-8.4-5.1-7.4-8.7c.8-3.3 5.7-5 10.7-3.8 5.1 1.4 8.5 5.3 7.7 8.6z" fill="#fff" opacity=".2"/></svg></div></div></div>';
}
