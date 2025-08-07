<?php
require_once(__DIR__ . '/../../models/Livro.php');
require_once(__DIR__ . '/../../models/LivroRepository.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $autor = $_POST['autor'] ?? '';
    $ano = $_POST['ano'] ?? '';
    $isbn = $_POST['isbn'] ?? '';

    // Validações simples
    if (empty($titulo) || empty($autor) || empty($ano) || empty($isbn)) {
        die('Preencha todos os campos.');
    }

    $livroRepository = new LivroRepository();

    // Verifica se autor já existe
    if ($livroRepository->buscarPorTitulo($titulo)) {
        die('livro já cadastrado.');
    }

    // Cria objeto usuário
    $livro = new Livro();
    $livro->setTitulo($titulo);
    $livro->setAutor($autor);
    $livro->setAno($ano);
    $livro->setIsbn($isbn);

    try {
        $id = $livroRepository->AddLivro($livro);
        if ($id) {
            echo "Livro cadastrado com sucesso! ID: $id <br>";
             echo 'Ir para página de <a href="../exibe-dados.php">exibição de dados</a>';
        } else {
            echo "Erro ao cadastrar Livro. Tente novamente mais tarde.";
        }
    }catch (Exception $e) {
    error_log('Erro no cadastro de Livro: ' . $e->getMessage());
    // Mostra o erro detalhado (apenas para teste, remova depois)
    die("Erro no cadastro: " . $e->getMessage());
}

} else {
    echo "Método inválido.";
}
?>
