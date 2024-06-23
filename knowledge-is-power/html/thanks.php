<?php
require('./includes/config.inc.php');
// redirect_invalid_user('reg_user_id');
require(MYSQL);
$page_title = 'Thanks';
include('./includes/header.html');
/* if (filter_var($_SESSION['reg_user_id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
	$q = "UPDATE users SET date_expires = ADDDATE(date_expires, INTERVAL 1 YEAR) WHERE id={$_SESSION['reg_user_id']}";
	$r = mysqli_query($dbc, $q);
}
unset($_SESSION['reg_user_id']); */
?><h1>Thank You!</h1>
<p>Thank you for your payment! You may access all of the site's content for the next year!
<strong>Note: Your access to the site will automatically be renewed via PayPal each year. To disable this feature, or to cancel your account,
see the "My preapproved purchases" section of your PayPal profile page.</strong></p>
<?php include('./includes/footer.html'); ?>
