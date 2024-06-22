<?php

function create_form_input($name, $type, $label = '', $errors = array(), $options = array()) {
	$value = false;
	if (isset($_POST[$name])) $value = $_POST[$name];
	/* REMOVED
	if ($value && get_magic_quotes_gpc()) $value = stripslashes($value); */

	echo '<div class="form-group';
	if (array_key_exists($name, $errors)) echo ' has-error';
	echo '">';

	if (!empty($label)) {
		echo '<label for="' . $name . '" class="control-label">' . $label . '</label>';
	}

	if (($type === 'text') || ($type === 'password') || ($type === 'email')) {
		echo '<input type="' . $type . '" name="' . $name . '" id="' . $name . '" class="form-control"';
		if ($value) echo ' value="' . htmlspecialchars($value) . '"';
		if (!empty($options) && is_array($options)) {
			foreach ($options as $k => $v) {
				echo " $k=\"$v\"";
			}
		}
		echo '>';

		if (array_key_exists($name, $errors)) {
			echo '<span class="help-block">' . $errors[$name] . '</span>';
		}
	} elseif ($type === 'textarea') {
		if (array_key_exists($name, $errors)) {
			echo '<span class="help-block">' . $errors[$name] . '</span>';
		}

		echo '<textarea name="' . $name . '" id="' . $name . '" class="form-control"';
		if (!empty($options) && is_array($options)) {
			foreach ($options as $k => $v) {
				echo " $k=\"$v\"";
			}
		}
		echo '>';
		if ($value) echo $value;
		echo '</textarea>';
	}

	echo '</div>';
}
