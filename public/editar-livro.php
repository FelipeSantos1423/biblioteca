<?php
session_start();
require_once __DIR__ . '/../models/LivroRepository.php';

if (!isset($_SESSION['logado']) || !isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID do livro não informado.";
    exit;
}

$id = (int) $_GET['id'];

$livroRepo = new LivroRepository();
$livro = $livroRepo->buscarPorId($id);

if (!$livro) {
    echo "Livro não encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Livro</title>
</head>
<body>
    <form method="post" action="process/process-editar-livro.php">
        <h2>Editar Livro</h2>
        <input type="hidden" name="id" value="<?= $livro->getId() ?>">

        <label>Título:</label><br>
        <input type="text" name="titulo" required value="<?= htmlspecialchars($livro->getTitulo()) ?>"><br><br>

        <label>Autor:</label><br>
        <input type="text" name="autor" required value="<?= htmlspecialchars($livro->getAutor()) ?>"><br><br>

        <label>Ano:</label><br>
        <input type="number" name="ano" required value="<?= htmlspecialchars($livro->getAno()) ?>"><br><br>

        <label>ISBN:</label><br>
        <input type="text" name="isbn" required value="<?= htmlspecialchars($livro->getIsbn()) ?>"><br><br>

        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>
