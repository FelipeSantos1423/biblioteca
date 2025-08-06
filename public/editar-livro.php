<?php
session_start();
require_once __DIR__ . '/../models/LivroRepository.php';
require_once __DIR__ . '/../models/Livro.php';

if (!isset($_SESSION['logado']) || !isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuario = unserialize($_SESSION['usuario']);
$pdo = new PDO("mysql:host=localhost;dbname=sua_base", "usuario", "senha"); // Ajuste aqui
$repo = new LivroRepository($pdo);

if (!isset($_GET['id'])) {
    die("ID do livro não informado.");
}

$livro = $repo->buscarPorId($_GET['id']);

// Verifica se o livro pertence ao usuário
if ($livro->getUsuarioId() !== $usuario->getId()) {
    die("Você não tem permissão para editar este livro.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Livro</title>
</head>
<body>
    <h2>Editar Livro</h2>
    <form action="../processa/processa_editar_livro.php" method="post">
        <input type="hidden" name="id" value="<?= $livro->getId(); ?>">

        <label>Título:</label>
        <input type="text" name="titulo" value="<?= htmlspecialchars($livro->getTitulo()); ?>" required><br>

        <label>Autor:</label>
        <input type="text" name="autor" value="<?= htmlspecialchars($livro->getAutor()); ?>" required><br>

        <label>Ano:</label>
        <input type="number" name="ano" value="<?= $livro->getAno(); ?>" required><br>

        <label>ISBN:</label>
        <input type="text" name="isbn" value="<?= htmlspecialchars($livro->getIsbn()); ?>" required><br>

        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>
