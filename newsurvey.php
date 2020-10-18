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
if(!fh_access("survey")){
	echo "<div class='padding'>".fh_alerts($lang['alerts']['permission'], "warning")."</div>";
	include __DIR__."/footer.php";
	exit;
}
?>

<div class="pt-title">
	<h3><?=$lang['new']['title']?></h3>
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
							<input type="text" name="survey_title" placeholder="<?=$lang['new']['stitle']?>"/>
						</div>

						<div class="row">
							<div class="col">
								<div class="pt-form-i">
									<span class="pt-icon"><i class="fas fa-calendar"></i></span>
									<input type="text" name="survey_startdate" id="datepicker1" class="datepicker-here" placeholder="<?=$lang['new']['start']?>">
								</div>
							</div>
							<div class="col">
								<div class="pt-form-i">
									<span class="pt-icon"><i class="far fa-calendar"></i></span>
									<input type="text" name="survey_enddate" id="datepicker" class="datepicker-here" placeholder="<?=$lang['new']['end']?>">
								</div>
							</div>
						</div>
						<div class="pt-form-i">
							<span class="pt-icon"><i class="fas fa-link"></i></span>
							<input type="text" name="survey_url" placeholder="<?=$lang['new']['url']?>"/>
						</div>

						<div class="pt-radio-slide">
							<input name="survey_private" class="tgl tgl-light" id="survey_private" type="checkbox"/>
							<label class="tgl-btn" for="survey_private"></label> <b><?=$lang['new']['private']?></b>
						</div>

						<div class="pt-radio-slide">
							<input name="survey_status" class="tgl tgl-light" id="survey_status" type="checkbox"/>
							<label class="tgl-btn" for="survey_status"></label> <b><?=$lang['new']['unpub']?></b>
						</div>

						<div class="pt-radio-slide">
							<input name="survey_byip" class="tgl tgl-light" id="survey_byip" type="checkbox"/>
							<label class="tgl-btn" for="survey_byip"></label> <b><?=$lang['new']['ip']?></b>
						</div>

					</div>


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
								<input type="text" name="survey_welcome_h" data-change="s0" placeholder="<?=$lang['new']['wp_h']?>">
								<textarea name="survey_welcome_t" id="wysibb-editor"></textarea>
								<input type="text" name="survey_welcome_b" placeholder="<?=$lang['new']['wp_btn']?>">
								<input type="text" name="survey_welcome_bi" class="my" placeholder="<?=$lang['new']['wp_icon']?>">
							</div>
						</div>
					</div>


			  </div><!-- End Welcome Tab -->
			  <div class="tab-pane fade" id="thank" role="tabpanel" aria-labelledby="thank-tab">

					<div class="pt-welcome-step" data-step="thank">
						<h4><?=$lang['new']['tx']?></h4>
						<div class="pt-new-question-content">
							<div class="pt-question-inp">
								<input type="text" name="survey_thank_h" data-change="stu" placeholder="<?=$lang['new']['tx_h']?>">
								<textarea name="survey_thank_t" id="wysibb-editor1"></textarea>
								<input type="text" name="survey_thank_b" placeholder="<?=$lang['new']['tx_btn']?>">
								<input type="text" name="survey_thank_bi" class="my" placeholder="<?=$lang['new']['tx_icon']?>">
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
								<input type="radio" name="button_shadow" id="sradio1" value="0" class="choice" checked>
								<label for="sradio1"><?=$lang['new']['design_yes']?></label>
							</div>
							<div class="form-group">
								<input type="radio" name="button_shadow" id="sradio2" value="1" class="choice">
								<label for="sradio2"><?=$lang['new']['design_no']?></label>
							</div>
						</div>
						<div class="form-inline">
							<div class="form-group">
								<label for="sradio1ss"><?=$lang['new']['design_bb']?> </label>
							</div>
							<div class="form-group">
								<label><?=$lang['new']['design_si']?> </label>
								<input type="number" value="0" min="0" max="9"name="button_border_size">
							</div>
							<div class="form-group">
								<label><?=$lang['new']['design_s']?> </label>
								<select name="button_border_style">
									<option value="none">None</option>
									<option value="solid">Solid</option>
									<option value="dotted">Dotted</option>
									<option value="dashed">Dashed</option>
								</select>
							</div>
							<div class="form-group">
								<label><?=$lang['new']['design_c']?>: </label>
								<input type="text" name="button_border_color" id="colorpicker-popup" placeholder="type the category bg color">
								<input type="hidden" name="pg_bg_v">
							</div>
						</div>
						<div class="form-inline">
							<div class="form-group">
								<label for="sradio1ss"><?=$lang['new']['design_btg']?> </label>
							</div>
							<div class="form-group">
								<div class="form-group">
									<input type="radio" name="bg_gradient" id="sradio12" value="0" class="choice" checked>
									<label for="sradio12"><?=$lang['new']['design_g']?></label>
								</div>
								<div class="form-group">
									<input type="radio" name="bg_gradient" id="sradio22" value="1" class="choice">
									<label for="sradio22"><?=$lang['new']['design_n']?></label>
								</div>
							</div>
							<div class="form-group">
								<label><?=$lang['new']['design_c']?>1: </label>
								<input type="text" name="bg_color1" class="colorpicker-popup">
								<input type="hidden" name="bg_v1">
							</div>
							<div class="form-group">
								<label><?=$lang['new']['design_c']?>2: </label>
								<input type="text" name="bg_color2" class="colorpicker-popup">
								<input type="hidden" name="bg_v2">
							</div>
								<div class="bg-sty"></div>
							</div>
							<div class="form-inline">
								<div class="form-group">
									<label for="sradio1ss"><?=$lang['new']['design_btc']?> </label>
								</div>
								<div class="form-group">
									<input type="text" name="txt_color" class="colorpicker-popup">
									<input type="hidden" name="txt_v">
								</div>
							</div>

							<div class="form-inline">
								<div class="form-group">
									<label for="sradio1ss"><?=$lang['new']['design_sbg']?> </label>
								</div>
								<div class="form-group">
									<input type="text" name="survey_bg" class="colorpicker-popup">
									<input type="hidden" name="sbg_v">
								</div>
							</div>
							<div class="form-inline">
								<div class="form-group">
									<label for="sradio1ss"><?=$lang['new']['design_stbg']?> </label>
								</div>
								<div class="form-group">
									<input type="text" name="step_bg" class="colorpicker-popup">
									<input type="hidden" name="stbg_v">
								</div>
							</div>
							<div class="form-inline">
								<div class="form-group">
									<label for="sradio1ss"><?=$lang['new']['design_ibg']?> </label>
								</div>
								<div class="form-group">
									<input type="text" name="input_bg" class="colorpicker-popup">
									<input type="hidden" name="inpbg_v">
								</div>
							</div>


					</div>
				</div><!-- End Design Tab -->
				<?php endif; ?>
			</div>
		</div>
		<div class="col-6">
			<div class="pt-surveybg">
			<input type="hidden" name="survey_code" value="<?=sc_pass(time() + 1)?>" />
			<div class="pt-survey">
				<div class="pt-dots pt-lines">
					<a href="#"><i class="fas fa-angle-left"></i></a>
					<a class="active"></a>
					<a class="active"><span class="show"><?=ceil(2 *100 / (5+2))?>%</span></a>
					<a></a>
					<a href="#"><i class="fas fa-angle-right"></i></a>
				</div>
				<h3 data-link="s0_title"></h3>
				<div class="textarea-welcome"></div>
				<div class="pt-link">
					<button class="fancy-button bg-gradient1 step-link" disabled>
						<span><b class="survey_welcome_b"></b> <i class="far fa-arrow-alt-circle-right" rel="survey_welcome_bi"></i></span>
					</button>
				</div>
			</div>
			<div class="pt-new-survey-change">

			</div>
			<div class="pt-survey">
				<h3 data-link="stu_title"></h3>
				<div class="textarea-thank"></div>
				<div class="pt-link">
					<button class="fancy-button bg-gradient1 step-link" disabled>
						<span><b class="survey_thank_b"></b> <i class="far fa-arrow-alt-circle-right" rel="survey_thank_bi"></i></span>
					</button>
				</div>
			</div>
			<style rel="inp"></style>
			<style rel="stp"></style>
		</div>
		</div>
	</div>

</div>
</form>

<?php
include __DIR__."/footer.php";
?>
