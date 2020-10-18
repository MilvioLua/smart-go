<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');
function rewrite_urls($change){
  $match = [
    '/index.php/',
    '/plans.php/',
    '/newsurvey\.php/',
    '/editsurvey\.php\?id=([0-9]+)/',
    '/dashboard\.php\?pg=([a-z]+)&page=([0-9]+)/',
    '/dashboard\.php\?pg=([a-z]+)/',
    '/dashboard\.php/',

    '/index\?request=([a-z]+)&page=([0-9]+)/',
    '/index\?request=([a-z]+)/',
    '/index\?page=([0-9]+)/',
    '/userdetails\.php\?id=([0-9]+)/',
		'/userdetails\.php/',

    '/survey\.php\?id=([0-9]+)&request=su/',
    '/survey\.php\?id=([0-9]+)/',

    '/responses\.php\?id=([0-9]+)/',
    '/rapport\.php\?id=([0-9]+)/',

  ];
  $replace = [
    'index',
    'plans',
    'new/survey',
    'edit/survey/$1',
    'dashboard/$1/page/$2',
    'dashboard/$1',
    'dashboard',

    'surveys/$1/page/$2',
    'surveys/$1',

    'index/page/$1',
		'user/details/$1',
		'user/details',

		'survey/$1/view',
		'survey/$1',

		'responses/$1',
		'rapport/$1',

  ];

  $change = preg_replace($match, $replace, $change);

	return $change;
}
ob_start("rewrite_urls");

# If the installation file exists
if (file_exists(__DIR__."/install.php")) {
	die('<meta http-equiv="refresh" content="0;url=install.php">');
}

# Language
$lang = [];
if(isset($_COOKIE['lang']) && file_exists(__DIR__.'/lang/'.$_COOKIE['lang'].'.php')){
	include __DIR__.'/lang/'.$_COOKIE['lang'].'.php';
} else {
	include __DIR__.'/lang/en.php';
}

function getBaseUrl(){
  $protocol = 'http';
  if ($_SERVER['SERVER_PORT'] == 443 || (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on')) {
    $protocol .= 's';
  }
  $host = $_SERVER['HTTP_HOST'];
  $request = $_SERVER['PHP_SELF'];
  return dirname($protocol . '://' . $host . $request);
}

# Your website path
define("path", getBaseUrl());

# Getting the current page name
define("page", basename($_SERVER['PHP_SELF'], '.php'));

# Photo error src
define("nophoto", path."/img/nophoto.jpg");

# Including Configs files
include __DIR__."/configs/connection.php";
include __DIR__."/configs/countries.php";
include __DIR__."/configs/phone.php";
include __DIR__."/configs/functions.php";
include __DIR__."/configs/pagination.php";

# User Client Info
include __DIR__."/configs/info.class.php";
define("get_ip", UserInfo::get_ip());
define("get_os", UserInfo::get_os());
define("get_browser", UserInfo::get_browser());
define("get_device", UserInfo::get_device());

# Site Details
db_global();

# User Details
db_login_details();

if(in_array(page, ['configs', 'login'])){
  header("HTTP/1.0 404 Not Found");
}

# Default Country code
define("c_code", site_country);

$flatColors = ["#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50", "#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "7f8c8d"];

#PHPMailer
use PHPMailer\PHPMailer\PHPMailer;

require __DIR__.'/configs/phpmailer/Exception.php';
require __DIR__.'/configs/phpmailer/PHPMailer.php';
require __DIR__.'/configs/phpmailer/SMTP.php';

$mail = new PHPMailer();

if(defined("site_smtp") && site_smtp == 1)
	$mail->isSMTP();

$mail->Host       = (defined("site_smtp_host") && site_smtp_host != '' ? site_smtp_host : '');
$mail->SMTPAuth   = (defined("site_smtp_port") && site_smtp_port == '1' ? true : false);
$mail->Username   = (defined("site_smtp_username") && site_smtp_username != '' ? site_smtp_username : '');
$mail->Password   = (defined("site_smtp_password") && site_smtp_password != '' ? site_smtp_password : '');
$mail->SMTPSecure = (defined("site_smtp_encryption") && site_smtp_encryption != 'none' ? site_smtp_encryption : false);
$mail->Port       = (defined("site_smtp_port") && site_smtp_port != '' ? site_smtp_port : '');

$mail->setFrom((defined("site_noreply") && site_noreply != '' ? site_noreply : ''), site_title);


# Facebook Login App
define("fbAppId",      login_fbAppId);
define("fbAppSecret",  login_fbAppSecret);
define("fbAppVersion", login_fbAppVersion);

$facebookLoginUrl = '#';
if(fbAppId != '' && fbAppSecret != '' && fbAppVersion != ''){
	require __DIR__.'/configs/src/Facebook/autoload.php';
	$fb = new Facebook\Facebook([
		'app_id'                => fbAppId,
		'app_secret'            => fbAppSecret,
		'default_graph_version' => fbAppVersion,
	]);
	$helper      = $fb->getRedirectLoginHelper();
	$permissions = ['email'];
	$facebookLoginUrl    = $helper->getLoginUrl(path."/login-facebook.php", $permissions);
}

# Twitter Login App
define('twConKey',        login_twConKey);
define('twConSecret',     login_twConSecret);
define('twOauthCallback', path."/login-twitter.php");

if(twConKey != '' && twConSecret != ''){
	require_once(__DIR__."/configs/src/Twitter/twitteroauth.php");
	$twitterLoginUrl = path."/login-twitter.php";
}

# Google Login App
define('ggClientId',      login_ggClientId);
define('ggClientSecret',  login_ggClientSecret);
define('ggOauthCallback', path."/login-google.php");
define('ggAppName',       site_title);

if(ggClientId != '' && ggClientSecret != ''){
	require_once(__DIR__."/configs/src/Google/Google_Client.php");
	require_once(__DIR__."/configs/src/Google/contrib/Google_Oauth2Service.php");

	$gClient = new Google_Client();
	$gClient->setApplicationName(ggAppName);
	$gClient->setClientId(ggClientId);
	$gClient->setClientSecret(ggClientSecret);
	$gClient->setRedirectUri(ggOauthCallback);

	$google_oauthV2 = new Google_Oauth2Service($gClient);
	$googleLoginUrl = $gClient->createAuthUrl();
}


# Paypal Payement Gateway configuration
define('PAYPAL_ID', (defined("site_paypal_id") && site_paypal_id != '' ? site_paypal_id : ''));
define('PAYPAL_SANDBOX', (defined("site_paypal_live") && site_paypal_live == 1 ? false : true)); //TRUE (testing) or FALSE (live)

define('PAYPAL_RETURN_URL', path.'/payment-success.php');
define('PAYPAL_CANCEL_URL', path.'/index.php');
define('PAYPAL_NOTIFY_URL', path.'/ipn.php');
define('PAYPAL_CURRENCY', (defined("site_currency_name") && site_currency_name != '' ? site_currency_name : ''));

define('PAYPAL_URL', (PAYPAL_SANDBOX == true)?"https://www.sandbox.paypal.com/cgi-bin/webscr":"https://www.paypal.com/cgi-bin/webscr");


# Get vars
$request = (isset($_GET['request']) ? sc_sec($_GET['request']) : '');
$pg      = (isset($_GET['pg']) ? sc_sec($_GET['pg'])           : '');
$id      = (isset($_GET['id']) ? (int)($_GET['id'])    : '');
$s       = (isset($_GET['s']) ? (int)($_GET['s'])      : '');

# Pagination
$page = !isset($_GET["page"]) || !$_GET["page"] ? 1 : (int)($_GET["page"]);
$limit = 10;
$startpoint = ($page * $limit) - $limit;

# Plans Options
if(us_level == 6 || us_plan){
	define("surveys_month",     9999999);
	define("surveys_steps",     50);
	define("surveys_questions", 50);
	define("surveys_answers",   20);
} else {
	define("surveys_month",     db_get("plans", "surveys_month", us_plan+1));
	define("surveys_steps",     db_get("plans", "surveys_steps", us_plan+1));
	define("surveys_questions", db_get("plans", "surveys_questions", us_plan+1));
	define("surveys_answers",   db_get("plans", "surveys_answers", us_plan+1));
}

define("surveys_rapport",   db_get("plans", "surveys_rapport", us_plan+1));
define("surveys_export",    db_get("plans", "surveys_export", us_plan+1));
define("surveys_iframe",    db_get("plans", "surveys_iframe", us_plan+1));
define("show_ads",          db_get("plans", "show_ads", us_plan+1));
define("survey_design",     db_get("plans", "survey_design", us_plan+1));
define("support",           db_get("plans", "support", us_plan+1));

# Survey views
if(page == 'survey'){
	if(!isset($_COOKIE["survey_view_{$id}"])) {
		setcookie("survey_view_{$id}", "surv_".$id, time() + (86400 * 365));
	}
}
