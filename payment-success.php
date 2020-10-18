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

include __DIR__ .'/header.php';

if(!empty($_GET['item_number']) && !empty($_GET['tx']) && !empty($_GET['amt']) && !empty($_GET['cc']) && !empty($_GET['st'])){
		$referrer = isset($_SERVER['HTTP_REFERER']) ? sc_sec($_SERVER['HTTP_REFERER']) : '';
		$referrer_arr = isset($referrer) ? explode('.',str_replace('www.','', $referrer)) : [];
		// Check if the results comes from Paypal or sendbox
		if(in_array($referrer_arr[0], ['https://sandbox', 'https://paypal'])){
			$item_number    = sc_sec($_GET['item_number']);
	    $txn_id         = sc_sec($_GET['tx']);
	    $payment_gross  = sc_sec($_GET['amt']);
	    $currency_code  = sc_sec($_GET['cc']);
	    $payment_status = sc_sec($_GET['st']);
			if($plans[str_replace('Plan#','',$item_number)]['price'] == $payment_gross){
				$data = [
					"plan"     => "{$item_number}",
					"txn_id"   => "{$txn_id}",
					"price"    => "{$payment_gross}",
					"currency" => "{$currency_code}",
					"status"   => "{$payment_status}",
					"date"     => time(),
					"author"   => us_id
				];
				db_insert("payments", $data);
				db_update("users", [
					"plan"        => str_replace("Plan#",'',$item_number),
					"txn_id"      => "{$txn_id}",
					"credits"     => db_get("users", "credits", us_id) + $payment_gross,
					"lastpayment" => time()
				], us_id);
				echo fh_alerts($lang['plans']['alert']['success'], 'success', path.'/index.php');
			} else {
				echo fh_alerts($lang['alerts']['wrong'], 'danger', path.'/index.php');
			}
		} else {
			echo fh_alerts($lang['alerts']['wrong'], 'danger', path.'/index.php');
		}
} else {
	echo '<meta http-equiv="refresh" content="0;url='.path.'">';
}

include __DIR__ .'/footer.php';
?>
