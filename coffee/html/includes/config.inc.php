<?php

// Estamos ativos?
if (!defined('LIVE')) DEFINE('LIVE', false);

// Os erros serão enviados por e-mail para este endereço:
DEFINE('CONTACT_EMAIL', 'you@example.com');

// Determina a localização dos arquivos e o URL do site:
define('BASE_URI', '/var/www/e-commerce-with-php-and-mysql/coffee/html/');
define('BASE_URL', 'localhost/');
define('MYSQL', BASE_URI . 'includes/mysql.inc.php');

function my_error_handler($e_number, $e_message, $e_file, $e_line, $e_vars) {
	// Cria a mensagem de erro:
	$message = "An error occurred in script '$e_file' on line $e_line:\n$e_message\n";

	// Adiciona o backtrace:
	$message .= "<pre>" . print_r(debug_backtrace(), 1) . "</pre>\n";

	// Ou simplesmente concatena $e_vars à mensagem:
	// $message .= "<pre>" . print_r($e_vars, 1) . "</pre>\n";

	if (!LIVE) {
    // Mostra o erro no navegador.
		echo '<div class="error">' . nl2br($message) . '</div>';
	} else {
		// Envia o erro via e-mail:
		error_log ($message, 1, CONTACT_EMAIL, 'From:admin@example.com');

		// Apresenta uma mensagem de erro no navegador somente se não for uma informação:
		if ($e_number != E_NOTICE) {
			echo '<div class="error">A system error occurred. We apologize for the inconvenience.</div>';
		}
	}

	return true; // Para que o PHP não tente tratar o erro também.
}

// Utilize o manipulador de erro customizado:
set_error_handler ('my_error_handler');
