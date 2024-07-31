<?php

require_once 'conexao.php';
session_start();

if (!isset($_SESSION['id']) || $_SESSION['nivel_acesso'] != 'admin') {
	header("Location: login.php");
	exit();
}

if (empty($_GET['id'])) {
	echo 'Nenhum ID de usuário foi fornecido';
	exit();
}

$usuario_deletado = $_GET['id'];
$sql = ("DELETE FROM usuarios WHERE id = ?");
$stmt = $conexao->prepare($sql);
$stmt->bindParam(1, $usuario_deletado);

$msg = '';

// executando a query
if ($stmt->execute()) {
	$msg = 'Usuário deletado com sucesso';
	header("Location:listar_usuarios.php");
} else {
	$msg = 'Erro ao deletar usuário' . $stmt->errorInfo()[2];
}

?>

