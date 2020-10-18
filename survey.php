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
if($sql->num_rows):

$rs = $sql->fetch_assoc();
if(($rs['status'] && $rs['author'] != us_id) && us_level != 6):
?>
	<div class="pt-survey pt-close-s">
		<h3><?=$lang['survey']['close_h']?></h3>
		<p><?=$lang['survey']['close_p']?></p>
		<div>
			<a href="<?=path?>" class="fancy-button bg-gradient5">
				<span><?=$lang['survey']['button']?> <i class="fas fa-heart"></i></span>
			</a>
		</div>
	</div>
<?php
include __DIR__."/footer.php";
exit;
endif;


# Update Survey Views
if(!isset($_COOKIE["survey_view_{$id}"])) {
	db_update("survies", ["views" => $rs['views']+1], $id);
}
?>

<div class="pt-breadcrump">
  <li><a href="<?=path?>"><i class="fas fa-home"></i> <?=$lang['menu']['home']?></a></li>
	<li><?=$rs['title']?></li>
</div>

<div class="pt-survey">
	<div class="pt-dots pt-lines">
		<a href="#"><i class="fas fa-angle-left"></i></a>
		<a class="active"></a>
		<?php
		$sql_st = $db->query("SELECT * FROM ".prefix."steps WHERE survey = '{$id}' ORDER BY id ASC") or die ($db->error);
		$count_st = $sql_st->num_rows;
		while($rs_st = $sql_st->fetch_assoc()):
		?>
		<a rel="<?=$rs_st['sort']?>"><span><?=ceil($rs_st['sort'] *100 / ($count_st+2))?>%</span></a>
		<?php
		endwhile;
		$sql_st->close();
		?>
		<a href="#"><i class="fas fa-angle-right"></i></a>
	</div>

	<form id="survey-send-answers">
		<div id="step-content">
			<h3 class="pt-survey-head"><?=$rs['welcome_head']?></h3>
			<div class="pt-survey-head"><?=fh_bbcode(nl2br($rs['welcome_text']))?></div>

			<div class="pt-link">
				<button type="submit" class="fancy-button bg-gradient1 step-link" data-behave="next" data-target="steps" data-step="1" data-survey="<?=$id?>">
					<span>
						<?=($rs['welcome_btn'] ? $rs['welcome_btn'] : 'Start the survey')?>
						<i class="<?=($rs['welcome_icon'] ? $rs['welcome_icon'] : 'far fa-arrow-alt-circle-right')?>"></i>
					</span>
				</button>
			</div>
		</div>
	</form>
</div>

<!-- Dynamic Survey Styling -->

<?php if(!empty([$rs['button_border_size'], $rs['button_border_style'], $rs['button_border_color'], $rs['bg_color1'], $rs['bg_color2'], $rs['txt_color']])):?>
<style>
.step-link span {
	<?php if($rs['button_border_size']): ?>border-width: <?=$rs['button_border_size']?>px; <?php endif; ?>
	<?php if($rs['button_border_style']): ?>border-style: <?=$rs['button_border_style']?>; <?php endif; ?>
	<?php if($rs['button_border_color']): ?>border-color: <?=$rs['button_border_color']?>; <?php endif; ?>
	<?php if(!$rs['bg_gradient'] && $rs['bg_color1']): ?>background: linear-gradient(to right, <?=$rs['bg_color1']?> 0%, <?=$rs['bg_color2']?> 80%, <?=$rs['bg_color2']?> 100%); <?php endif; ?>
	<?php if($rs['bg_gradient'] && $rs['bg_color1']): ?>background: <?=$rs['bg_color1']?>; <?php endif; ?>
	<?php if($rs['txt_color']): ?>color: <?=$rs['txt_color']?>; <?php endif; ?>
}
.step-link:before {
	<?php if(!$rs['bg_gradient'] && $rs['bg_color1']): ?>background: linear-gradient(to right, <?=$rs['bg_color1']?> 0%, <?=$rs['bg_color2']?> 80%, <?=$rs['bg_color2']?> 100%); <?php endif; ?>
	<?php if($rs['bg_gradient'] && $rs['bg_color1']): ?>background: <?=$rs['bg_color1']?>; <?php endif; ?>
}
<?php if($request == "su" && $rs['survey_bg']): ?>
body.pt-nouser {
	background: <?=$rs['survey_bg']?>
}
<?php endif; ?>
<?php if($rs['step_bg']): ?>
.pt-surveypage .pt-body .pt-dots a.active,
.pt-surveypage .pt-body .pt-dots.pt-lines a span,
.bootstrap-select .dropdown-menu.inner li.selected.active a {
	background: <?=$rs['step_bg']?>
}
.pt-surveypage .pt-body .pt-dots.pt-lines a span:before {
	border-left-color: <?=$rs['step_bg']?>
}
.choice[type=checkbox]:checked + label:before {
	background-color: <?=$rs['step_bg']?>
}
.choice:checked + label:before {
    border-color: <?=$rs['step_bg']?>;
    box-shadow: 0 0 0 4px <?=$rs['step_bg']?> inset;
}
<?php endif; ?>
<?php if($rs['input_bg']): ?>
input[type=text],
input[type=password],
input[type=phone],
input[type=email],
input[type=number],
select, textarea, .bootstrap-select .btn {
	border-bottom-color: <?=$rs['input_bg']?>
}
<?php endif; ?>
</style>
<?php endif; ?>

<!-- End Dynamic Survey Styling -->

<?php
else:
echo "<div class='padding'>".fh_alerts($lang['alerts']['wrong'], "danger", path."/index.php")."</div>";
endif;
$sql->close();

include __DIR__."/footer.php";
?>
