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

$array = ['data' => [], 'colors' => [], 'labels' => [], 'chartshow' => false];

if(!fh_access("rapport") || !fh_access("export")){
	$array['type'] = "error";
	$array['alert'] = fh_alerts($lang['alerts']['permission'], "danger");
	echo json_encode($array);
	exit;
} elseif(!db_rows("answers WHERE id = '{$id}' && author = '".us_id."'") && us_level != 6){
	$array['type'] = "error";
	$array['alert'] = fh_alerts($lang['alerts']['wrong'], "danger");
	echo json_encode($array);
	exit;
} else {
	$array['type'] = "success";
}


$a_type     = db_get("answers", "type", $id);
$a_survey   = db_get("answers", "survey", $id);
$a_question = db_get("answers", "question", $id);
$a_step     = db_get("answers", "step", $id);
$a_val      = db_get("responses", "response", $id, "answer");

if($a_type == 'stars'){
	for($x=5;$x>=1;$x--){
		$array['data'][] = db_rows("responses WHERE answer = '{$id}' && response = '{$x}'");
		$colors = randomColor();
		$array['colors'][] = "#".$colors['hex'];
		$aa = '';
		for($i=1;$i<=$x;$i++)
			$aa .= '★';

		$array['labels'][] = $aa;
	}
	$array['chartshow'] = true;
} elseif(in_array($a_type, ["checkbox","radio"])){
	$array['id'] = '';

	$a_count = db_rows("answers WHERE survey = '{$a_survey}' && step = '{$a_step}' && question = '{$a_question}'");
	$sql_a = $db->query("SELECT * FROM ".prefix."answers WHERE survey = '{$a_survey}' && step = '{$a_step}' && question = '{$a_question}' ORDER BY id ASC") or die ($db->error);
	while($rs_a = $sql_a->fetch_assoc()){
		$array['data'][] = db_rows("responses WHERE answer = '0' && response LIKE  '%{$rs_a['id']}%'");
		$array['labels'][] = $rs_a['title'];
		$array['colors'][] = "".$flatColors[array_rand($flatColors)];
		$array['id'] .= $rs_a['id'].' / ';
	}
	$array['chartshow'] = true;
} else {
	$a_count = db_rows("answers WHERE survey = '{$a_survey}' && step = '{$a_step}' && question = '{$a_question}'");
	$sql_a = $db->query("SELECT * FROM ".prefix."answers WHERE survey = '{$a_survey}' && step = '{$a_step}' && question = '{$a_question}' GROUP BY question ORDER BY id ASC") or die ($db->error);
	while($rs_a = $sql_a->fetch_assoc()){

		$sql_r = $db->query("SELECT * FROM ".prefix."responses WHERE answer = '{$rs_a['id']}' && response != '' GROUP BY ip ORDER BY id ASC") or die ($db->error);
		while($rs_r = $sql_r->fetch_assoc()){
			$sql_rr = $db->query("SELECT * FROM ".prefix."responses WHERE survey = '{$rs_r['survey']}' && step = '{$rs_r['step']}' && question = '{$rs_r['question']}' && ip = '{$rs_r['ip']}' && response != '' ORDER BY id ASC") or die ($db->error);
			$uu = '';
			while($rs_rr = $sql_rr->fetch_assoc()){
				$att = db_get("answers", "type", $rs_rr['answer']);
				$vlee = ( $att == "phone" ? '+'.$phones[substr($rs_rr['response'], 0, 2)]['code'].''.substr($rs_rr['response'], 2, -1) : ( $att == "country" ? $countries[$rs_rr['response']] : $rs_rr['response'] ) );
				$uu .= $sql_rr->num_rows>1 ? db_get("answers", "title", $rs_rr['answer']).": ".$vlee.', ' : $rs_rr['response'];
			}
			$array['data'][] = rtrim($uu, ', ');
		}
		$array['id'] = $rs_a['id'].' / ';
	}

}

echo json_encode($array);
