<?php
require_once 'Usuario.php';
require_once '../config/Database.php';

class UsuarioDAO {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Busca um usuário pelo email
    public function buscarPorEmail($email) {
        $query = "SELECT * FROM usuario WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Valida o login
    public function validarLogin($email, $senha) {
        $usuario = $this->buscarPorEmail($email);
        if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
            return new Usuario($usuario); // Cria objeto Usuario
        }
        return null;
    }

    public function cadastrar($email, $senha) {
    // Verifica se já existe um usuário com esse e-mail
    if ($this->buscarPorEmail($email)) {
        return false; // E-mail já cadastrado
    }

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Insere o usuário no banco
    $query = "INSERT INTO usuario (email, senha_hash) VALUES (:email, :senha_hash)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha_hash', $senha_hash);

    return $stmt->execute(); // true se cadastrou, false se erro
}

public function buscarPorId($id) {
    $query = "SELECT * FROM usuario WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        return new Usuario($data);
    }
    return null;
}

// Atualiza só o email
public function atualizarEmail($id, $email) {
    $query = "UPDATE usuario SET email = :email WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

// Atualiza email e senha
public function atualizarEmailSenha($id, $email, $senha) {
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $query = "UPDATE usuario SET email = :email, senha_hash = :senha_hash WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha_hash', $senha_hash);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

public function excluir($id) {
    $query = "DELETE FROM usuario WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

}