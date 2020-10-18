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

$s_where = ($request == 'all' ? "private = 0" : "author = '".us_id."'");
$s_title = ($request == 'all' ? $lang['mysurvys']['alltitle'] : $lang['mysurvys']['title']);
?>

<div class="pt-title">
	<h3><?=$s_title?></h3>
	<div class="pt-options">
		<a href="<?=path?>/newsurvey.php" class="pt-btn"><?=$lang['mysurvys']['create']?></a>
	</div>
</div>

<table class="table">
	<thead>
		<tr>
			<th scope="col"><?=($request != 'all' ? $lang['mysurvys']['status'] : '')?></th>
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
		$sql = $db->query("SELECT * FROM ".prefix."survies WHERE {$s_where} ORDER BY id DESC LIMIT {$startpoint} , {$limit}") or die ($db->error);
		if($sql->num_rows):
		while($rs = $sql->fetch_assoc()):
			$firststep = db_get("steps", "views", $rs['id'], "survey", "ORDER BY id ASC LIMIT 1");
			$laststep  = db_get("steps", "views", $rs['id'], "survey", "ORDER BY id DESC LIMIT 1");
			$pourcent  = $firststep ? ceil(($laststep/$firststep)*100) : '--';
			$lastresp  = db_get("responses", "date", $rs['id'], "survey", "ORDER BY id DESC LIMIT 1");
			$userphoto = db_get("users", "photo", $rs['author']);
		?>
		<tr>
			<?php if($request != 'all'): ?>
			<th scope="row" class="pt-status">
				<input class="tgl tgl-light" id="cb<?=$rs['id']?>" value="<?=$rs['id']?>" type="checkbox"<?=($rs['status'] ? ' checked' : '')?>/>
				<label class="tgl-btn" for="cb<?=$rs['id']?>"></label>
			</th>
			<?php else: ?>
			<th scope="row" class="pt-thumbth">
				<div class="pt-thumb">
					<img src="<?=($userphoto?$userphoto:nophoto)?>" title="<?=fh_user($rs['author'], false)?>" onerror="this.src='<?=nophoto?>'" />
				</div>
			</th>
			<?php endif; ?>
			<td><a href="<?=path?>/survey.php?id=<?=$rs['id']?>"><?=$rs['title']?></a></td>
			<td><?=$rs['views']?></td>
			<td><?=db_rows("responses WHERE survey = '{$rs['id']}' GROUP BY ip", "ip")?></td>
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
					<?php if($request != 'all'): ?>
					<li><a href="<?=path?>/rapport.php?id=<?=$rs['id']?>"><i class="fas fa-poll"></i> <?=$lang['mysurvys']['op_stats']?></a></li>
					<li><a href="<?=path?>/responses.php?id=<?=$rs['id']?>"><i class="far fa-address-card"></i> <?=$lang['mysurvys']['op_resp']?></a></li>
					<?php if(fh_access("iframe")): ?>
					<li><a data-toggle="modal" href="#embedModal<?=$rs['id']?>"><i class="fas fa-share-square"></i> <?=$lang['mysurvys']['op_embed']?></a></li>
					<?php endif; ?>
					<li><a href="#sendModal" rel="<?=$rs['id']?>" data-toggle="modal" class="sendtoemail"><i class="far fa-envelope"></i> <?=$lang['mysurvys']['op_send']?></a></li>
					<li><a href="<?=path?>/editsurvey.php?id=<?=$rs['id']?>"><i class="far fa-edit"></i> <?=$lang['mysurvys']['op_edit']?></a></li>
					<li><a href="#" class="pt-delete-survey" rel="<?=$rs['id']?>"><i class="fas fa-trash-alt"></i> <?=$lang['mysurvys']['op_delete']?></a></li>
					<?php endif; ?>
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
		echo '<tr><td colspan="8">'.fh_pagination("survies WHERE {$s_where}",$limit, path.($request=='all'?"/index.php?request=all&":"/index.php?")).'</td></tr>';
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

<?php
include __DIR__."/footer.php";
?>
