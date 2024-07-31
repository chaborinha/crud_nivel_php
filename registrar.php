<?php
require_once "conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$nome = $_POST['nome_usuario'];
	$email = $_POST['email_usuario'];
	$senha = password_hash($_POST['senha_usuario'], PASSWORD_BCRYPT);
	$nivel_acesso = 'user';

	// verificando se todos os campos foram prenchidos
	if (empty($nome) || empty($email) || empty($senha)) {

		echo "Todos os camos devem ser preenchidos!";

	} else {

		// verificando se o email já esta cadastrado
		$sql_check_email = "SELECT COUNT(*) AS count FROM usuarios WHERE email = ?";
		$stmt_check_email = $conexao->prepare($sql_check_email);
		$stmt_check_email->bindParam(1, $email);
		$stmt_check_email->execute();
		$result = $stmt_check_email->fetch(PDO::FETCH_ASSOC);

		if ($result['count'] > 0) {
			echo "Esse email já está cadastrado";

		} else {


			$sql = "INSERT INTO usuarios (nome, email, senha, nivel_acesso) VALUES (?, ?, ?, ?)";
			$stmt = $conexao->prepare($sql);

			$stmt->bindParam(1, $nome);
			$stmt->bindParam(2, $email);
			$stmt->bindParam(3, $senha);
			$stmt->bindParam(4, $nivel_acesso);

			if ($stmt->execute()) {

				echo "Novo usuário cadastrado com sucesso";

			} else {

				echo "Erro: " . $stmt
				->errorInfo()[2];
			}
		  }
		}
	}
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    
    <form method="post" action="">
    	Nome: <input type="text" name="nome_usuario" id="nome_usuario" > <hr>
    	Email: <input type="email" name="email_usuario" id="email_usuario" > <hr>
    	Senha: <input type="password" name="senha_usuario" id="senha_usuario" > <hr>
    	<input type="submit" value="Registrar">
    </form>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
   
  </body>
</html>