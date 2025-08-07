<?php
session_start();
require_once __DIR__ . '/../../models/LivroRepository.php';

if (!isset($_SESSION['logado'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $titulo = trim($_POST['titulo']);
    $autor = trim($_POST['autor']);
    $ano = (int) $_POST['ano'];
    $isbn = trim($_POST['isbn']);

    // Validações básicas
    if (empty($titulo) || empty($autor) || empty($ano) || empty($isbn)) {
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

    $atualizou = $livroRepo->atualizar($livro);

    if ($atualizou) {
    header('Location: ../exibe-dados.php?msg=livro_atualizado');
    exit;
} else {
    echo "Erro ao atualizar o livro.";
}

}
