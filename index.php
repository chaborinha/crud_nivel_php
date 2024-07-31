<?php

require_once 'conexao.php';
session_start();

if (!isset($_SESSION['id'])) {
	header("Location: login.php");
	exit();
}



echo "Seja bem vindo";