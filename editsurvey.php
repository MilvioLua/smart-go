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

include __DIR__."/header.php";

if(($id && !db_rows("survies WHERE id = '{$id}' && author = '".us_id."'")) && us_level != 6){
	echo "<div class='padding'>".fh_alerts($lang['alerts']['wrong'], "danger", path."/index.php")."</div>";
	include __DIR__."/footer.php";
	exit;
}

$sql = $db->query("SELECT * FROM ".prefix."survies WHERE id = '{$id}'") or die ($db->error);
$rs = $sql->fetch_assoc();
?>

<div class="pt-title">
	<h3><?=$lang['edit']['title']?></h3>
</div>
<ul class="nav nav-tabs" id="myTab" role="tablist">
	<li class="nav-item">
    <a class="nav-link active" id="questions-tab" data-toggle="tab" href="#questions" role="tab" aria-controls="questions" aria-selected="true"><span><?=$lang['new']['questions']?></span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="welcome-tab" data-toggle="tab" href="#welcome" role="tab" aria-controls="welcome" aria-selected="false"><span><?=$lang['new']['welcome']?></span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="thank-tab" data-toggle="tab" href="#thank" role="tab" aria-controls="thank" aria-selected="false"><span><?=$lang['new']['thanks']?></span></a>
  </li>
	<?php if(fh_access("design")): ?>
  <li class="nav-item">
    <a class="nav-link" id="design-tab" data-toggle="tab" href="#design" role="tab" aria-controls="design" aria-selected="false"><span><?=$lang['new']['design']?></span></a>
  </li>
	<?php endif; ?>
</ul>

<form id="sendnewsurvey">
<div class="pt-new-survey">

	<div class="row">
		<div class="col-6">
			<div class="tab-content" id="myTabContent">
			  <div class="tab-pane fade show active" id="questions" role="tabpanel" aria-labelledby="questions-tab">

					<div class="pt-new-survey-det">
						<div class="pt-form-i">
							<span class="pt-icon"><i class="fas fa-spell-check"></i></span>
							<input type="text" name="survey_title" value="<?=$rs['title']?>" placeholder="<?=$lang['new']['stitle']?>"/>
						</div>

						<div class="row">
							<div class="col">
								<div class="pt-form-i">
									<span class="pt-icon"><i class="fas fa-calendar"></i></span>
									<input type="text" name="survey_startdate" value="<?=date("m/d/Y h:i a", $rs['startdate'])?>" id="datepicker1" class="datepicker-here" placeholder="<?=$lang['new']['start']?>">
								</div>
							</div>
							<div class="col">
								<div class="pt-form-i">
									<span class="pt-icon"><i class="far fa-calendar"></i></span>
									<input type="text" name="survey_enddate" id="datepicker" class="datepicker-here" placeholder="<?=$lang['new']['end']?>" value="<?=date("m/d/Y h:i a", $rs['enddate'])?>">
								</div>
							</div>
						</div>
						<div class="pt-form-i">
							<span class="pt-icon"><i class="fas fa-link"></i></span>
							<input type="text" name="survey_url" value="<?=$rs['url']?>" placeholder="<?=$lang['new']['url']?>"/>
						</div>

						<div class="pt-radio-slide">
							<input name="survey_private" class="tgl tgl-light" id="survey_private" type="checkbox" <?=($rs['private']?'checked':'')?>/>
							<label class="tgl-btn" for="survey_private"></label> <b><?=$lang['new']['private']?></b>
						</div>

						<div class="pt-radio-slide">
							<input name="survey_status" class="tgl tgl-light" id="survey_status" type="checkbox" <?=($rs['status']?'checked':'')?>/>
							<label class="tgl-btn" for="survey_status"></label> <b><?=$lang['new']['unpub']?></b>
						</div>

						<div class="pt-radio-slide">
							<input name="survey_byip" class="tgl tgl-light" id="survey_byip" type="checkbox" <?=($rs['byip']?'checked':'')?>/>
							<label class="tgl-btn" for="survey_byip"></label> <b><?=$lang['new']['ip']?></b>
						</div>

					</div>



					<?php
					$s_sql = $db->query("SELECT * FROM ".prefix."steps WHERE survey = '{$id}' ORDER BY sort ASC") or die ($db->error);
					while($s_rs = $s_sql->fetch_assoc()){
						?>
						<div class="pt-new-step-content" data-step="<?=$s_rs['sort']?>">
							<h4>Step (<?=$s_rs['sort']?>): <a class="pt-add-question-link" data-step="<?=$s_rs['sort']?>"><?=$lang['new']['new_q']?></a></h4>
							<input type="hidden" name="step[<?=$s_rs['sort']?>]" value="<?=$s_rs['sort']?>"/>
						<?php

						$q_sql = $db->query("SELECT * FROM ".prefix."questions WHERE survey = '{$id}' && step ='{$s_rs['sort']}' ORDER BY sort ASC") or die ($db->error);
						while($q_rs = $q_sql->fetch_assoc()){
							$q_tp = db_get("answers", "type", $id, "survey", "&& step ='{$s_rs['sort']}' && question = '{$q_rs['sort']}'");

							?>

							<div class='pt-new-question-content' rel='boxquestion_<?=$q_rs["sort"]?>' data-question='<?=$q_rs["sort"]?>' data-step='<?=$s_rs["sort"]?>'>
								<span class='deleteboxquestion_<?=$q_rs["sort"]?>' data-step='<?=$s_rs["sort"]?>' data-qid='<?=$s_rs["id"]?>'><i class='fas fa-times'></i></span>
								<div class='pt-question-inp'>
									<label>Q<?=$q_rs["sort"]?>:</label>
									<input type='hidden' name='question[q<?=$q_rs["sort"]?>s<?=$s_rs["sort"]?>][step]' value='<?=$s_rs["sort"]?>'/>
									<input type='text' name='question[q<?=$q_rs["sort"]?>s<?=$s_rs["sort"]?>][title]' data-change='s<?=$s_rs["sort"]?>q<?=$q_rs["sort"]?>' value="<?=$q_rs["title"]?>" placeholder='<?=$lang['new']['new_qpl']?>'/>
									<textarea name='question[q<?=$q_rs["sort"]?>s<?=$s_rs["sort"]?>][desc]' data-change='s<?=$s_rs["sort"]?>q<?=$q_rs["sort"]?>' placeholder='<?=$lang['new']['new_qde']?>'><?=$q_rs["description"]?></textarea>
									<div class="pt-radio-slide">
										<input name="question[q<?=$q_rs["sort"]?>s<?=$s_rs["sort"]?>][status]" class="tgl tgl-light" id="cbr<?=$q_rs["sort"]?><?=$s_rs["sort"]?>" type="checkbox" <?=($q_rs["status"]?'checked':'')?>/>
										<label class="tgl-btn" for="cbr<?=$q_rs["sort"]?><?=$s_rs["sort"]?>"></label> <?=$lang['new']['new_qre']?>
									</div>
									<div class="pt-radio-slide">
										<input name="question[q<?=$q_rs["sort"]?>s<?=$s_rs["sort"]?>][inline]" class="tgl tgl-light" id="cbi<?=$q_rs["sort"]?><?=$s_rs["sort"]?>" type="checkbox" <?=($q_rs["inline"]?'checked':'')?>/>
										<label class="tgl-btn" for="cbi<?=$q_rs["sort"]?><?=$s_rs["sort"]?>"></label> <?=$lang['new']['new_qln']?>
									</div>
								</div>
								<div class='pt-new-answers-content' data-question='<?=$q_rs["sort"]?>' data-step='<?=$s_rs["sort"]?>'>
									<b><?=$lang['new']['new_a']?></b>
									<select class='pt-select'>
										<option value='input' data-type='input'><?=$lang['new']['new_as1']?></option>
										<option value='textarea' data-type='text'><?=$lang['new']['new_as2']?></option>
										<option value='checkbox' data-type='checkbox'><?=$lang['new']['new_as3']?></option>
										<option value='radio' data-type='radio'><?=$lang['new']['new_as4']?></option>
										<option value='stars' data-type='stars'><?=$lang['new']['new_as5']?></option>
										<option value='date' data-type='input'><?=$lang['new']['new_as6']?></option>
										<option value='phone' data-type='input'><?=$lang['new']['new_as7']?></option>
										<option value='country' data-type='input'><?=$lang['new']['new_as8']?></option>
										<option value='email' data-type='input'><?=$lang['new']['new_as9']?></option>
									</select>
									<div class="pt-radio-slide">
										<input name="answer_with_icon" class="tgl tgl-light" id="cbic<?=$q_rs["sort"]?><?=$s_rs["sort"]?>" type="checkbox"/>
										<label class="tgl-btn" for="cbic<?=$q_rs["sort"]?><?=$s_rs["sort"]?>"></label> <b><?=$lang['new']['new_asi']?></b>
									</div>
									<a class='pt-add-answer-link' data-question='<?=$q_rs["sort"]?>' data-step='<?=$s_rs["sort"]?>'><?=$lang['new']['new_abtn']?></a>
								</div>
								<div class='pt-new-answer-content'>

							<?php

							$a_sql = $db->query("SELECT * FROM ".prefix."answers WHERE survey = '{$id}' && step ='{$s_rs['sort']}' && question = '{$q_rs['sort']}' ORDER BY id ASC") or die ($db->error);
							$a = 1;
							$num = $a_sql->num_rows;
							while($a_rs = $a_sql->fetch_assoc()){
								?>
								<div class='boxanswer_<?=$a_rs["id"]?>'>
								<span class='deleteboxanswer_<?=$a_rs["id"]?>'><i class='fas fa-times'></i></span>
								<input type='hidden' name='answer[<?=$a_rs["id"]?>][step]' value='<?=$a_rs["step"]?>'>
								<input type='hidden' name='answer[<?=$a_rs["id"]?>][question]' value='<?=$a_rs["question"]?>'>
								<input type='hidden' name='answer[<?=$a_rs["id"]?>][type]' value='<?=$a_rs["type"]?>'>
								<?php
								if($a_rs['type'] == "stars"){
									?><div class="pt-survey-answers"><?=rating_inp('rating', '')?></div><?php
								} elseif($a_rs['type'] == "textarea"){
									?><textarea name='answer[<?=$a_rs["id"]?>][name]' placeholder='<?=$lang['new']['new_aspl']?>' class='pt-count-answers'><?=$a_rs["title"]?></textarea><?php
								} elseif($a_rs['type'] == "country"){
									?><input type='text' name='answer[<?=$a_rs["id"]?>][name]' value="<?=$a_rs["title"]?>" placeholder='<?=$lang['new']['new_aspl']?>' class='pt-count-answers'><?php
								} elseif($a_rs['type'] == "phone"){
									?><input type='phone' name='answer[<?=$a_rs["id"]?>][name]' value="<?=$a_rs["title"]?>" placeholder='<?=$lang['new']['new_aspl']?>' class='pt-count-answers'><?php
								} elseif($a_rs['type'] == "checkbox"){
									?>
									<div class='pt-checkbox-add'>
										<div class="form-group">
										<input type="checkbox" name="answer[<?=$a_rs["id"]?>][names]" id="checkbox<?=$a_rs["id"]?>" class="choice pt-count-answers">
										<label for="checkbox<?=$a_rs["id"]?>"><input type="text" name="answer[<?=$a_rs["id"]?>][name]" rel="aa<?=$a_rs["id"]?>" placeholder="<?=$lang['new']['new_asck']?>" value="<?=$a_rs["title"]?>"></label>
			    					</div>
									</div>

									<?php
								} elseif($a_rs['type'] == "radio"){
									?>
									<div class='pt-checkbox-add'>
										<div class="form-group">
										<input type="radio" name="answer[<?=$a_rs["id"]?>][names]" id="radio<?=$a_rs["id"]?>" class="choice pt-count-answers">
										<label for="radio<?=$a_rs["id"]?>"><input type="text" name="answer[<?=$a_rs["id"]?>][name]" rel="aa<?=$a_rs["id"]?>" placeholder="<?=$lang['new']['new_asck']?>" value="<?=$a_rs["title"]?>"></label>
			    					</div>
									</div>

									<?php
								} elseif(in_array($a_rs['type'], ['input', 'email', 'date'])){
									if($a_rs['icon']):
										?>
										<div class='row'>
											<div class='col'>
												<input type='text' name='answer[<?=$a_rs["id"]?>][name]' value="<?=$a_rs["title"]?>" placeholder='<?=$lang['new']['new_aspl']?>' class='pt-count-answers'>
											</div>
											<div class='col-4'>
												<input type='text' name='answer[<?=$a_rs["id"]?>][icon]' value="<?=$a_rs["icon"]?>" class='my' placeholder='<?=$lang['new']['new_asi']?>'>
												<span class='changeicon'><i class="<?=$a_rs["icon"]?>"></i></span>
											</div>
										</div>

										<?php
									else:
										?><input type='text' name='answer[<?=$a_rs["id"]?>][name]' value="<?=$a_rs["title"]?>" placeholder='<?=$lang['new']['new_aspl']?>' class='pt-count-answers'><?php
									endif;

								}
								$a++;
								?>
								</div>
								<?php

							}
							$a_sql->close();
							?>

								</div>
							</div>
							<?php
						}
						$q_sql->close();

						?>
						</div>
						<?php

					}
					$s_sql->close();



					?>

						<!-- <a class="pt-new-step"><i class="far fa-plus-square"></i> <?=$lang['new']['new_step']?></a> -->
						<a href="#" class="fancy-button bg-gradient5 pt-new-step">
							<span><i class="far fa-plus-square"></i> <?=$lang['new']['start_q']?></span>
						</a>
						<button type="sublit" name="submit" class="fancy-button bg-gradient6">
							<span><?=$lang['new']['send']?> <i class="far fa-grin-stars"></i></span>
						</button>


				</div><!-- End Questions Tab -->
			  <div class="tab-pane fade" id="welcome" role="tabpanel" aria-labelledby="welcome-tab">

					<div class="pt-welcome-step" data-step="welcome">
						<h4><?=$lang['new']['wp']?></h4>
						<div class="pt-new-question-content">
							<div class="pt-question-inp">
								<input type="text" name="survey_welcome_h" data-change="s0" value="<?=$rs['welcome_head']?>" placeholder="<?=$lang['new']['wp_h']?>">
								<textarea name="survey_welcome_t" id="wysibb-editor"><?=$rs['welcome_text']?></textarea>
								<input type="text" name="survey_welcome_b" value="<?=$rs['welcome_btn']?>" placeholder="<?=$lang['new']['wp_btn']?>">
								<input type="text" name="survey_welcome_bi" value="<?=$rs['welcome_icon']?>" class="my" placeholder="<?=$lang['new']['wp_icon']?>">
							</div>
						</div>
					</div>


			  </div><!-- End Welcome Tab -->
			  <div class="tab-pane fade" id="thank" role="tabpanel" aria-labelledby="thank-tab">

					<div class="pt-welcome-step" data-step="thank">
						<h4><?=$lang['new']['tx']?></h4>
						<div class="pt-new-question-content">
							<div class="pt-question-inp">
								<input type="text" name="survey_thank_h" data-change="stu" value="<?=$rs['thanks_head']?>" placeholder="<?=$lang['new']['tx_h']?>">
								<textarea name="survey_thank_t" id="wysibb-editor1"><?=$rs['thanks_text']?></textarea>
								<input type="text" name="survey_thank_b" value="<?=$rs['thanks_btn']?>" placeholder="<?=$lang['new']['tx_btn']?>">
								<input type="text" name="survey_thank_bi" class="my" value="<?=$rs['thanks_icon']?>" placeholder="<?=$lang['new']['tx_icon']?>">
							</div>
						</div>
					</div>


				</div><!-- End Thank you Tab -->
				<?php if(fh_access("design")): ?>
			  <div class="tab-pane fade" id="design" role="tabpanel" aria-labelledby="design-tab">
					<div class="pt-design">
						<div class="form-inline">
							<div class="form-group">
								<label><?=$lang['new']['design_bs']?> </label>
							</div>
							<div class="form-group">
								<input type="radio" name="button_shadow" id="sradio1" value="0" class="choice"  <?=(!$rs['button_shadow']?'checked':'')?>>
								<label for="sradio1"><?=$lang['new']['design_yes']?></label>
							</div>
							<div class="form-group">
								<input type="radio" name="button_shadow" id="sradio2" value="1" class="choice" <?=($rs['button_shadow']?'checked':'')?>>
								<label for="sradio2"><?=$lang['new']['design_no']?></label>
							</div>
						</div>
						<div class="form-inline">
							<div class="form-group">
								<label for="sradio1ss"><?=$lang['new']['design_bb']?> </label>
							</div>
							<div class="form-group">
								<label><?=$lang['new']['design_si']?> </label>
								<input type="number" name="button_border_size" min="0" max="9" value="<?=$rs['button_border_size']?>">
							</div>
							<div class="form-group">
								<label><?=$lang['new']['design_s']?> </label>
								<select name="button_border_style">
									<option value="none"<?=($rs['button_border_style'] == 'none'?' selected':'')?>>None</option>
									<option value="solid"<?=($rs['button_border_style'] == 'solid'?' selected':'')?>>Solid</option>
									<option value="dotted"<?=($rs['button_border_style'] == 'dotted'?' selected':'')?>>Dotted</option>
									<option value="dashed"<?=($rs['button_border_style'] == 'dashed'?' selected':'')?>>Dashed</option>
								</select>
							</div>
							<div class="form-group">
								<label><?=$lang['new']['design_c']?>: </label>
								<input type="text" name="button_border_color" id="colorpicker-popup" value="<?=$rs['button_border_color']?>" placeholder="type the category bg color">
								<input type="hidden" name="pg_bg_v" value="<?=$rs['button_border_color']?>">
							</div>
						</div>
						<div class="form-inline">
							<div class="form-group">
								<label for="sradio1ss"><?=$lang['new']['design_btg']?> </label>
							</div>
							<div class="form-group">
								<div class="form-group">
									<input type="radio" name="bg_gradient" id="sradio12" value="0" class="choice" <?=(!$rs['bg_gradient']?'checked':'')?>>
									<label for="sradio12"><?=$lang['new']['design_g']?></label>
								</div>
								<div class="form-group">
									<input type="radio" name="bg_gradient" id="sradio22" value="1" class="choice" <?=($rs['bg_gradient']?'checked':'')?>>
									<label for="sradio22"><?=$lang['new']['design_n']?></label>
								</div>
							</div>
							<div class="form-group">
								<label><?=$lang['new']['design_c']?>1: </label>
								<input type="text" name="bg_color1" class="colorpicker-popup" value="<?=$rs['bg_color1']?>">
								<input type="hidden" name="bg_v1" value="<?=$rs['bg_color1']?>">
							</div>
							<div class="form-group">
								<label><?=$lang['new']['design_c']?>2: </label>
								<input type="text" name="bg_color2" class="colorpicker-popup" value="<?=$rs['bg_color2']?>">
								<input type="hidden" name="bg_v2" value="<?=$rs['bg_color2']?>">
							</div>
								<div class="bg-sty"></div>
							</div>
							<div class="form-inline">
								<div class="form-group">
									<label for="sradio1ss"><?=$lang['new']['design_btc']?> </label>
								</div>
								<div class="form-group">
									<input type="text" name="txt_color" class="colorpicker-popup" value="<?=$rs['txt_color']?>">
									<input type="hidden" name="txt_v" value="<?=$rs['txt_color']?>">
								</div>
							</div>
							<div class="form-inline">
								<div class="form-group">
									<label for="sradio1ss"><?=$lang['new']['design_sbg']?> </label>
								</div>
								<div class="form-group">
									<input type="text" name="survey_bg" class="colorpicker-popup" value="<?=$rs['survey_bg']?>">
									<input type="hidden" name="sbg_v" value="<?=$rs['survey_bg']?>">
								</div>
							</div>
							<div class="form-inline">
								<div class="form-group">
									<label for="sradio1ss"><?=$lang['new']['design_stbg']?> </label>
								</div>
								<div class="form-group">
									<input type="text" name="step_bg" class="colorpicker-popup" value="<?=$rs['step_bg']?>">
									<input type="hidden" name="stbg_v" value="<?=$rs['step_bg']?>">
								</div>
							</div>
							<div class="form-inline">
								<div class="form-group">
									<label for="sradio1ss"><?=$lang['new']['design_ibg']?> </label>
								</div>
								<div class="form-group">
									<input type="text" name="input_bg" class="colorpicker-popup" value="<?=$rs['input_bg']?>">
									<input type="hidden" name="inpbg_v" value="<?=$rs['input_bg']?>">
								</div>
							</div>


					</div>
				</div><!-- End Design Tab -->
				<?php endif; ?>
			</div>
		</div>
		<div class="col-6">
			<div class="pt-surveybg">
			<input type="hidden" name="survey_code" value="<?=$rs['code']?>" />
			<input type="hidden" name="survey_id" value="<?=$rs['id']?>" />
			<div class="pt-survey">
				<div class="pt-dots pt-lines">
					<a href="#"><i class="fas fa-angle-left"></i></a>
					<a class="active"></a>
					<a class="active"><span class="show"><?=ceil(2 *100 / (5+2))?>%</span></a>
					<a></a>
					<a href="#"><i class="fas fa-angle-right"></i></a>
				</div>
				<h3 data-link="s0_title"><?=$rs['welcome_head']?></h3>
				<div class="textarea-welcome"><?=fh_bbcode(nl2br($rs['welcome_text']))?></div>
				<div class="pt-link">
					<button class="fancy-button bg-gradient1 step-link">
						<span>
							<?=($rs['welcome_btn'] ? $rs['welcome_btn'] : 'Start the survey')?>
							<i class="<?=($rs['welcome_icon'] ? $rs['welcome_icon'] : 'far fa-arrow-alt-circle-right')?>"></i>
						</span>
					</button>
				</div>
			</div>
			<div class="pt-new-survey-change">

			</div>
			<div class="pt-survey">
				<h3 data-link="stu_title"><?=$rs['thanks_head']?></h3>
				<div class="textarea-thank"><?=fh_bbcode(nl2br($rs['thanks_text']))?></div>
				<div class="pt-link">
					<button class="fancy-button bg-gradient1 step-link">
						<span>
							<?=($rs['thanks_btn'] ? $rs['thanks_btn'] : 'The End')?>
							<i class="<?=($rs['welcome_icon'] ? $rs['welcome_icon'] : 'fas fa-heart')?>"></i>
						</span>
					</button>
				</div>
			</div>
		</div>
	</div>
	</div>

</div>
</form>

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
<?php if($rs['survey_bg']): ?>
.pt-newsurveypage .pt-surveybg, .pt-editsurveypage .pt-surveybg {
	background: <?=$rs['survey_bg']?>
}
<?php endif; ?>
<?php if($rs['step_bg']): ?>
.pt-surveybg .pt-dots a.active,
.pt-surveybg .pt-dots.pt-lines a span,
.pt-surveybg .bootstrap-select .dropdown-menu.inner li.selected.active a {
	background: <?=$rs['step_bg']?>
}
.pt-surveybg .pt-dots.pt-lines a span:before {
	border-left-color: <?=$rs['step_bg']?>
}
.pt-surveybg .choice[type=checkbox]:checked + label:before {
	background-color: <?=$rs['step_bg']?>
}
.pt-surveybg .choice:checked + label:before {
    border-color: <?=$rs['step_bg']?>;
    box-shadow: 0 0 0 4px <?=$rs['step_bg']?> inset;
}
<?php endif; ?>
<?php if($rs['input_bg']): ?>
.pt-surveybg input[type=text],
.pt-surveybg input[type=password],
.pt-surveybg input[type=phone],
.pt-surveybg input[type=email],
.pt-surveybg input[type=number],
.pt-surveybg select,
.pt-surveybg textarea,
.pt-surveybg .bootstrap-select .btn {
	border-bottom-color: <?=$rs['input_bg']?>
}
<?php endif; ?>
</style>
<?php endif; ?>

<?php
include __DIR__."/footer.php";
?>
