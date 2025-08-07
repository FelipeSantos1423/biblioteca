<?php
session_start();
require_once __DIR__ . '/../../models/LivroRepository.php';

if (!isset($_SESSION['logado']) || !isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID do livro não informado.";
    exit;
}

$id = (int) $_GET['id'];

$livroRepo = new LivroRepository();
$excluiu = $livroRepo->excluir($id);

if ($excluiu) {
    header('Location: ../exibe-dados.php?msg=livro_excluido');
    exit;
} else {
    echo "Erro ao excluir o livro.";
}
