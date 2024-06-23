<?php
require('./includes/config.inc.php');

if (($_SERVER['REQUEST_METHOD'] === 'POST') && isset($_POST['txn_id']) && ($_POST['txn_type'] === 'web_accept')) {
	$ch = curl_init();
	curl_setopt_array($ch,
	array(
		CURLOPT_URL => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => http_build_query(array('cmd' => '_notify-validate') + $_POST),
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HEADER => false
	));
	$response = curl_exec($ch);
	$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);

	if ($status === 200 && $response === 'VERIFIED') {
		if (isset($_POST['payment_status'])
			&& ($_POST['payment_status'] === 'Completed')
			&& ($_POST['receiver_email'] === 'seller_1281297018_biz@mac.com')
			&& ($_POST['mc_gross'] === 10.00)
			&& ($_POST['mc_currency'] === 'USD')
			&& (!empty($_POST['txn_id']))
		) {
			require(MYSQL);
			$txn_id = escape_data($_POST['txn_id'], $dbc);
			$q = "SELECT id FROM orders WHERE transaction_id='$txn_id";
			$r = mysqli_query($dbc, $q);
			if (mysqli_num_rows($r) === 0) {
				$uid = (isset($_POST['custom'])) ? (int) $_POST['custom'] : 0;
				$status = escape_data($_POST['payment_status'], $dbc);
				$amount = (int) ($_POST['mc_gross'] * 100);
				$q = "INSERT INTO orders (user_id, transaction_id, payment_status, payment_amount) VALUES ($uid, '$txn_id', '$status', '$amount')";
				$r = mysqli_query($dbc, $q);
				if (mysqli_affected_rows($dbc) === 1) {
					if ($uid > 0) {
						$q = "UPDATE users SET date_expires = IF(date_expires > NOW(), ADDDATE(date_expires, INTERVAL 1 YEAR), ADDDATE(NOW(), INTERVAL 1 YEAR)) WHERE id=$uid";
						$r = mysqli_query($dbc, $q);
						if (mysqli_affected_rows($dbc) !== 1) {
							trigger_error('The user\'s expiration date could not be updated!');
						}
					}
				} else {
					trigger_error('The transaction could not be stored in the orders table!');
				}
			}
		}
	}
} else {
	echo 'Nothing to do.';
}
?>
