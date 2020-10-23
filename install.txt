<?php
/*=======================================================/
	| Craeted By: Khalid puerto
	| URL: www.puertokhalid.com
	| Facebook: www.facebook.com/prof.puertokhalid
	| Instagram: www.instagram.com/khalidpuerto
	| Whatsapp: +212 654 211 360
 /======================================================*/

include __DIR__.'/configs/connection.php';

?>
<title>Puerto Install</title>
<style>
	body { background: #F7F7F7; }
	.install-box { width:450px;margin:20px auto 0 auto;background: #FFF;font-family:tahoma;font-size:14px;box-shadow:0 0 5px #CCC; }
	.install-box h1 { padding: 24px 20px;margin:0;font-size:18px;color: #555;    border-bottom: 1px solid #F7F7F7; }
	.install-box p { padding:20px;margin:0;color: #777;line-height: 1.6; }
	.install-box ul { padding: 0 20px;font-size: 12px;line-height: 1.4; }
	.install-box .button {font-size:18px;background:#DF4444;color:#FFF;text-decoration:none;display:block;margin-top:20px;text-align:center;padding:10px 0;border-radius: 3px;width: 100%; }
	.input { padding:10px 20px 0px 20px; }
	.input p { padding:0; font-size:12px; }
	label { font-weight:bold; font-size:12px; margin-left:5px; margin-bottom: 6px; color: #555; display:block; }
	input { padding:10px; font-size:12px; border:1px solid #DDD; width:100%;  }
	input[type=submit] { padding:10px; font-size:12px; color:#FFF; border:1px solid #DF4444; background:#DF4444; width:auto;  }
	.p-h, .p-h a {
    inline-block: ;
    padding: 2px 6px;
    background: #EEE;
    border-radius: 3px;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    color: #555;
    text-shadow: 0 1px 0 #FFF;
	}
	ul {
		margin:0 24px
	}
	ul li {
		margin: 6px 0;
	}
	.red {
		color: red;
	}
</style>


<?php

$step = (isset($_GET['step']) ? (int)($_GET['step']) : '');

if($step == ''):

?>
<div class="install-box">
	<form method="post" action="install.php?step=1">

	<h1>Welcome to Puerto Premium Survey</h1>
	<p>
	Thank you for purchasing Puerto Premium Survey Script.<br> if you have any problem or issue with the script or the instraction that I provide please contact me first ASAP in:
	</p>
	<ul>
		<li>my Email: <span class="p-h">el.bouirtou@gmail.com</span></li>
		<li>my Facebook account <span class="p-h"><a href="https://fb.com/prof.puertokhalid">fb.com/prof.puertokhalid</a></span></li>
		<li>on the Instagram <span class="p-h"><a href="https://instagram.com/khalidpuerto">instagram.com/khalidpuerto</a></span></li>
		<li>Codecanyon profile <span class="p-h"><a href="http://codecanyon.net/user/puertokhalid">codecanyon.net/user/puertokhalid</a></span></li>
	</ul>
	<p>
	 and I will back to you with all help you need.<br>
	 Thanks so much!<br><br />
	 For start Installing the script fill the feilds bellow and Click in the install buttom:<br /><br />

	<label>Admin Username</label><input type="text" name="admin" />
	<label>Admin Password:</label><input type="password" name="password" />
	<label>Admin Email:</label><input type="text" name="email" />
	<button type="submit" class="button">Install Puerto Script</button>
	</p>
		</form>
</div>





<?php

else:

	$admin = (isset($_POST['admin']) ? mysqli_real_escape_string($db, $_POST['admin']): '');
	$pass = (isset($_POST['password']) ?mysqli_real_escape_string($db, $_POST['password']): '');
	$email = (isset($_POST['email']) ?mysqli_real_escape_string($db, $_POST['email']): '');


	if(!$admin || !$pass || !$email){
		die('Please fill all the infos! <meta http-equiv="refresh" content="3;url=install.php">');
	}

	function sc_pass($data) {
		return sha1($data);
	}

$db->query("
CREATE TABLE `".prefix."answers` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  `author` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `survey` int(11) unsigned NOT NULL DEFAULT '0',
  `step` int(11) unsigned NOT NULL DEFAULT '0',
  `question` int(11) unsigned NOT NULL DEFAULT '0',
  `type` varchar(50) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `responses` smallint(5) unsigned NOT NULL DEFAULT '0',
  `lastresponse` int(10) unsigned NOT NULL DEFAULT '0',
  `code` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
");

$db->query("
CREATE TABLE `".prefix."configs` (
  `id` tinyint(3) unsigned NOT NULL,
  `variable` varchar(255) DEFAULT NULL,
  `value` text
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
");


$db->query("
INSERT INTO `".prefix."configs` (`id`, `variable`, `value`) VALUES
(1, 'site_title', 'Puerto Premium Survey'),
(2, 'site_url', 'puertokhalid.com'),
(3, 'site_description', 'Creating surveys and polls should be simple and fast.\r\nYou have things to get done. You need info to do them well. Puerto Premium Survey is the way to a survey or poll in minutes. A simple tool, but surprisingly powerful.'),
(4, 'site_keywords', 'survey, vote, poll, voting, puerto, surveys, puerto survey, codecanyon, php script'),
(5, 'site_author', 'Puerto Khalid'),
(6, 'site_register', '1'),
(7, 'site_plans', '0');
");




$db->query("
CREATE TABLE `".prefix."payments` (
  `id` int(11) NOT NULL,
  `plan` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `txn_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `price` float(10,2) NOT NULL,
  `currency` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date` int(11) NOT NULL DEFAULT '0',
  `author` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
");


$db->query("
CREATE TABLE `".prefix."questions` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  `author` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `survey` int(11) unsigned NOT NULL DEFAULT '0',
  `step` int(11) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `inline` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `votes` int(10) unsigned NOT NULL DEFAULT '0',
  `responses` smallint(5) unsigned NOT NULL DEFAULT '0',
  `lastresponse` int(10) unsigned NOT NULL DEFAULT '0',
  `code` varchar(255) DEFAULT NULL,
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
");


$db->query("
CREATE TABLE `".prefix."responses` (
  `id` int(11) NOT NULL,
  `response` varchar(255) DEFAULT NULL,
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  `author` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `survey` int(11) unsigned NOT NULL DEFAULT '0',
  `step` int(11) unsigned NOT NULL DEFAULT '0',
  `question` int(11) unsigned NOT NULL DEFAULT '0',
  `answer` int(11) DEFAULT '0',
  `ip` varchar(255) DEFAULT NULL,
  `os` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `device` varchar(255) DEFAULT NULL,
  `cook` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
");


$db->query("
CREATE TABLE `".prefix."steps` (
  `id` int(11) NOT NULL,
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  `author` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `survey` int(11) unsigned NOT NULL DEFAULT '0',
  `views` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `code` varchar(255) DEFAULT NULL,
  `sort` mediumint(8) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
");


$db->query("
CREATE TABLE `".prefix."survies` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  `author` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `views` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `responses` smallint(5) unsigned NOT NULL DEFAULT '0',
  `lastresponse` int(10) unsigned NOT NULL DEFAULT '0',
  `enddate` int(10) unsigned NOT NULL DEFAULT '0',
  `code` varchar(255) DEFAULT NULL,
  `welcome_head` varchar(255) DEFAULT NULL,
  `welcome_text` mediumtext,
  `welcome_btn` varchar(255) DEFAULT NULL,
  `welcome_icon` varchar(255) DEFAULT NULL,
  `thanks_head` varchar(255) DEFAULT NULL,
  `thanks_text` mediumtext,
  `thanks_btn` varchar(255) DEFAULT NULL,
  `thanks_icon` varchar(255) DEFAULT NULL,
  `startdate` int(10) unsigned NOT NULL DEFAULT '0',
  `private` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `byip` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `url` varchar(255) DEFAULT NULL,
  `button_shadow` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `button_border_size` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `button_border_style` varchar(7) DEFAULT NULL,
  `button_border_color` varchar(7) DEFAULT NULL,
  `bg_gradient` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `bg_color1` varchar(7) DEFAULT NULL,
  `bg_color2` varchar(7) DEFAULT NULL,
  `txt_color` varchar(7) DEFAULT NULL,
  `survey_bg` varchar(7) DEFAULT NULL,
  `input_bg` varchar(7) DEFAULT NULL,
  `step_bg` varchar(7) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
");



$db->query("
CREATE TABLE `".prefix."users` (
  `id` int(10) NOT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `date` int(11) NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `email` varchar(255) DEFAULT NULL,
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `address` text,
  `birth` varchar(255) DEFAULT NULL,
  `moderat` varchar(255) DEFAULT NULL,
  `verified` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `credits` float unsigned DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `language` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0',
  `trash` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `plan` tinyint(1) DEFAULT '0',
  `lastpayment` int(11) DEFAULT NULL,
  `txn_id` varchar(50) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
");


$db->query("
ALTER TABLE `".prefix."answers` ADD PRIMARY KEY (`id`);
");
$db->query("
ALTER TABLE `".prefix."configs` ADD PRIMARY KEY (`id`);
");
$db->query("
ALTER TABLE `".prefix."payments` ADD PRIMARY KEY (`id`);
");
$db->query("
ALTER TABLE `".prefix."questions` ADD PRIMARY KEY (`id`);
");
$db->query("
ALTER TABLE `".prefix."responses` DD PRIMARY KEY (`id`);
");
$db->query("
ALTER TABLE `".prefix."steps` ADD PRIMARY KEY (`id`);
");
$db->query("
ALTER TABLE `".prefix."survies` ADD PRIMARY KEY (`id`);
");
$db->query("
ALTER TABLE `".prefix."users` ADD PRIMARY KEY (`id`);
");

$db->query("
	ALTER TABLE `".prefix."answers` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
	");
$db->query("
	ALTER TABLE `".prefix."configs` MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
	");
$db->query("
	ALTER TABLE `".prefix."payments` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
	");
$db->query("
	ALTER TABLE `".prefix."questions` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
	");
$db->query("
	ALTER TABLE `".prefix."responses` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
	");
$db->query("
	ALTER TABLE `".prefix."steps` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
	");
$db->query("
	ALTER TABLE `".prefix."survies` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
	");
$db->query("
	ALTER TABLE `".prefix."users` MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
	");



$db->query("
	INSERT INTO `".prefix."users` (`firstname`, `lastname`, `username`, `password`, `photo`, `date`, `level`, `email`, `gender`, `address`, `birth`, `moderat`, `verified`, `credits`, `description`, `language`, `updated_at`, `trash`, `plan`, `lastpayment`, `txn_id`, `country`, `state`, `city`) VALUES
	('', '', '{$admin}', '".sc_pass($pass)."', '', '".time()."', 6, '{$email}', 0, '', '', '', 0, 0, '', 0, 0, 0, 0, '', '', '', '', '');
");






// v1.1

$db->query("
DROP TABLE `".prefix."plans` ;
");

$db->query("
CREATE TABLE `".prefix."plans` (
  `id` int(11) NOT NULL,
  `plan` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` float(10,2) DEFAULT NULL,
  `currency` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `desc1` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `desc2` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `desc3` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `desc4` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `desc5` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `desc6` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `desc7` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `desc8` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `desc9` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT '0',
  `surveys_month` int(11) DEFAULT '0',
  `surveys_steps` int(11) DEFAULT '0',
  `surveys_questions` int(11) DEFAULT '0',
  `surveys_answers` int(11) DEFAULT '0',
  `surveys_iframe` tinyint(1) DEFAULT '0',
  `surveys_rapport` tinyint(1) DEFAULT '0',
  `surveys_export` tinyint(1) DEFAULT '0',
  `survey_design` tinyint(1) DEFAULT '0',
  `show_ads` tinyint(1) DEFAULT '0',
  `support` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
");


$db->query("
INSERT INTO `".prefix."plans` (`id`, `plan`, `price`, `currency`, `desc1`, `desc2`, `desc3`, `desc4`, `desc5`, `desc6`, `desc7`, `desc8`, `desc9`, `created_at`, `surveys_month`, `surveys_steps`, `surveys_questions`, `surveys_answers`, `surveys_iframe`, `surveys_rapport`, `surveys_export`, `survey_design`, `show_ads`, `support`) VALUES
(1, 'Free Plan', 0.00, '$', '1 Surveys per month', '3 Survey Question', '3 Survey Steps', 'Survey Statistics', 'Specific Survey Design', 'Export Responses', 'Integrate to your website', 'Priority support', 'No ads', 0, 1, 3, 3, 3, 0, 0, 0, 0, 0, 0),
(2, 'Basic Plan', 9.99, '$', '3 Surveys per month', '12 Survey Question', '5 Survey Steps', 'Survey Statistics', 'Specific Survey Design', 'Export Responses', 'Integrate to your website', 'Priority support', 'No ads', 0, 3, 5, 12, 6, 0, 1, 0, 0, 0, 0),
(3, 'Regular Plan', 19.99, '$', '8 Surveys per month', '18 Survey Question', '10 Survey Steps', 'Survey Statistics', 'Specific Survey Design', 'Export Responses', 'Integrate to your website', 'Priority support', 'No ads', 0, 8, 10, 18, 10, 1, 1, 0, 0, 0, 0),
(4, 'Pro Plan', 24.99, '$', 'Unlimited Surveys per month', 'Unlimited Survey Question', 'Unlimited Survey Steps', 'Survey Statistics', 'Specific Survey Design', 'Export Responses', 'Integrate to your website', 'Priority support', 'No ads', 0, 99999999, 99999999, 99999999, 99999999, 1, 1, 1, 1, 1, 1);
");

$db->query("
ALTER TABLE `".prefix."plans`
  ADD PRIMARY KEY (`id`);
	");


$db->query("
ALTER TABLE `".prefix."plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
");



$db->query("
INSERT INTO `".prefix."configs` (`id`, `variable`, `value`) VALUES
(8, 'site_forget', '1'),
(10, 'site_noreply', 'donotreply@puertokhalid.com'),
(12, 'login_facebook', '1'),
(13, 'login_twitter', '1'),
(14, 'login_google', '1'),
(15, 'login_fbAppId', ''),
(16, 'login_fbAppSecret', ''),
(17, 'login_fbAppVersion', ''),
(18, 'login_twConKey', ''),
(19, 'login_twConSecret', ''),
(20, 'login_ggClientId', ''),
(21, 'login_ggClientSecret', ''),
(22, 'site_paypal_id', ''),
(23, 'site_paypal_live', '0'),
(24, 'site_currency_symbol', '$'),
(25, 'site_currency_name', 'USD'),
(26, 'site_smtp', '1'),
(27, 'site_smtp_host', 'smtp1.example.com'),
(28, 'site_smtp_username', 'user@example.com'),
(29, 'site_smtp_password', ''),
(30, 'site_smtp_encryption', 'tls'),
(31, 'site_smtp_port', '587'),
(32, 'site_smtp_auth', '1'),
(33, 'site_country', 'US');
");


$db->query("
ALTER TABLE `".prefix."users` ADD `social_id` VARCHAR(200) NULL AFTER `city`, ADD `social_name` VARCHAR(200) NULL AFTER `social_id`;
");

?>


<div class="install-box">
	<h1>Congratulations...</h1>
	<p>
		Congratulations Puerto Premium Survey Script is installed successfully. if you have any problem or issue with the script or the instraction that I provide please contact me first ASAP in:

		</p>
		<ul>
			<li>my Email: <span class="p-h">el.bouirtou@gmail.com</span></li>
			<li>my Facebook account <span class="p-h"><a href="https://fb.com/prof.puertokhalid">fb.com/prof.puertokhalid</a></span></li>
			<li>on the Instagram <span class="p-h"><a href="https://instagram.com/khalidpuerto">instagram.com/khalidpuerto</a></span></li>
			<li>Codecanyon profile <span class="p-h"><a href="http://codecanyon.net/user/puertokhalid">codecanyon.net/user/puertokhalid</a></span></li>
		</ul>
		<p>
		 and I will back to you with all help you need.<br><br>
		<span class="red">Please do not forget to delete the installation file 'install.php'.</span><br>
		<a href="index.php" class="button">Go to index</a>
	</p>
</div>

<?php
endif;
