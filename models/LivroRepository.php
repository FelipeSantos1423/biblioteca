<?php
require_once 'Livro.php';
require_once(__DIR__ . '/../config/Database.php');


class LivroRepository {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

 // Busca um usuário pelo email
    public function buscarPorTitulo($titulo) {
        $query = "SELECT * FROM tbl_livros WHERE titulo = :titulo";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':titulo', $titulo);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Adiciona um novo usuário ao banco de dados
   public function AddLivro(Livro $livro) {
    $query = "INSERT INTO tbl_livros (titulo, autor, ano, isbn) 
              VALUES (:titulo, :autor, :ano, :isbn)";
    try {
        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(':titulo', $livro->getTitulo());
        $stmt->bindValue(':autor', $livro->getAutor());
        $stmt->bindValue(':ano', $livro->getAno());
        $stmt->bindValue(':isbn', $livro->getIsbn());

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    } catch (PDOException $e) {
        throw new Exception("Erro ao inserir usuário: " . $e->getMessage());
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////
    // Busca usuário pelo ID e retorna objeto Usuario ou null
    public function buscarPorId($id) {
        $query = "SELECT * FROM tbl_usuario WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return new Livro($data);
        }
        return null;
    }

    // Atualiza só o email do usuário pelo ID
    public function atualizarEmail($id, $email) {
        $query = "UPDATE tbl_usuario SET email = :email WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Atualiza email e senha do usuário pelo ID
    public function atualizarEmailSenha($id, $email, $senha) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $query = "UPDATE tbl_usuario SET email = :email, senha_hash = :senha_hash WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha_hash', $senha_hash);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Exclui usuário pelo ID
    public function excluir($id) {
        $query = "DELETE FROM tbl_usuario WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
