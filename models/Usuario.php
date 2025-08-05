<?php

class Usuario {
    private $id;
    private $email;
    private $nomeC;
    private $senha_hash;
    private $created_at;

    public function __construct($data = null) {
        if ($data) {
            $this->id = $data['id'] ?? null;
            $this->nomeC = $data['nomeC'] ?? null;
            $this->email = $data['email'] ?? null;
            $this->senha_hash = $data['senha_hash'] ?? null;
            $this->created_at = $data['created_at'] ?? null;
        }
    }

    // Getters e Setters
    public function getId() { return $this->id; }
    public function getEmail() { return $this->email; }
    public function getNomeC() { return $this->nomeC; }
    public function getSenhaHash() { return $this->senha_hash; }
    public function getCreatedAt() { return $this->created_at; }

    public function setNomeC($nomeC) { $this->nomeC = $nomeC; }
    public function setEmail($email) { $this->email = $email; }
    public function setSenhaHash($senha_hash) { $this->senha_hash = $senha_hash; }
}

?>