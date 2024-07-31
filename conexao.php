<?php

// definindo as constantes de conexão com o banco de dados
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'x2003');
DEFINE('DB_USER', 'root');
DEFINE('DB_PASSWORD', '9y{3E8`4hh16');

// efetuando ligação dentro de um bloco try... catch
try {
	// string de conexão
	$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;

	// fazendo a conexão com banco de dados
	$conexao = new PDO($dsn, DB_USER, DB_PASSWORD);

	// definindo o modo de erro do PDO para exceções
	$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

	echo 'ERROR: ' . $e->getMessage();
}
