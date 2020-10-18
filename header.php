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

include __DIR__."/head.php";

if(us_level || (!us_level && in_array(page, ['survey', 'steps', 'login-google', 'login-twitter'])) ):
?>
<div class="pt-wrapper">
	<?php if( in_array(page, ['survey']) && $request == 'su' ): ?>
	<?php else: ?>
	<div class="pt-header">
		<div class="pt-menu">
			<div class="pt-logo"><i class="fas fa-fire"></i></div>
			<div class="pt-links-l">
				<span class="pt-mobile-menu"><i class="fas fa-ellipsis-h"></i></span>
				<ul class="pt-drop">
					<li><a href="<?=path?>/index.php"<?=(page=='index'&&$request!='all'?' class="pt-active"':'')?>><?=$lang['menu']['home']?></a></li>
					<li><a href="<?=path?>/index.php?request=all"<?=(page=='index'&&$request=='all'?' class="pt-active"':'')?>><?=$lang['menu']['forms']?></a></li>
				</ul>
			</div>
			<div class="pt-links-r">
				<ul>
					<?php if( !site_plans ): ?>
					<li><a href="<?=path?>/plans.php"><i class="fas fa-dollar-sign"></i> <?=$lang['menu']['plans']?></a></li>
					<?php endif; ?>
					<li>
						<a href="#" class="pt-user">
							<div class="pt-thumb"><img src="<?=(us_photo ? us_photo : nophoto)?>" onerror="this.src='<?=nophoto?>'" /></div>
							<?=$lang['menu']['welcome']?><?php if(us_level): ?>, <?=us_username?> <i class="fas fa-angle-down"></i><?php endif; ?>
						</a>
						<?php if(us_level): ?>
						<ul class="pt-drop">
							<li><a href="<?=path?>/newsurvey.php"><i class="fas fa-plus"></i> <?=$lang['menu']['new']?></a></li>
							<?php if(us_level == 6): ?>
							<li><a href="<?=path?>/dashboard.php"><i class="fas fa-cogs"></i> <?=$lang['menu']['admin']?></a></li>
							<?php endif; ?>
							<li><a href="<?=path?>/userdetails.php"><i class="fas fa-user-cog"></i> <?=$lang['menu']['info']?></a></li>
							<li><a href="#" class="pt-logout"><i class="fas fa-power-off"></i> <?=$lang['menu']['logout']?></a></li>
						</ul>
						<?php endif; ?>
					</li>
					<?php if(!us_level): ?><li><a href="<?=path?>/index.php" class="pt-btn"><i class="far fa-user"></i> <?=$lang['menu']['signin']?></a></li><?php endif; ?>
				</ul>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<div class="pt-body<?=( in_array(page, ['survey']) && $request == 'su' ? ' pt-suif' : '') ?>">
<?php
else:
	include __DIR__."/login.php";
	exit;
endif;
?>
