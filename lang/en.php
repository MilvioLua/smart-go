<?php


$lang['rtl']      = false;
$lang['lang']     = 'en';
$lang['close']    = 'Close';
$lang['loading']  = 'Loading...';

# + Time
$lang['timedate']['time_second'] = "second";
$lang['timedate']['time_minute'] = "minute";
$lang['timedate']['time_hour'] = "hour";
$lang['timedate']['time_day'] = "day";
$lang['timedate']['time_week'] = "week";
$lang['timedate']['time_month'] = "month";
$lang['timedate']['time_year'] = "year";
$lang['timedate']['time_decade'] = "decade";
$lang['timedate']['time_ago'] = "ago";


# + Menu
$lang['menu'] = [
	"home"    => "Home",
	"forms"   => "Forms",
	"about"   => "About us",
	"plans"   => "Plans",
	"welcome" => "Welcome",
	"new"     => "New Survey",
	"admin"   => "Administration",
	"info"    => "Manage Info",
	"logout"  => "Logout",
	"signin"  => "Sign in"
];


# + Sign in (login)
$lang['login'] = [
	"username" => "Your Username or Email",
	"password" => "Your Password",
	"keep"     => "Keep me logged in",
	"button"   => "Sign In",
	"footer"   => "You don't have an account?",
	"footer_l"   => "Sign up FREE",
	"alert"    => [
    	"required"   => "You left username or password empty!",
    	"moderat"    => "Membership has been banned by admin, if you think this is a mistak please feel free to contact us.",
    	"activation" => "Membership need email activation.",
    	"approve"    => "Membership need to be approved by administration.",
      "success"    => "You are logged in successfully, We wish you having good times.",
      "social"     => "There is a problem with your social ID, the username you want to login with is not yours or already exist with a different social ID!",
      "error"      => "Username or password is not available!"
  ]
];

# + Sign up
$lang['signup'] = [
	"username" => "Your Username",
	"password" => "Your Password",
	"email" => "Your Email",
	"button"   => "Sign Up",
	"footer"   => "Do you have an account?",
	"footer_l"   => "Sign in",
	"alert"    => [
    "required"         => "All fields marked with * are required!",
    "char_username"    => "The username must contain only letters!",
    "limited_username" => "The Username must be limited between 3 and 15 characters!",
    "exist_username"   => "Username is already exists!",
    "limited_pass"     => "The Password must be limited between 6 and 12 characters!",
    "repass"           => "Re-password is Must match with the password!",
    "check_email"      => "Please input a valid e-mail!",
    "exist_email"      => "E-mail Address is already exists!",
    "birth"            => "Your birth date need to be between <b>1-1-2005</b> and <b>1-1-1942</b>!",
    "success"          => "Registration process has ended successfully.",
    "success1"         => "Registration process has ended successfully. But, still need approved by administration.",
    "success2"         => "Registration process has ended successfully. But, still need activate by email.",
    "error"            => "Username or password is not available!"
  ]
];

# + User Details
$lang['details'] = [
	"title" => "Manage infos:",
	"firstname" => "Your first name",
	"lastname"  => "Your last name",
	"username"  => "Edit Username",
	"password"  => "Edit Password",
	"email"     => "Edit Email",
	"male"      => "Male",
	"female"    => "Female",
	"country"   => "Country",
	"state"     => "State/Region",
	"city"      => "City",
	"address"   => "Full Address",
	"image_n"   => "No image chosen...",
	"image_c"   => "Choose Image",
	"button"    => "Send info",
	"alert"     => [
    "success" => "Edit infos process has ended successfully."
  ]
];

# + Survey
$lang['survey'] = [
	"close_h" => "This survey is currently closed.",
	"close_p" => "Want to create your own survey?",
	"button"  => "SIGN UP FREE",
	"back"  => "Back",
	"next"  => "Next",
	"alert"     => [
    "error" => "required to answer!"
  ]
];


# + Page: Alerts
$lang['alerts'] = [
	"no-data"    => "No data found!",
	"permission" => "You can't access to this page because you have to upgrade your plan!",
	"wrong"      => "Something went wrong!",
	'required'   => 'All fields marked with * are required!',
	'logout'    => 'are you sure you want to logout?',
	"danger"     => "Oh snap!",
	"success"    => "Well done!",
	"warning"    => "Warning!",
	"info"       => "Heads up!"
];


# + Responses
$lang['responses'] = [
	"title" => "My Survey Responses",
	"btn_1" => "See Rapport",
	"btn_2"  => "Edit Survey"
];


# + Rapports
$lang['rapports'] = [
	"title"     => "My Survey Rapport",
	"btn1"      => "Create Survey",
	"btn2"      => "Edit Survey",
	"stats_d"     => "Statistics for the last 7 days",
	"stats_m"     => "Statistics for this year",
	"title"     => "Title:",
	"views"     => "Views:",
	"responses" => "Responses:",
	"rate"      => "Completed Rate:",
	"start"     => "Start Date:",
	"end"       => "End Date:",
	"last_r"    => "Last Response:",
	"days"      => "Last 7 Days",
	"months"    => "Month",
	"results"   => "All results",
	"export"    => "Export Data",
	"by"        => "Answer by",
	"people"    => "people",
	"alert"     => [
    "success" => "Edit infos process has ended successfully."
  ]
];

# + Plans / Payment
$lang['plans'] = [
	"title" => "Simple Pricing for Everyone!",
	"desc"  => "Pricing built for buisenesses of all sizes. Always know what you'll pay. All plans comse with 100% money back guarane.",
	"month" => "/per month",
	"btn"   => "Get Started",
	"alert" => [
    "success" => "Your payments has been calculated!"
  ]
];


# + New/Edit survey
$lang['new'] = [
	"title"       => "Create a New Survey",
	"questions"   => "Questions",
	"welcome"     => "Welcome Page",
	"thanks"      => "Thank you Page",
	"design"      => "Design",
	"stitle"      => "Survey Title",
	"start"       => "Survey Start Date",
	"end"         => "Survey End Date",
	"url"         => "Redirect Url",
	"private"     => "This surevey is private (Takes only by URL)",
	"unpub"       => "Unpublished",
	"ip"          => "IP Restriction",
	"start_q"     => "Start making questions!",
	"new_step"    => "Add New Step",
	"new_q"       => "New Question",
	"new_qpl"     => "Write your question",
	"new_qde"     => "Write a brief description about your question",
	"new_qre"     => "Required question to answer",
	"new_qln"     => "Answers at the same line",
	"new_a"       => "New Answers",
	"new_abtn"    => "Add New",
	"new_as1"    => "Single line text",
	"new_as2"    => "Paragraph text",
	"new_as3"    => "Multi choice (Checkbox)",
	"new_as4"    => "Multi choice (Radio)",
	"new_as5"    => "Rating scale",
	"new_as6"    => "Date time",
	"new_as7"    => "Phone number",
	"new_as8"    => "Country",
	"new_as9"    => "Email Adress",
	"new_asi"    => "Icon",
	"new_aspl"    => "placeholder",
	"new_asck"    => "Write a name",
	"wp"          => "Welcome Page",
	"wp_h"        => "Headling",
	"wp_btn"      => "Start button text",
	"wp_icon"     => "Start button icon",
	"tx"          => "Thank you Page",
	"tx_h"        => "Headling",
	"tx_btn"      => "End button text",
	"tx_icon"     => "End button icon",
	"send"        => "Send Survey",
	"design_bs"   => "Button shadow:",
	"design_bb"   => "Button border:",
	"design_si"   => "Size:",
	"design_s"    => "Style:",
	"design_c"    => "Color",
	"design_btg"  => "Button background:",
	"design_g"    => "Gradient",
	"design_n"    => "Normal",
	"design_btc"  => "Butoon text color:",
	"design_sbg"  => "Survey background:",
	"design_stbg" => "Step background:",
	"design_ibg"  => "Input background:",
	"design_yes"  => "Yes",
	"design_no"   => "No",
	"alert" => [
    "error" => "Error! Some survey fields are required!",
    "error1" => "Error! Please make sure to add {var}!",
    "error2" => "Error! Please make sure to add questions to step!",
    "error3" => "Error! Please make sure question {var} have a value!",
    "error4" => "Error! Please make sure to add answers to question!",
    "error5" => "Error! Please make sure all answers in question {var} have a value!",
    "success" => "success! all done!!"
  ]
];

$lang['edit'] = [
	"title" => "Edit a New Survey",
	"alert" => [
    "success" => "Your payments has been calculated!"
  ]
];

# + Index

$lang['mysurvys'] = [
	"title"     => "My Surveys",
	"alltitle"     => "Public Surveys",
	"create"    => "Create Survey",
	"status"    => "Status",
	"name"      => "Survey Name",
	"views"     => "Views",
	"responses" => "Responses",
	"rate"      => "Complete Rate",
	"created"   => "Created",
	"last_r"    => "Last Response",
	"op_view"   => "View Survey",
	"op_stats"  => "Survey Statistics",
	"op_resp"   => "Show Responses",
	"op_edit"   => "Edit Survey",
	"op_delete" => "Delete Survey",
	"op_embed"  => "Embed Survey",
	"op_send"   => "Send Survey",
	"alert" => [
    "success" => "Your payments has been calculated!"
  ]
];


# + Dashboard

$lang['dashboard'] = [
	"hello"     => "Hello,",
	"welcome"     => "Welcome back again to your dashboard.",
	"stats_line_d"     => "Statistics for the last 7 days",
	"stats_line_m"     => "Statistics for this year",
	"stats_bar_d"     => "Statistics for the last 7 days",
	"stats_bar_m"     => "Statistics for this year",
	"surveys"     => "Surveys",
	"users"     => "Users",
	"responses"     => "Responses",
	"questions"     => "Questions",
	"new_u"     => "New Users (24h)",
	"new_p"     => "Latest Payements (24h)",
	"new_s"     => "Latest Surveys (24h)",
	"u_users"     => "Members",
	"u_status"     => "Status",
	"u_username"     => "Username",
	"u_plan"     => "Plan",
	"u_credits"     => "Credits",
	"u_last_p"     => "Last Payment",
	"u_registred"     => "Registred at",
	"u_updated"     => "Updated at",
	"u_delete"     => "Delete User",
	"u_edit"     => "Edit User",
	"p_title"     => "Payments",
	"p_user"     => "User",
	"p_status"     => "Status",
	"p_plan"     => "Plan",
	"p_amount"     => "Amount",
	"p_date"     => "Payment Date",
	"p_txn"     => "TXN",
	"set_title"     => "General Settings",
	"set_stitle"     => "Site title:",
	"set_keys"     => "Site keywords:",
	"set_desc"     => "Site Description:",
	"set_url"     => "Site URL:",

	"set_noreply"     => "Do not reply email:",
	"set_register"     => "Site Registration",

	"set_btn"     => "Send Settings",
	"alert" => [
    "success" => "Setting has sent successfully."
  ]
];
