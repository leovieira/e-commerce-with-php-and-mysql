<?php
require('./includes/config.inc.php');

redirect_invalid_user();

$_SESSION = array();
session_destroy();
setcookie(session_name(), '', time()-300);

require(MYSQL);

$page_title = 'Logout';
include('./includes/header.html');
?>

<h1>Logged Out</h1>
<p>Thank you for visiting. You are now logged out. Please come back soon!</p>

<?php
include('./includes/footer.html');
?>
