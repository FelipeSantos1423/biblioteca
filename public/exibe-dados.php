<?php
session_start();
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/LivroRepository.php';

if (!isset($_SESSION['logado']) || !isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuario = unserialize($_SESSION['usuario']);

$livroRepo = new LivroRepository();
$livros = $livroRepo->listarTodos(); // Exibe todos os livros, como você queria
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/exibe.css">
    <title>Dados do Usuário</title>
</head>
<body>
    <h1>Dados do Usuário</h1>

    <h3>Nome Completo: <?= htmlspecialchars($usuario->getNomeC()); ?></h3>
    <h3>Email: <?= htmlspecialchars($usuario->getEmail()); ?></h3>

    <h3>
        Ações:
        <a href="editar-usuario.php">Editar minha conta</a> |
        <a href="process/process_excluir_usuario.php" onclick="return confirm('Tem certeza que deseja excluir sua conta?');">Excluir minha conta</a>
    </h3>

    <h3>
        Sair da conta: <a href="logout.php">Logout</a>
    </h3>

    <h3>
        Cadastrar Livro: <a href="cadastro-livro.php">Cadastrar</a>
    </h3>

    <h2>📚 Livros Cadastrados:</h2>

    <?php if (empty($livros)): ?>
        <p>Você ainda não cadastrou nenhum livro.</p>
    <?php else: ?>
        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Ano</th>
                    <th>ISBN</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($livros as $livro): ?>
                    <tr>
                        <td><?= htmlspecialchars($livro->getTitulo()); ?></td>
                        <td><?= htmlspecialchars($livro->getAutor()); ?></td>
                        <td><?= htmlspecialchars($livro->getAno()); ?></td>
                        <td><?= htmlspecialchars($livro->getIsbn()); ?></td>
                        <td>
                            <a href="editar-livro.php?id=<?= $livro->getId(); ?>">Editar</a> |
                            <a href="process/process_excluir_livro.php?id=<?= $livro->getId(); ?>" onclick="return confirm('Tem certeza que deseja excluir este livro?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
