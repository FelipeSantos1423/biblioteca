<?php 
require_once 'Livro.php';
require_once(__DIR__ . '/../config/Database.php');

class LivroRepository {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function buscarPorTitulo($titulo) {
        $query = "SELECT * FROM tbl_livros WHERE titulo = :titulo";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':titulo', $titulo);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addLivro(Livro $livro) {
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
            throw new Exception("Erro ao inserir livro: " . $e->getMessage());
        }
    }

    public function listarTodos() {
        $stmt = $this->conn->prepare("SELECT * FROM tbl_livros");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Livro');
    }

    public function buscarPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM tbl_livros WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchObject('Livro');
    }

    public function atualizarLivro(Livro $livro) {
        try {
            $stmt = $this->conn->prepare("UPDATE tbl_livros SET titulo = ?, autor = ?, ano = ?, isbn = ? WHERE id = ?");
            return $stmt->execute([
                $livro->getTitulo(),
                $livro->getAutor(),
                $livro->getAno(),
                $livro->getIsbn(),
                $livro->getId()
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao atualizar livro: " . $e->getMessage());
            return false;
        }
    }

    public function excluir($id) {
        $stmt = $this->conn->prepare("DELETE FROM tbl_livros WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>