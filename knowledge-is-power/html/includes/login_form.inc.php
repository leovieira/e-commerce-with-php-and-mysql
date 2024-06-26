<?php
if (!isset($login_errors)) $login_errors = array();
require('./includes/form_functions.inc.php');
?>

<form action="index.php" method="post" accept-charset="utf-8">
	<fieldset>
		<legend>Login</legend>
		<?php
		if (array_key_exists('login', $login_errors)) {
			echo '<div class="alert alert-danger">' . $login_errors['login'] . '</div>';
		}

		create_form_input('email', 'email', '', $login_errors, array('placeholder' => 'Email address'));
		create_form_input('pass', 'password', '', $login_errors, array('placeholder' => 'Password'));
		?>
		<span class="help-block"><a href="forgot_password.php">Forgot?</a></span>
		<button type="submit" class="btn btn-default">Login &rarr;</button>
	</fieldset>
</form>
