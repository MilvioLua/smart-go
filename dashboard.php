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

include __DIR__."/head.php";

if(us_level == 6):
?>
<link rel="stylesheet" href="<?=path?>/css/scroll.css">
<div class="pt-wrapper">
	<div class="pt-admin-nav">
		<div class="pt-logo"><i class="fas fa-fire"></i></div>
		<ul>
			<li><a href="<?=path?>/index.php"><i class="fas fa-home"></i><b></b></a></li>
			<li<?=($pg==""?' class="pt-active"':'')?>><a href="<?=path?>/dashboard.php"><i class="fas fa-tachometer-alt"></i><b></b></a></li>
			<li<?=($pg=="users"?' class="pt-active"':'')?>><a href="<?=path?>/dashboard.php?pg=users"><i class="fas fa-users"></i><b></b></a></li>
			<li<?=($pg=="surveys"?' class="pt-active"':'')?>><a href="<?=path?>/dashboard.php?pg=surveys"><i class="fas fa-poll"></i><b></b></a></li>
			<li<?=($pg=="plans"?' class="pt-active"':'')?>><a href="<?=path?>/dashboard.php?pg=plans"><i class="fas fa-puzzle-piece"></i><b></b></a></li>
			<li<?=($pg=="payments"?' class="pt-active"':'')?>><a href="<?=path?>/dashboard.php?pg=payments"><i class="fas fa-dollar-sign"></i><b></b></a></li>
			<li<?=($pg=="setting"?' class="pt-active"':'')?>><a href="<?=path?>/dashboard.php?pg=setting"><i class="fas fa-cogs"></i><b></b></a></li>
			<li><a href="#" class="pt-logout"><i class="fas fa-power-off"></i><b></b></a></li>
		</ul>
	</div>
	<div class="pt-admin-body">
		<div class="pt-welcome">
			<h3><?=$lang['dashboard']['hello']?> <?=us_username?>!</h3>
			<p><?=$lang['dashboard']['welcome']?></p>
			<span><i class="fas fa-chart-line"></i></span>
		</div>
		<div class="pt-stats">
			<ul>
				<li><span><i class="fas fa-poll"></i></span><b><?=$lang['dashboard']['surveys']?></b> <em><?=db_rows("survies")?></em></li>
				<li><span><i class="fas fa-users"></i></span><b><?=$lang['dashboard']['users']?></b> <em><?=db_rows("users")?></em></li>
				<li><span><i class="fas fa-hand-holding-heart"></i></span><b><?=$lang['dashboard']['responses']?></b> <em><?=db_rows("responses")?></em></li>
				<li><span><i class="far fa-question-circle"></i></span><b><?=$lang['dashboard']['questions']?></b> <em><?=db_rows("questions")?></em></li>
			</ul>
		</div>



		<?php if(!$pg): ?>
		<div class="row">
			<div class="col-6">
				<div class="pt-charts">
					<div class="pt-adminstatslinks pt-adminlines">
						<a href="#daily" rel="1"><?=$lang['rapports']['days']?></a>
						<a href="#monthly" rel="1"><?=$lang['rapports']['months']?></a>
					</div>
					<div class="pt-adminstats">
						<canvas id="line-chart" width="800" height="450"></canvas>
					</div>
				</div>
			</div>
			<div class="col-6">
				<div class="pt-charts">
					<div class="pt-adminstatslinks pt-adminbars">
						<a href="#daily" rel="1"><?=$lang['rapports']['days']?></a>
						<a href="#monthly" rel="1"><?=$lang['rapports']['months']?></a>
					</div>
					<div class="pt-adminstats">
						<canvas id="bar-chart" width="800" height="450"></canvas>
					</div>

				</div>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<div class="pt-admin-box">
					<h5><i class="far fa-user"></i> <?=$lang['dashboard']['new_u']?></h5>
					<div class="pt-content pt-scroll">
						<ul>
							<?php
							$sql = $db->query("SELECT * FROM ".prefix."users WHERE date >= '".(time() - 3600*24)."' ORDER BY id DESC") or die ($db->error);
							if($sql->num_rows):
							while($rs = $sql->fetch_assoc()):
							?>
							<li>
								<div class="media">
									<div class="media-left">
										<div class="pt-thumb"><img src="<?=$rs['photo']?>" onerror="this.src='<?=nophoto?>'" /></div>
									</div>
									<div class="media-body">
										<?=fh_user($rs['id'])?>
										<p>
											<span><i class="far fa-clock"></i> <?=fh_ago($rs['date'])?></span>
											<span><i class="fas fa-poll"></i> <?=db_rows("survies WHERE author = '{$rs['id']}'")?> <?=$lang['dashboard']['surveys']?></span>
										</p>
									</div>
								</div>
							</li>
							<?php
							endwhile;
							else:
								echo '<li>'.fh_alerts($lang['alerts']['no-data'], "info").'</li>';
							endif;
							$sql->close();
							?>
						</ul>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="pt-admin-box">
					<h5><i class="fas fa-money-bill-wave"></i> <?=$lang['dashboard']['new_p']?></h5>
					<div class="pt-content">
						<ul>
							<?php
							$sql = $db->query("SELECT * FROM ".prefix."payments WHERE date >= '".(time() - 3600*24)."' ORDER BY id DESC") or die ($db->error);
							if($sql->num_rows):
							while($rs = $sql->fetch_assoc()):
							?>
							<li>
								<div class="media">
									<div class="media-left">
										<div class="pt-thumb"><img src="<?=db_get("users", "photo", $rs['author'])?>" onerror="this.src='<?=nophoto?>'" /></div>
									</div>
									<div class="media-body">
										<?=fh_user($rs['author'])?>
										<p>
											<span><i class="far fa-clock"></i> <?=fh_ago($rs['date'])?></span>
											<span class="pt-plan-badg <?=( $rs['plan']=='Plan#1' ? 'p1' : ( $rs['plan']=='Plan#2' ? 'p2' : ( $rs['plan']=='Plan#3' ? 'p3' : '')))?>">
												<?=$rs['plan']?>
											</span>
											<span><i class="fas fa-comment-dollar"></i> $<?=$rs['price']?></span>
										</p>
									</div>
								</div>
							</li>
							<?php
							endwhile;
							else:
								echo '<li>'.fh_alerts($lang['alerts']['no-data'], "info").'</li>';
							endif;
							$sql->close();
							?>
						</ul>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="pt-admin-box">
					<h5><i class="fas fa-poll"></i> <?=$lang['dashboard']['new_s']?></h5>
					<div class="pt-content pt-scroll">
						<ul>
							<?php
							$sql = $db->query("SELECT * FROM ".prefix."survies WHERE date >= '".(time() - 3600*24)."' ORDER BY id DESC") or die ($db->error);
							if($sql->num_rows):
							while($rs = $sql->fetch_assoc()):
							?>
							<li>
								<a href="<?=path?>/survey.php?id=<?=$rs['id']?>"><?=$rs['title']?></a>
								<p>
									<span><i class="far fa-user"></i> <?=fh_user($rs['author'])?></span>
									<span><i class="far fa-clock"></i> <?=fh_ago($rs['date'])?></span>
									<span><i class="far fa-eye"></i> <?=$rs['views']?> </span>
									<span><i class="fas fa-reply"></i> <?=db_rows("responses WHERE survey = '{$rs['id']}' GROUP BY ip")?></span>
								</p>
							</li>
							<?php
							endwhile;
							else:
								echo '<li>'.fh_alerts($lang['alerts']['no-data'], "info").'</li>';
							endif;
							$sql->close();
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>





	<?php elseif($pg == "plans"): ?>
		<div class="pt-plans">
			<form class="pt-sendplans">
				<div class="pt-body mb-3">
						<input class="tgl tgl-light" id="cb1" value="1" name="site_plans" type="checkbox"<?=(site_plans ? ' checked' : '')?>/>
						<label class="tgl-btn" for="cb1"></label>
						<label>Desactivates plans option</label>
				</div>
				<div class="row">
					<?php
					$sql = $db->query("SELECT * FROM ".prefix."plans");
					while($rs = $sql->fetch_assoc()):
					?>
			    <div class="col-3">
						<div class="pt-body">
						<?php foreach ($rs as $key => $value): ?>
							<?php if(!in_array($key, ['id', 'created_at', 'surveys_rapport', 'surveys_export', 'surveys_iframe', 'show_ads', 'survey_design', 'support'])): ?>
							<label> <?php if(in_array($key, ['surveys_month', 'surveys_steps', 'surveys_questions', 'surveys_answers'])): ?><b><?=str_replace('_',' ',$key)?></b> <?php endif;?>
								<input type="text" name="<?=$key?>[<?=$rs['id']?>]" placeholder="plan <?=$key?>" value="<?=$value?>">
							</label>
							<?php endif;?>
							<?php if(in_array($key, ['surveys_rapport', 'surveys_export', 'surveys_iframe', 'show_ads', 'survey_design', 'support'])): ?>
								<div class="mb-3">
									<input class="tgl tgl-light" id="<?=$key.$rs['id']?>" value="1"type="checkbox" name="<?=$key?>[<?=$rs['id']?>]"<?=($value==1?'checked':'')?>/>
									<label class="tgl-btn" for="<?=$key.$rs['id']?>"></label>
									<label><label><?=str_replace('_',' ',$key)?></label></label>
								</div>

							<?php endif;?>
						<?php endforeach;?>
			    </div>
			    </div>
					<?php
					endwhile;
					$sql->close();
					?>
				</div>
				<div class="pt-link">
					<button type="submit" class="fancy-button bg-gradient5">
						<span><?=$lang['dashboard']['set_btn']?> <i class="fas fa-arrow-circle-right"></i></span>
					</button>
				</div>
		  </form>
		</div>





	<?php elseif($pg == "surveys"): ?>
		<div class="pt-body">
		<div class="pt-title">
			<h3><?=$lang['dashboard']['surveys']?></h3>
			<div class="pt-options">
				<a href="<?=path?>/newsurvey.php" class="pt-btn"><?=$lang['mysurvys']['create']?></a>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th scope="col"><?=$lang['mysurvys']['status']?></th>
						<th scope="col"><?=$lang['mysurvys']['name']?></th>
						<th scope="col"><?=$lang['mysurvys']['views']?></th>
						<th scope="col"><?=$lang['mysurvys']['responses']?></th>
						<th scope="col"><?=$lang['mysurvys']['rate']?></th>
						<th scope="col"><?=$lang['mysurvys']['created']?></th>
						<th scope="col"><?=$lang['mysurvys']['last_r']?></th>
						<th scope="col"></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sql = $db->query("SELECT * FROM ".prefix."survies ORDER BY id DESC LIMIT {$startpoint} , {$limit}") or die ($db->error);
					if($sql->num_rows):
					while($rs = $sql->fetch_assoc()):
						$firststep = db_get("steps", "views", $rs['id'], "survey", "ORDER BY id ASC LIMIT 1");
						$laststep  = db_get("steps", "views", $rs['id'], "survey", "ORDER BY id DESC LIMIT 1");
						$pourcent  = $firststep ? ceil(($laststep/$firststep)*100) : '--';
						$lastresp  = db_get("responses", "date", $rs['id'], "survey", "ORDER BY id DESC LIMIT 1");
					?>
					<tr>
						<th scope="row" class="pt-status">
							<input class="tgl tgl-light" id="cb<?=$rs['id']?>" value="<?=$rs['id']?>" type="checkbox"<?=($rs['status'] ? ' checked' : '')?>/>
							<label class="tgl-btn" for="cb<?=$rs['id']?>"></label>
						</th>
						<td>
							<div class="media">
								<div class="media-left">
									<div class="pt-thumb"><img src="<?=db_get("users", "photo", $rs['author'])?>" onerror="this.src='<?=nophoto?>'" title="<?=fh_user($rs['author'], false)?>" /></div>
								</div>
								<div class="media-body">
									<a href="<?=path?>/survey.php?id=<?=$rs['id']?>"><?=$rs['title']?></a>
								</div>
							</div>
						</td>
						<td><?=$rs['views']?></td>
						<td><?=db_rows("responses WHERE survey = '{$rs['id']}' GROUP BY ip ORDER BY id DESC")?></td>
						<td class="pt-progress">
							<span><?=$pourcent?>%</span>
							<span class="pt-progress-line"><span style="width: <?=str_replace('--', '0', $pourcent)?>%"></span></span>
						</td>
						<td><?=fh_ago($rs['date'])?></td>
						<td><?=($lastresp?fh_ago($lastresp):'--')?></td>
						<td class="pt-options">
							<a class="pt-options-link"><i class="fas fa-ellipsis-h"></i></a>
							<ul class="pt-drop">
								<li><a href="<?=path?>/survey.php?id=<?=$rs['id']?>&request=su"><i class="fas fa-eye"></i> <?=$lang['mysurvys']['op_view']?></a></li>
								<li><a href="<?=path?>/rapport.php?id=<?=$rs['id']?>"><i class="fas fa-poll"></i> <?=$lang['mysurvys']['op_stats']?></a></li>
								<?php if(fh_access("iframe")): ?>
								<li><a data-toggle="modal" href="#embedModal<?=$rs['id']?>"><i class="fas fa-share-square"></i> <?=$lang['mysurvys']['op_embed']?></a></li>
								<?php endif; ?>
								<li><a href="<?=path?>/responses.php?id=<?=$rs['id']?>"><i class="far fa-address-card"></i> <?=$lang['mysurvys']['op_resp']?></a></li>
								<li><a href="#sendModal" rel="<?=$rs['id']?>" data-toggle="modal" class="sendtoemail"><i class="far fa-envelope"></i> <?=$lang['mysurvys']['op_send']?></a></li>
								<li><a href="<?=path?>/editsurvey.php?id=<?=$rs['id']?>"><i class="far fa-edit"></i> <?=$lang['mysurvys']['op_edit']?></a></li>
								<li><a href="#" class="pt-delete-survey" rel="<?=$rs['id']?>"><i class="fas fa-trash-alt"></i> <?=$lang['mysurvys']['op_delete']?></a></li>
							</ul>
							<?php if(fh_access("iframe")): ?>
							<div class="modal fade" id="embedModal<?=$rs['id']?>">
								<div class="modal-dialog"><div class="modal-content"><div class="modal-body"><pre class="radius">&lt;iframe src=&quot;<?=path?>/survey.php?id=<?=$rs['id']?>&request=su&quot; style=&quot;width: 460px;height:315px&quot; frameborder=&quot;0&quot;&gt;&lt;/iframe&gt;</pre></div></div></div>
							</div>
							<?php endif; ?>
						</td>
					</tr>
					<?php
					endwhile;
					echo '<tr><td colspan="8">'.fh_pagination("survies",$limit, path."/dashboard.php?pg=surveys&").'</td></tr>';
					else:
						?>
						<tr>
							<td colspan="8">
								<?=fh_alerts($lang['alerts']["no-data"], "info")?>
							</td>
						</tr>
						<?php
					endif;
					$sql->close();
					?>
				</tbody>
			</table>
	</div>
	</div>

	<div class="modal fade" id="sendModal">
	  <div class="modal-dialog">
	    <div class="modal-content">
				<form class="pt-sendsurveyemail">
	      <!-- Modal Header -->
	      <div class="modal-header">
	        <h4 class="modal-title">Send survey</h4>
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	      </div>

	      <!-- Modal body -->
	      <div class="modal-body">
					<div class="mb-3">
						<input type="text" name="subject" value="" placeholder="Subject">
					</div>
					<div class="mb-3">
						<select name="email[]" class="js-example-tokenizer" multiple="multiple">
							<?php
							$sqls = $db->query("SELECT * FROM ".prefix."users");
							while($rss = $sqls->fetch_assoc()):
							?>
							<option value="<?=$rss['email']?>"><?=$rss['email']?></option>
							<?php
							endwhile;
							$sqls->close();
							?>
						</select>
					</div>
					<div class="">
						<textarea name="message" id="wysibb-editor3">[img width=244 height=58]http://puertokhalid.com/puertosurveys/dv/img/logo-c.png[/img]
[hr]
[color=#666666][size=3]Hi,[/size][/color]
[color=#666666][size=3][font=Arial, Helvetica, sans-serif]We are happy to send you this survey to give us your honest opinion about [/font][/size][/color][b][color=#666666][size=3][font=Arial, Helvetica, sans-serif]{title}.[/font][/size][/color][/b]

[color=#666666][size=3][font=Arial, Helvetica, sans-serif]{button bg=#4CAF50}Start the survey[/font][/size][/color][color=#666666][color=#666666][size=3][font=Arial, Helvetica, sans-serif][size=3][font=Arial, Helvetica, sans-serif]{/button}[/font][/size][/font][/size][/color][/color]

[color=#abadae][size=2][font=Arial, Helvetica, sans-serif]© Puerto Premium Survey Builder 2020[/font][/size][/color]</textarea>
					</div>
	      </div>

	      <!-- Modal footer -->
	      <div class="modal-footer">
					<input type="hidden" name="id" value="">
	        <button type="submit" class="btn btn-danger">Send</button>
	      </div>

				</form>

	    </div>
	  </div>
	</div>

	<?php elseif($pg == "users"): ?>
		<div class="pt-body">
		<div class="pt-title">
			<h3><?=$lang['dashboard']['u_users']?></h3>
		</div>
		<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th scope="col"><?=$lang['dashboard']['u_status']?></th>
					<th scope="col"><?=$lang['dashboard']['u_username']?></th>
					<th scope="col"><?=$lang['dashboard']['u_plan']?></th>
					<th scope="col"><?=$lang['dashboard']['u_credits']?></th>
					<th scope="col"><?=$lang['dashboard']['u_last_p']?></th>
					<th scope="col"><?=$lang['dashboard']['u_registred']?></th>
					<th scope="col"><?=$lang['dashboard']['u_updated']?></th>
					<th scope="col"></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$sql = $db->query("SELECT * FROM ".prefix."users ORDER BY id DESC LIMIT {$startpoint} , {$limit}") or die ($db->error);
				if($sql->num_rows):
				while($rs = $sql->fetch_assoc()):
				?>
				<tr>
					<th scope="row" class="pt-status pt-userstatus">
						<input class="tgl tgl-light" id="cb<?=$rs['id']?>" value="<?=$rs['id']?>" type="checkbox"<?=($rs['moderat'] ? ' checked' : '')?>/>
						<label class="tgl-btn" for="cb<?=$rs['id']?>"></label>
					</th>
					<td>
						<div class="pt-thumb">
							<img src="<?=($rs['photo'] ? $rs['photo'] : nophoto)?>" onerror="this.src='<?=nophoto?>'" />
						</div>
						<a href="#"><?=$rs['username']?></a>
					</td>
					<td>
						<span class="pt-plan-badg <?=( $rs['plan']=='1' ? 'p1' : ( $rs['plan']=='2' ? 'p2' : ( $rs['plan']=='3' ? 'p3' : '')))?>">
							<?=($rs['plan']?'Plan#'.$rs['plan']:'--')?>
						</span>
					</td>
					<td><?=($rs['credits']?"$".$rs['credits']:'--')?></td>
					<td><?=($rs['lastpayment']?fh_ago($rs['lastpayment']):'--')?></td>
					<td><?=fh_ago($rs['date'])?></td>
					<td><?=($rs['updated_at']?fh_ago($rs['updated_at']):'--')?></td>
					<td class="pt-options">
						<a class="pt-options-link"><i class="fas fa-ellipsis-h"></i></a>
						<ul class="pt-drop">
							<li><a href="<?=path?>/userdetails.php?id=<?=$rs['id']?>"><i class="far fa-edit"></i> <?=$lang['dashboard']['u_edit']?></a></li>
							<li><a href="#" class="pt-delete-user" rel="<?=$rs['id']?>"><i class="fas fa-trash-alt"></i> <?=$lang['dashboard']['u_delete']?></a></li>
						</ul>
					</td>
				</tr>
				<?php
				endwhile;
				echo '<tr><td colspan="8">'.fh_pagination("users",$limit, path."/dashboard.php?pg=users&").'</td></tr>';
				else:
					?>
					<tr>
						<td colspan="8">
							<?=fh_alerts($lang['alerts']["no-data"], "info")?>
						</td>
					</tr>
					<?php
				endif;
				$sql->close();
				?>
			</tbody>
		</table>
		</div>
		</div>


	<?php elseif($pg == "payments"): ?>
		<div class="pt-body">
		<div class="pt-title">
			<h3><?=$lang['dashboard']['p_title']?></h3>
		</div>
		<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th scope="col"><?=$lang['dashboard']['p_user']?></th>
					<th scope="col"><?=$lang['dashboard']['p_status']?></th>
					<th scope="col"><?=$lang['dashboard']['p_plan']?></th>
					<th scope="col"><?=$lang['dashboard']['p_amount']?></th>
					<th scope="col"><?=$lang['dashboard']['p_date']?></th>
					<th scope="col"><?=$lang['dashboard']['p_txn']?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$sql = $db->query("SELECT * FROM ".prefix."payments ORDER BY id DESC LIMIT {$startpoint} , {$limit}") or die ($db->error);
				if($sql->num_rows):
				while($rs = $sql->fetch_assoc()):
				?>
				<tr>
					<th scope="row">

						<div class="pt-thumb">
							<img src="<?=db_get("users", "photo", $rs['author'])?>" title="<?=fh_user($rs['author'], false)?>" onerror="this.src='<?=nophoto?>'" />
						</div>
						<a href="#"><?=fh_user($rs['author'])?></a>
					</th>
					<td>
						<?=$rs['status']?>
					</td>
					<td>
						<span class="pt-plan-badg <?=( $rs['plan']=='Plan#1' ? 'p1' : ( $rs['plan']=='Plan#2' ? 'p2' : ( $rs['plan']=='Plan#3' ? 'p3' : '')))?>">
							<?=$rs['plan']?>
						</span>
					</td>
					<td>$<?=$rs['price']?></td>
					<td><?=fh_ago($rs['date'])?></td>
					<td><?=$rs['txn_id']?></td>
				</tr>
				<?php
				endwhile;
				echo '<tr><td colspan="8">'.fh_pagination("payments",$limit, path."/dashboard.php?pg=payments&").'</td></tr>';
				else:
					?>
					<tr>
						<td colspan="8">
							<?=fh_alerts($lang['alerts']["no-data"], "info")?>
						</td>
					</tr>
					<?php
				endif;
				$sql->close();
				?>
			</tbody>
		</table>
		</div>
		</div>


		<?php elseif($pg == "setting"): ?>
			<div class="pt-body">
				<div class="pt-title">
					<h3><?=$lang['dashboard']['set_title']?></h3>
				</div>
				<form class="pt-sendsettings">
				<div class="pt-admin-setting">
					<div class="form-group">
						<label><?=$lang['dashboard']['set_stitle']?></label>
						<input type="text" name="site_title" value="<?=site_title?>">
					</div>
					<div class="form-group">
						<label><?=$lang['dashboard']['set_keys']?></label>
						<input type="text" name="site_keywords" value="<?=site_keywords?>">
					</div>
					<div class="form-group">
						<label><?=$lang['dashboard']['set_desc']?></label>
						<textarea name="site_description"><?=site_description?></textarea>
					</div>
					<div class="form-group">
						<label><?=$lang['dashboard']['set_url']?></label>
						<input type="text" name="site_url" value="<?=site_url?>">
					</div>

					<div class="form-group">
						<label><?=$lang['dashboard']['set_noreply']?></label>
						<input type="text" name="site_noreply" value="<?=site_noreply?>">
					</div>
					<div class="form-group">
						<input class="tgl tgl-light" id="cb1" value="1" name="site_register" type="checkbox"<?=(site_register ? ' checked' : '')?>/>
						<label class="tgl-btn" for="cb1"></label>
						<label><?=$lang['dashboard']['set_register']?></label>
					</div>

					<h3 class="cp-form-title">Facebook login</h3>
					<div class="form-group">
						<input class="tgl tgl-light" id="cb2" value="1" name="login_facebook" type="checkbox"<?=(login_facebook ? ' checked' : '')?>/>
						<label class="tgl-btn" for="cb2"></label>
						<label>Facebook Login</label>
					</div>
					<div class="form-row">
						<div class="col-5 form-group">
							<label>App id</label>
							<input type="text" name="login_fbAppId" placeholder="Facebook App Id" value="<?=login_fbAppId?>">
						</div>
						<div class="col-5 form-group">
							<label>App secret</label>
							<input type="password" name="login_fbAppSecret" placeholder="Facebook app secret" value="<?=login_fbAppSecret?>">
						</div>
						<div class="col form-group">
							<label>App version</label>
							<input type="text" name="login_fbAppVersion" placeholder="Facebook app version" value="<?=login_fbAppVersion?>">
						</div>
					</div>
					<p><i class="fas fa-exclamation-triangle"></i> The Redirect Url: <b><?=path?>/login-facebook.php</b></p>

					<h3 class="cp-form-title">Twitter login</h3>
					<div class="form-group">
						<input class="tgl tgl-light" id="cb3" value="1" name="login_twitter" type="checkbox"<?=(login_twitter ? ' checked' : '')?>/>
						<label class="tgl-btn" for="cb3"></label>
						<label>Twitter Login</label>
					</div>
					<div class="form-row">
						<div class="col form-group">
							<label>App Key</label>
							<input type="text" name="login_twConKey" placeholder="Twitter App Key" value="<?=login_twConKey?>">
						</div>
						<div class="col form-group">
							<label>App secret</label>
							<input type="password" name="login_twConSecret" placeholder="Twitter App Secret" value="<?=login_twConSecret?>">
						</div>
					</div>
					<p><i class="fas fa-exclamation-triangle"></i> The Redirect Url: <b><?=path?>/login-twitter.php</b></p>

					<h3 class="cp-form-title">Google login</h3>
					<div class="form-group">
						<input class="tgl tgl-light" id="cb4" value="1" name="login_google" type="checkbox"<?=(login_google ? ' checked' : '')?>/>
						<label class="tgl-btn" for="cb4"></label>
						<label>Google Login</label>
					</div>
					<div class="form-row">
						<div class="col form-group">
							<label>Client id</label>
							<input type="text" name="login_ggClientId" placeholder="Google client id" value="<?=login_ggClientId?>">
						</div>
						<div class="col form-group">
							<label>Client secret</label>
							<input type="password" name="login_ggClientSecret" placeholder="Google client Secret" value="<?=login_ggClientSecret?>">
						</div>
					</div>
					<p><i class="fas fa-exclamation-triangle"></i> The Redirect Url: <b><?=path?>/login-google.php</b></p>

					<h3 class="cp-form-title">Paypal</h3>
					<div class="form-group">
						<input class="tgl tgl-light" id="cb5" value="1" name="site_paypal_live" type="checkbox"<?=(site_paypal_live ? ' checked' : '')?>/>
						<label class="tgl-btn" for="cb5"></label>
						<label>Live</label>
					</div>
					<div class="form-row">
						<div class="col-6 form-group">
							<label>Paypal id</label>
							<input type="text" name="site_paypal_id" placeholder="Paypal id" value="<?=site_paypal_id?>">
						</div>
						<div class="col form-group">
							<label>Paypal Currency</label>
							<input type="text" name="site_currency_name" placeholder="Currency name" value="<?=site_currency_name?>">
						</div>
						<div class="col form-group">
							<label>Currency Symbol</label>
							<input type="text" name="site_currency_symbol" placeholder="Currency Symbol" value="<?=site_currency_symbol?>">
						</div>
					</div>

					<h3 class="cp-form-title">PHPMAILER SMTP</h3>
					<div class="form-group">
						<input class="tgl tgl-light" id="cb6" value="1" name="site_smtp" type="checkbox"<?=(site_smtp ? ' checked' : '')?>/>
						<label class="tgl-btn" for="cb6"></label>
						<label>is SMTP</label>
					</div>
					<div class="form-row">
						<div class="col form-group">
							<label>Host</label>
							<input type="password" name="site_smtp_host" placeholder="SMTP Host" value="<?=site_smtp_host?>">
						</div>
						<div class="col form-group">
							<label>Username</label>
							<input type="password" name="site_smtp_username" placeholder="SMTP Username" value="<?=site_smtp_username?>">
						</div>
						<div class="col form-group">
							<label>Password</label>
							<input type="password" name="site_smtp_password" placeholder="SMTP Password" value="<?=site_smtp_password?>">
						</div>
						<div class="col form-group">
							<label>Port</label>
							<input type="text" name="site_smtp_port" placeholder="SMTP Port" value="<?=site_smtp_port?>">
						</div>
						<div class="col form-group">
							<label>Auth</label>
							<select name="site_smtp_auth">
								<option value="0" <?=(site_smtp_auth=='0'?'selected':'')?>>False</option>
								<option value="1" <?=(site_smtp_auth=='1'?'selected':'')?>>True</option>
							</select>
						</div>
						<div class="col form-group">
							<label>Encryption</label>
							<select name="site_smtp_encryption">
								<option value="none" <?=(site_smtp_encryption=='none'?'selected':'')?>>None</option>
								<option value="tls" <?=(site_smtp_encryption=='tls'?'selected':'')?>>TLS</option>
							</select>
						</div>
					</div>


					<div class="pt-link">
						<button type="submit" class="fancy-button bg-gradient5">
							<span><?=$lang['dashboard']['set_btn']?> <i class="fas fa-arrow-circle-right"></i></span>
						</button>
					</div>
				</div>

				</form>
			</div>


		<?php endif; ?>

		<div class="pt-footer">
			<div>
					Copyright © 2020 <a href="#">Puerto Premium Survey</a>. All Rights Reserved.<br>
					Programming and design by <a href="http://puertokhalid.com" target="_blanc">Puerto Khalid</a>.
			</div>
		</div>
	</div>
</div>
<?php
include __DIR__."/scripts.php";
else:
	echo '<meta http-equiv="refresh" content="0;url='.path.'">';
endif;
?>
</body>
</html>
