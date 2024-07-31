<?php

require_once 'conexao.php';
session_start();

if (!isset($_SESSION['id']) || $_SESSION['nivel_acesso'] != 'admin') {
	header("Location: login.php");
	exit();
}

echo "Seja bem vindo admin!";

?>
<a href="listar_usuarios.php">Lista</a>
<a href="registrar_admin.php">Registrar</a>