<?php
class Livro {
    private $id;
    private $titulo;
    private $autor;
    private $ano;
    private $isbn; 
    
    public function __construct($data = null) {
        if ($data) {
            $this->id = $data['id'] ?? null;
            $this->titulo = $data['titulo'] ?? null;
            $this->autor = $data['autor'] ?? null;
            $this->ano = $data['ano'] ?? null;
            $this->isbn = $data['isbn'] ?? null;
        }
    }

    public function getId() { return $this->id; }
    public function getTitulo() { return $this->titulo; }
    public function getAutor() { return $this->autor; }
    public function getAno() { return $this->ano; }
    public function getIsbn() { return $this->isbn; }

    public function setTitulo($titulo) { $this->titulo = $titulo; }
    public function setAutor($autor) { $this->autor = $autor; }
    public function setAno($ano) { $this->ano = $ano; }
    public function setIsbn($isbn) { $this->isbn = $isbn; }
}
?>
