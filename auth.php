<?php 		

require_once 'conexao.php';
session_start();

// verificando se usuario está logado
if (!isset($_SESSION['id']))
{
	// se não estiver manda de volta para página de login
	header("Location: login.php");
	exit();
}

// pegando o nivel de acesso do usuário
$nivel_acesso = $_SESSION['nivel_acesso'];

if ($nivel_acesso == 'admin') {
	header("Location: dashboard.php");
	exit();
} else {
	header("Location: index.php");
	exit();
}



?>