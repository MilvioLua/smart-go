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
#	¤  Last Update: 29/03/2020                   ¤   #
#	¤                                            ¤   #
#¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤¤#
# -------------------------------------------------#

if((!db_rows("survies WHERE id = '{$id}' && author = '".us_id."'")) && us_level != 6){
	$alert = ["alert" => $lang['alerts']['wrong'], "type" => "error"];
	echo json_encode($alert);
	exit;
}

$alert = [];
$alert['html'] = '';
$alert['type'] = 'success';

$ri = $id;
$id = db_get("responses", "survey", $id);
$ip = db_get("responses", "ip", $ri);

$s_sql = $db->query("SELECT * FROM ".prefix."steps WHERE survey = '{$id}' ORDER BY sort ASC") or die ($db->error);
while($s_rs = $s_sql->fetch_assoc()){

	$q_sql = $db->query("SELECT * FROM ".prefix."questions WHERE survey = '{$id}' && step ='{$s_rs['sort']}' ORDER BY sort ASC") or die ($db->error);
	while($q_rs = $q_sql->fetch_assoc()){
		$alert['html'] .= "<h3>".$q_rs['title']."</h3>";
		$a_sql = $db->query("SELECT * FROM ".prefix."answers WHERE survey = '{$id}' && step ='{$s_rs['sort']}' && question = '{$q_rs['sort']}' ORDER BY id ASC") or die ($db->error);
		while($a_rs = $a_sql->fetch_assoc()){
			$resp = db_get("responses", "response", $a_rs['id'], "answer", "&& ip = '{$ip}'");
			if($a_rs['type'] == "stars"){
				$alert['html'] .= "<div class='pt-content'>";
				for($x=1;$x<=$resp;$x++)
					$alert['html'] .= '<i class="fas fa-star pt-stars-a"></i>';
				for($x=1;$x<=(5-$resp);$x++)
					$alert['html'] .= '<i class="far fa-star pt-stars"></i>';
				$alert['html'] .= "</div>";
			} elseif(in_array($a_rs['type'], ["checkbox","radio"])){
				$resp = db_get("responses", "response", $q_rs['id'], "question", "&& ip = '{$ip}'");
				$ans_arr = explode(',', $resp);
				$alert['html'] .= (in_array($a_rs['id'], $ans_arr) ? "<div class='pt-content'>".$a_rs['title']."</div>" : '');
			} elseif($a_rs['type'] == "country"){
				$alert['html'] .= "<div class='pt-content'>";
				$alert['html'] .= '<i class="flag-icon flag-icon-'.strtolower($resp).'"></i> ';
				$alert['html'] .= ($resp ? $countries[$resp] : '');
				$alert['html'] .= "</div>";
			} elseif($a_rs['type'] == "phone"){
				$alert['html'] .= "<div class='pt-content'>";
				$alert['html'] .= ($resp?'<i class="flag-icon flag-icon-'.strtolower(substr($resp, 0, 2)).'" title="+'.$phones[substr($resp, 0, 2)]['code'].'"></i> ':'');
				$alert['html'] .= substr($resp, 2, -1);
					$alert['html'] .= "</div>";
			} else {
				$alert['html'] .= "<div class='pt-content'>";
				$alert['html'] .= $resp;
				$alert['html'] .= "</div>";
			}

		}
		$a_sql->close();

	}
	$q_sql->close();

}
$s_sql->close();

echo json_encode($alert);
