<?php

require_once 'conexao.php';
session_start();

if (!isset($_SESSION['id']) || $_SESSION['nivel_acesso'] != 'admin') {
	header("Location: login.php");
	exit();
}

if (empty($_GET['id'])) {
	echo 'Nenhum ID de usuário foi fornecido!';
	exit();
}

$alterar_usuario = $_GET['id'];
$msg = '';

// buscando dados atuais do usuário
$sql = "SELECT nome, email FROM usuarios WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bindParam(1, $alterar_usuario);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$nome = $_POST['nome_usuario'];
	$email = $_POST['email_usuario'];
	$senha = password_hash($_POST['senha_usuario'], PASSWORD_BCRYPT);

	// preparando a querry
	$sql = ("UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?");
	$stmt = $conexao->prepare($sql);
	$stmt->bindParam(1, $nome);
	$stmt->bindParam(2, $email);
	$stmt->bindParam(3, $senha);
	$stmt->bindParam(4, $alterar_usuario);

	if ($stmt->execute()) {
		$msg = 'Usuario altarado com sucesso!';
		header("refresh:2; url=listar_usuarios.php");
		exit();
	} else {
		$msg = 'Erro ao alterar usuário!' . errorInfo()[2];
	}
}

?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atualizar Usuário</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Atualizar Usuário</h1>
        <p><?php echo htmlspecialchars($msg); ?></p>
        <form method="post" action="">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome_usuario" value="<?= htmlspecialchars($usuario['nome']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email_usuario" value="<?= htmlspecialchars($usuario['email']); ?>" required>
            </div>
             <div class="form-group">
                <label for="senha">Senha (deixe em branco para não alterar):</label>
                <input type="password" class="form-control" id="senha" name="senha_usuario">
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
        </form>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>