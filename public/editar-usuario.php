<?php
session_start();
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/UsuarioDAO.php';

if (!isset($_SESSION['logado']) || !isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuario = unserialize($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/editar-usuario.css">
    <title>Editar Usuário</title>
</head>
<body>
    <form method="post" action="process/process-editar.php">
        <h2>Editar Usuário</h2>
        <input type="hidden" name="id" value="<?= $usuario->getId() ?>">

        <label>Nome completo:</label><br>
        <input type="text" name="nomeC" required value="<?= htmlspecialchars($usuario->getNomeC()) ?>"><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required value="<?= htmlspecialchars($usuario->getEmail()) ?>"><br><br>

        <label>Nova Senha (deixe vazio para manter a atual):</label><br>
        <input type="password" name="senha"><br><br>

        <button type="submit">Salvar Alterações</button>
    </form>
    
</body>
</html>
