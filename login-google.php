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

# Header Page
include __DIR__.'/header.php';

# Main Page
if(!us_level):
	if(isset($_REQUEST['code'])){
		$gClient->authenticate();
		$_SESSION['token'] = $gClient->getAccessToken();
	}

	if (isset($_SESSION['token'])) {
		$gClient->setAccessToken($_SESSION['token']);
	}

	if ($gClient->getAccessToken()) {
		$profile = $google_oauthV2->userinfo->get();
		fh_social_login( 'google', $profile );
	} else {
		$authUrl = $gClient->createAuthUrl();
	}
else:
	echo "<div class='padding'>".fh_alerts($lang['alerts']['wrong'], "danger", path."/index.php")."</div>";
endif;

# Footer Page
include __DIR__.'/footer.php';
