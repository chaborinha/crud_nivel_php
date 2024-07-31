<?php
require_once "conexao.php";

session_start();

if (!isset($_SESSION['id']) || $_SESSION['nivel_acesso'] != 'admin') {
	header("Location: login.php");
	exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$nome = $_POST['nome_usuario'];
	$email = $_POST['email_usuario'];
	$senha = password_hash($_POST['senha_usuario'], PASSWORD_BCRYPT);
	$nivel_acesso = $_POST['nivel_acesso'];

	// verificando se todos os campos fo formulario estão preenchidos
	if (empty($nome) || empty($email) || empty($senha) || empty($nivel_acesso)) {

		echo "Todos os campos devem ser preenchidos";
	} else {

		// verificando se o email já está cadastrado
		$sql_check_email = "SELECT COUNT(*) AS count FROM usuarios WHERE email = ?";
		$stmt_check_email = $conexao->prepare($sql_check_email);
		$stmt_check_email->bindParam(1, $email);
		$stmt_check_email->execute();
		$result = $stmt_check_email->fetch(PDO::FETCH_ASSOC);

		if ($result['count'] > 0) {
			echo "Esse email já está cadastrado";

		} else {

			$sql = "INSERT INTO usuarios(nome, email, senha, nivel_acesso) VALUES (?, ?, ?, ?)";
			$stmt = $conexao->prepare($sql);

			$stmt->bindParam(1, $nome);
			$stmt->bindParam(2, $email);
			$stmt->bindParam(3, $senha);
			$stmt->bindParam(4, $nivel_acesso);

			if ($stmt->execute()) {
				echo "...Usuario cadastrado com sucesso!";
				header("Location: dashboard.php");
			} else {
				echo "Erro: " . $stmt
				->errorInfo()[2];
			}
		}
	}

}


?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Registro de Usuário</title>
  </head>
  <body>
    
    <div class="container">
        <h1>Registro de Usuário</h1>
        <form method="post" action="">
            <div class="mb-3">
                <label for="nome_usuario" class="form-label">Nome:</label>
                <input type="text" class="form-control" id="nome_usuario" name="nome_usuario" required>
            </div>
            <div class="mb-3">
                <label for="email_usuario" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email_usuario" name="email_usuario" required>
            </div>
            <div class="mb-3">
                <label for="senha_usuario" class="form-label">Senha:</label>
                <input type="password" class="form-control" id="senha_usuario" name="senha_usuario" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nível de Acesso:</label><br>
                <input type="radio" id="user" name="nivel_acesso" value="user" required>
                <label for="user">Usuário</label><br>
                <input type="radio" id="admin" name="nivel_acesso" value="admin" required>
                <label for="admin">Administrador</label><br>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  </body>
</html>
