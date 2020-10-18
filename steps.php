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

include __DIR__ . "/configs.php";

if($id == '0') {
	$sql = $db->query("SELECT * FROM ".prefix."survies WHERE id = '{$s}'") or die ($db->error);
	if($sql->num_rows){
	$rs = $sql->fetch_assoc();
	?>
	<h3 class="pt-survey-head"><?=$rs['welcome_head']?></h3>
	<div class="pt-survey-head"><?=fh_bbcode(nl2br($rs['welcome_text']))?></div>
	<div class="pt-link">
		<button type="submit" class="fancy-button bg-gradient1 step-link" data-behave="next" data-target="steps" data-step="1" data-survey="<?=$s?>">
			<span>
				<?=($rs['welcome_btn'] ? $rs['welcome_btn'] : 'Start the survey')?>
				<i class="<?=($rs['welcome_icon'] ? $rs['welcome_icon'] : 'far fa-arrow-alt-circle-right')?>"></i>
			</span>
		</button>
	</div>
	<?php
	}
	$sql->close();
} else {

	$sql_s = $db->query("SELECT * FROM ".prefix."questions WHERE survey = '{$s}' && step = '{$id}' ORDER BY id DESC") or die ($db->error);
	if($sql_s->num_rows){

		# Update Step Views
		$laststep  = db_get("steps", "id", $s, "survey", "ORDER BY id DESC LIMIT 1");
		$stepid    = db_get("steps", "id", $id, "sort", "&& survey = '{$s}'");
		$stepviews = db_get("steps", "views", $stepid);
		if($laststep != $stepid){
			# Update Step Views
			if(!isset($_COOKIE["survey_view_{$id}_step_{$stepid}"])) {
				setcookie("survey_view_{$id}_step_{$stepid}", $stepid, time() + (86400 * 365));
				db_update("steps", ["views" => $stepviews+1], $stepid);
			}
		}


		while($rs_s = $sql_s->fetch_assoc()):
		?>
			<h3 class="pt-survey-head"><?=$rs_s['title']?></h3>
			<p class="pt-survey-head"><?=$rs_s['description']?></p>
			<?php
			$sql_a = $db->query("SELECT * FROM ".prefix."answers WHERE survey = '{$s}' && step = '{$id}' && question = '{$rs_s['sort']}' ORDER BY id ASC") or die ($db->error);
			$count_a = $sql_a->num_rows;
			$a = 0;
			while($rs_a = $sql_a->fetch_assoc()):
				$a++;
				echo ( $a == 1 ? fh_get_answer_start($rs_a, $rs_s) : '');
				echo fh_get_answer($rs_a, $rs_s);
				echo ( $a == $count_a ? fh_get_answer_end($rs_a, $rs_s) : '');
			endwhile;
			$sql_a->close();
			?>
		<?php
		endwhile;
		?>

		<div class="pt-link">
			<div class="row">
				<div class="col">
					<button type="submit" class="fancy-button bg-gradient2 step-link" data-behave="back" data-target="steps" data-step="<?=$id-1?>" data-survey="<?=$s?>">
						<span><i class="fas fa-arrow-circle-left"></i> <?=$lang['survey']['back']?></span>
					</button>
				</div>
				<div class="col">
					<button type="submit" class="fancy-button bg-gradient1 step-link" data-behave="next" data-target="steps"  data-step="<?=$id+1?>" data-survey="<?=$s?>">
						<span><?=$lang['survey']['next']?> <i class="fas fa-arrow-circle-right"></i></span>
					</button>
				</div>
			</div>
		</div>

		<?php
	} else {
		$sql = $db->query("SELECT * FROM ".prefix."survies WHERE id = '{$s}'") or die ($db->error);
		if($sql->num_rows){
		$rs = $sql->fetch_assoc();
		$laststep  = db_get("steps", "id", $s, "survey", "ORDER BY id DESC LIMIT 1");
		$stepid    = db_get("steps", "id", $id-1, "sort", "&& survey = '{$s}'");
		$stepviews = db_get("steps", "views", $stepid);
		if($laststep == $stepid){
			# Update Step Views
			if(!isset($_COOKIE["survey_view_{$id}_step_{$stepid}"])) {
				setcookie("survey_view_{$id}_step_{$stepid}", $stepid, time() + (86400 * 365));
				db_update("steps", ["views" => $stepviews+1], $stepid);
			}
		}

		?>
			<h3><?=$rs['thanks_head']?></h3>
			<div><?=fh_bbcode(nl2br($rs['thanks_text']))?></div>
			<div class="pt-link">
				<button type="submit" class="fancy-button bg-gradient1 step-link" data-behave="finish" data-target="steps" data-step="end" data-survey="<?=$s?>" data-url="<?=$rs['url']?>">
					<span>
						<?=($rs['thanks_btn'] ? $rs['thanks_btn'] : 'The End')?>
						<i class="<?=($rs['welcome_icon'] ? $rs['welcome_icon'] : 'fas fa-heart')?>"></i>
					</span>
				</button>
			</div>
		<?php
		}
		$sql->close();
	}
$sql_s->close();
}
