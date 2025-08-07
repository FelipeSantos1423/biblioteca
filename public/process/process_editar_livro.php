<?php
session_start();
require_once __DIR__ . '/../../models/LivroRepository.php';

// Verifica se está logado antes de processar
if (!isset($_SESSION['logado'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $titulo = trim($_POST['titulo'] ?? '');
    $autor = trim($_POST['autor'] ?? '');
    $ano = (int) ($_POST['ano'] ?? 0);
    $isbn = trim($_POST['isbn'] ?? '');

    if (empty($id) || empty($titulo) || empty($autor) || empty($ano) || empty($isbn)) {
        echo "Todos os campos são obrigatórios.";
        exit;
    }

    $livroRepo = new LivroRepository();
    $livro = $livroRepo->buscarPorId($id);

    if (!$livro) {
        echo "Livro não encontrado.";
        exit;
    }

    $livro->setTitulo($titulo);
    $livro->setAutor($autor);
    $livro->setAno($ano);
    $livro->setIsbn($isbn);

    $atualizou = $livroRepo->atualizarLivro($livro);

    if ($atualizou) {
        header('Location: ../exibe-dados.php?msg=livro_atualizado');
        exit;
    } else {
        echo "Erro ao atualizar livro.";
    }
} else {
    // Se o método não for POST, redireciona para a página de edição
    $id = $_GET['id'] ?? '';
    header('Location: ../editar-livro.php?id=' . urlencode($id));
    exit;
}
?>
