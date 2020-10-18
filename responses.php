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

$sql = $db->query("SELECT * FROM ".prefix."survies WHERE id = '{$id}'") or die ($db->error);
$rs = $sql->fetch_assoc();
if($rs['author'] == us_id || us_level == 6):
?>

<div class="pt-title">
	<h3><?=$lang['responses']['title']?>/<a href="<?=path?>/survey.php?id=<?=$rs['id']?>"><small><?=$rs['title']?></small></a></h3>
	<div class="pt-options">
		<a href="<?=path?>/rapport.php?id=<?=$rs['id']?>" class="pt-btn"><i class="fas fa-chart-pie"></i> <?=$lang['responses']['btn_1']?></a>
		<a href="<?=path?>/editsurvey.php?id=<?=$rs['id']?>" class="pt-btn btn-red"><i class="fas fa-edit"></i> <?=$lang['responses']['btn_2']?></a>
	</div>
</div>

<div class="table-responsive">
<table class="table">
	<thead>
		<tr>
			<?php
			$q_sql = $db->query("SELECT * FROM ".prefix."questions WHERE survey = '{$id}' ORDER BY step ASC,sort ASC LIMIT 12") or die ($db->error);
			while($q_rs = $q_sql->fetch_assoc()):
			?>
				<th scope="col"><span class="spover"><?=$q_rs['title']?></span></th>
			<?php
			endwhile;
			?>
		</tr>
	</thead>
	<tbody>
		<?php
		$sql = $db->query("SELECT * FROM ".prefix."responses WHERE survey = '{$id}' GROUP BY ip ORDER BY id DESC LIMIT {$startpoint} , {$limit}") or die ($db->error);
		if($sql->num_rows):
		while($rs = $sql->fetch_assoc()):
		?>
		<tr class="pt-response" data-response="<?=$rs['id']?>">
			<?php
			$q_sql = $db->query("SELECT * FROM ".prefix."questions WHERE survey = '{$id}' ORDER BY step ASC,sort ASC LIMIT 12") or die ($db->error);
			while($q_rs = $q_sql->fetch_assoc()):
			?>
				<td scope="col"><span class="spover">
					<?php
					$ans_id = db_get("responses", "answer", $q_rs['id'], "question", "&& ip = '{$rs['ip']}'");
					$ans_tp = $ans_id ? db_get("answers", "type", $ans_id) : 'check';
					$ans_vl = db_get("responses", "response", $q_rs['id'], "question", "&& ip = '{$rs['ip']}'");
						if($ans_tp == "stars"){
							for($x=1;$x<=$ans_vl;$x++)
								echo '<i class="fas fa-star" style="color:#fcd939"></i>';
							for($x=1;$x<=(5-$ans_vl);$x++)
								echo '<i class="far fa-star" style="color:#fdf6cd"></i>';
						} elseif($ans_tp == "check"){
							$ans_arr = explode(',', $ans_vl);
							$i=0;
							for($x=0;$x<count($ans_arr);$x++){
								$i++;
								echo db_get("answers", "title", $ans_arr[$x]);
								echo ($i != count($ans_arr) ? ' | ': '');
							}

						} elseif($ans_tp == "country"){
							echo '<i class="flag-icon flag-icon-'.strtolower($ans_vl).'"></i> ';
							echo "{$countries[$ans_vl]}";
						} elseif($ans_tp == "phone"){
							echo ($ans_vl?'<i class="flag-icon flag-icon-'.strtolower(substr($ans_vl, 0, 2)).'" title="+'.$phones[substr($ans_vl, 0, 2)]['code'].'"></i> ':'');
							echo substr($ans_vl, 2, -1);
						} else {
							echo "{$ans_vl}";
						}
					 ?>
				</span></td>
			<?php
			endwhile;
			?>
		</tr>
		<?php
		endwhile;
		echo (db_rows("responses WHERE survey = '{$id}' GROUP BY ip") > $limit ? '<tr><td colspan="12">'.fh_pagination("responses WHERE survey = '{$id}' GROUP BY ip",$limit, path."/responses.php?id={$id}&").'</td></tr>' : '');
		else:
			?>
			<tr>
				<td colspan="12">
					<?=fh_alerts($lang['alerts']['no-data'], "info")?>
				</td>
			</tr>
			<?php
		endif;
		$sql->close();
		?>

	</tbody>
</table>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      <div class="modal-body pt-response-m"></div>
    </div>
  </div>
</div>

<?php
else:
	echo '<div class="padding">'.fh_alerts($lang['alerts']['wrong'], "danger", path."/index.php").'</div>';
endif;
include __DIR__."/footer.php";
?>
