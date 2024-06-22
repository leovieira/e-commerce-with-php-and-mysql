<?php

define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');
define('DB_NAME', 'ecommerce1');

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
mysqli_set_charset($dbc, 'utf8');

function escape_data($data, $dbc) {
	/* REMOVED
	if (get_magic_quotes_gpc()) $data = stripslashes($data); */
	return mysqli_real_escape_string($dbc, trim($data));
}
