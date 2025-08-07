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
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .action-link {
            transition: all 0.3s ease;
        }
        .action-link:hover {
            color: #3b82f6;
        }
        .avatar-placeholder {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-book-open mr-2 text-blue-500"></i> Biblioteca Digital
            </h1>
            <div class="flex items-center space-x-4">
                <a href="logout.php" class="flex items-center text-gray-600 hover:text-blue-500 transition-colors">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    <span class="hidden md:inline">Sair</span>
                </a>
            </div>
        </header>

        <!-- User Profile Section -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="md:flex">
                <div class="avatar-placeholder md:w-1/4 flex items-center justify-center p-8 text-white">
                    <div class="text-center">
                        <div class="w-24 h-24 rounded-full bg-white bg-opacity-20 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-user text-4xl"></i>
                        </div>
                        <h2 class="text-xl font-semibold"><?= htmlspecialchars($usuario->getNomeC()); ?></h2>
                        <p class="text-sm opacity-80">Membro desde <?= date('Y') ?></p>
                    </div>
                </div>
                <div class="p-8 md:w-3/4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Informações Pessoais</h3>
                            <div class="mt-2 space-y-2">
                                <p class="flex items-center">
                                    <i class="fas fa-user mr-2 text-blue-500"></i>
                                    <span class="font-medium"><?= htmlspecialchars($usuario->getNomeC()); ?></span>
                                </p>
                                <p class="flex items-center">
                                    <i class="fas fa-envelope mr-2 text-blue-500"></i>
                                    <span class="font-medium"><?= htmlspecialchars($usuario->getEmail()); ?></span>
                                </p>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Ações da Conta</h3>
                            <div class="mt-2 space-y-3">
                                <a href="editar-usuario.php" class="action-link flex items-center text-gray-700">
                                    <i class="fas fa-user-edit mr-2"></i> Editar minha conta
                                </a>
                                <a href="process/process_excluir_usuario.php" onclick="return confirm('Tem certeza que deseja excluir sua conta?');" class="action-link flex items-center text-gray-700">
                                    <i class="fas fa-user-times mr-2"></i> Excluir minha conta
                                </a>
                                <a href="cadastro-livro.php" class="action-link flex items-center text-blue-500 font-medium">
                                    <i class="fas fa-plus-circle mr-2"></i> Cadastrar novo livro
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Books Section -->
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-book mr-2 text-blue-500"></i> Meus Livros
            </h2>
            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                <?= count($livros) ?> livro(s)
            </span>
        </div>

        <?php if (empty($livros)): ?>
            <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                <i class="fas fa-book-open text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-700 mb-2">Nenhum livro cadastrado</h3>
                <p class="text-gray-500 mb-4">Você ainda não cadastrou nenhum livro em sua biblioteca.</p>
                <a href="cadastro-livro.php" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                    <i class="fas fa-plus mr-2"></i> Adicionar primeiro livro
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($livros as $livro): ?>
                    <div class="book-card bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 mb-1"><?= htmlspecialchars($livro->getTitulo()); ?></h3>
                                    <p class="text-gray-600"><?= htmlspecialchars($livro->getAutor()); ?></p>
                                </div>
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    <?= htmlspecialchars($livro->getAno()); ?>
                                </span>
                            </div>
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <i class="fas fa-barcode mr-2"></i>
                                <span>ISBN: <?= htmlspecialchars($livro->getIsbn()); ?></span>
                            </div>
                            <div class="flex space-x-3">
                                <a href="editar-livro.php?id=<?= $livro->getId(); ?>" class="flex-1 text-center py-2 px-4 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                    <i class="fas fa-edit mr-2"></i> Editar
                                </a>
                                <a href="process/process_excluir_livro.php?id=<?= $livro->getId(); ?>" onclick="return confirm('Tem certeza que deseja excluir este livro?');" class="flex-1 text-center py-2 px-4 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors">
                                    <i class="fas fa-trash-alt mr-2"></i> Excluir
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-6 mt-12">
        <div class="container mx-auto px-4 text-center text-gray-500 text-sm">
            <p>© <?= date('Y') ?> Biblioteca Digital. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>
