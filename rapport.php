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

include __DIR__."/header.php";

if(!fh_access("rapport")){
	echo "<div class='padding'>".fh_alerts($lang['alerts']['permission'], "warning")."</div>";
	include __DIR__."/footer.php";
	exit;
}

$sql = $db->query("SELECT * FROM ".prefix."survies WHERE id = '{$id}'") or die ($db->error);
$rs = $sql->fetch_assoc();

if($rs['author'] == us_id || us_level == 6):

$firststep = db_get("steps", "views", $rs['id'], "survey", "ORDER BY id ASC LIMIT 1");
$laststep  = db_get("steps", "views", $rs['id'], "survey", "ORDER BY id DESC LIMIT 1");
$pourcent  = $firststep ? ceil(($laststep/$firststep)*100) : '--';
$lastresp  = db_get("responses", "date", $rs['id'], "survey", "ORDER BY id DESC LIMIT 1");

?>

<div class="pt-title">
	<h3><?=$lang['rapports']['title']?></h3>
	<div class="pt-options">
		<a href="<?=path?>/newsurvey.php" class="pt-btn"><i class="fas fa-plus"></i> <?=$lang['rapports']['btn1']?></a>
		<a href="<?=path?>/editsurvey.php?id=<?=$rs['id']?>" class="pt-btn btn-red"><i class="fas fa-edit"></i> <?=$lang['rapports']['btn2']?></a>
	</div>
</div>

<div class="pt-rapport">

<div class="row">
	<div class="col-6">

		<div class="pt-div-stats">
			<div><b><?=$lang['rapports']['title']?></b> <a href="<?=path?>/survey.php?id=<?=$rs['id']?>"><?=$rs['title']?></a></div>
			<div><b><?=$lang['rapports']['views']?></b> <?=$rs['views']?></div>
			<div><b><?=$lang['rapports']['responses']?></b> <?=db_rows("responses WHERE survey = '{$rs['id']}' GROUP BY ip ORDER BY id DESC")?></div>
			<div>
					<b><?=$lang['rapports']['rate']?></b>
					<span><?=$pourcent?>%</span>
			</div>
			<div><b><?=$lang['rapports']['start']?></b> <?=date('M d, Y',$rs['date'])?></div>
			<div><b><?=$lang['rapports']['end']?></b> <?=date('M d, Y',$rs['enddate'])?></div>
			<div><b><?=$lang['rapports']['last_r']?></b> <?=($lastresp?fh_ago($lastresp):'--')?></div>
		</div>

	</div>
	<div class="col-6">
		<div class="pt-surveystatslinks">
			<a href="#daily" rel="<?=$rs['id']?>"><?=$lang['rapports']['days']?></small></a>
			<a href="#monthly" rel="<?=$rs['id']?>"><?=$lang['rapports']['months']?></a>
		</div>
		<div class="pt-surveystats" rel="<?=$rs['id']?>">
			<canvas id="line-chart" width="800" height="450"></canvas>
		</div>
	</div>
</div>


<?php
$s_sql = $db->query("SELECT * FROM ".prefix."steps WHERE survey = '{$id}' ORDER BY sort ASC") or die ($db->error);
while($s_rs = $s_sql->fetch_assoc()){

	$q_sql = $db->query("SELECT * FROM ".prefix."questions WHERE survey = '{$id}' && step ='{$s_rs['sort']}' ORDER BY sort ASC") or die ($db->error);
	while($q_rs = $q_sql->fetch_assoc()){
		$q_tp = db_get("answers", "type", $id, "survey", "&& step ='{$s_rs['sort']}' && question = '{$q_rs['sort']}'");
		echo "<div class='pt-rapport-q'>
						<div class='pt-answered'>{$lang['rapports']['by']} ".db_rows("responses WHERE question = '{$q_rs['id']}' && response != '' GROUP BY ip")." of {$s_rs['views']} {$lang['rapports']['people']}</div>
						<h3>".$q_rs['title']."
							<div class='pt-options'>
							".(in_array($q_tp, ['stars', 'radio', 'checkbox'])? "<small class='showchart'>chart</small><small class='showpie'>pie</small>" :"<small class='showresults'>{$lang['rapports']['results']}</small><small class='exportEx'>{$lang['rapports']['export']}</small>")."
						</div></h3>";
		$a_sql = $db->query("SELECT * FROM ".prefix."answers WHERE survey = '{$id}' && step ='{$s_rs['sort']}' && question = '{$q_rs['sort']}' ORDER BY id ASC") or die ($db->error);
		$a = 1;
		$num = $a_sql->num_rows;
		while($a_rs = $a_sql->fetch_assoc()){
			$resp = db_get("responses", "response", $a_rs['id'], "answer");
			if($a_rs['type'] == "stars"){
				echo "<div class='pt-content' data-answer='{$a_rs['id']}'>";
				echo "</div>";
			} elseif(in_array($a_rs['type'], ["checkbox","radio"])){
				$resp = db_get("responses", "response", $q_rs['id'], "question");
				$ans_arr = explode(',', $resp);
				echo ($a == 1 ? "<div class='pt-content' data-answer='{$a_rs['id']}'>" : '').($a == $num ? "</div>" : '');
			} else {
				echo "<div class='pt-content' data-answer='{$a_rs['id']}'>";
				echo "</div>";
			}
			$a++;
		}
		$a_sql->close();
		echo "</div>";
	}
	$q_sql->close();

}
$s_sql->close();
?>
</div>


<?php
else:
	echo '<div class="padding">'.fh_alerts($lang['alerts']['wrong'], "danger", path."/index.php").'</div>';
endif;
include __DIR__."/footer.php";
?>
