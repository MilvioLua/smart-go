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

# Database Host Name
define("HOSTNAME", "localhost");

# Database Username
define("USERNAME", "root");

# Database Password
define("PASSWORD", "");

# Database Name
define("DATABASE", "smartgo");

# Tables' Prefix
define('prefix', 'puerto_');


# No need to change anything bellow this line
$db = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
if($db->connect_errno){
	echo "Echec lors de la connexion à MySQL : (" . $db->connect_errno . ") " . $db->connect_error;
}


$sql_mode = $db->query("SELECT @@GLOBAL.sql_mode;");
$rs_mode = $sql_mode->fetch_assoc();
if(!empty($rs_mode["@@GLOBAL.sql_mode"])) {
	$db->query("SET GLOBAL sql_mode='';");
}
