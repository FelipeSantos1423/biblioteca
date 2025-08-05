<?php
session_start();
require_once __DIR__ . '/../models/Usuario.php';

if (!isset($_SESSION['logado']) || !isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuario = unserialize($_SESSION['usuario']);
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/exibe.css">
    <title>Dados do Usuário</title>
</head>
<body>
    <h1>Dados do Usuário:</h1>
    <h3>Email: <?= htmlspecialchars($usuario->getEmail()); ?></h3>
    <h3>Ações:  <a href="excluir-usuario.php" onclick="return confirm('Tem certeza que deseja excluir sua conta?');">Excluir minha conta</a>
     <a href="editar-usuario.php">Editar minha conta</a></h3>
   <h3>Sair da conta:  <a href="logout.php">Logout</a>
   <h3>Cadastrar Livro: <a href="cadastro-livro.php">Cadastrar</a></h3>
</h3>
  
</body>
</html>
