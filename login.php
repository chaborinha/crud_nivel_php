<?php

require_once 'conexao.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$email = $_POST['email_usuario'];
	$senha = $_POST['senha_usuario'];

	$sql = "SELECT * FROM usuarios WHERE email = ?";
	$stmt = $conexao->prepare($sql);

	$stmt->bindParam(1, $email);
	$stmt->execute();
	$user = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($user && password_verify($senha, $user['senha'])) {

		$_SESSION['id'] = $user['id'];
		$_SESSION['nome'] = $user['nome'];
		$_SESSION['email'] = $user['email'];
		$_SESSION['nivel_acesso'] = $user['nivel_acesso'];
		header("Location: auth.php");
	} else {
		echo "E-mail ou senha incorretos!";
	}
}

?>

<form method="post" action="">
    Email: <input type="email" name="email_usuario" required><br>
    Senha: <input type="password" name="senha_usuario" required><br>
    <input type="submit" value="Login">
    <a href="registrar.php">Fazer cadastro</a>
</form>