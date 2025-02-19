<?php

// Define as informações para o acesso ao banco de dados na forma de constantes
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_USER', 'root');
DEFINE('DB_PASSWORD', '');
DEFINE('DB_NAME', 'ecommerce2');

// Faz a conexão
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Define o conjunto de caracteres
mysqli_set_charset($dbc, 'utf8');

// Omite a tag de fechamento do PHP para evitar erros de 'headers already sent'
// (cabeçalhos já enviados)!
