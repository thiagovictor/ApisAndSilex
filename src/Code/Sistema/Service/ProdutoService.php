<?php

namespace Code\Sistema\Service;

use Code\Sistema\Mapper\ProdutoMapper;
use Code\Sistema\Entity\Produto;

class ProdutoService {

    private $mapper;
    private $produto;

    public function __construct(ProdutoMapper $mapper, Produto $produto) {
        $this->mapper = $mapper;
        $this->produto = $produto;
    }

    private function popular(array $data = array()) {
        foreach ($data as $metodo => $valor) {
            $metodo = 'set' . ucfirst($metodo);
            if (!method_exists($this->produto, $metodo)) {
                return false;
            }
            $this->produto->$metodo($valor);
        }
        return $this->produto;
    }

    public function insert(array $data = array()) {
        if ($this->popular($data)) {
            return $this->mapper->insert($this->produto);
        }
        return false;
    }

    public function update(array $data = array()) {
        if ($this->popular($data)) {
            return $this->mapper->update($this->produto);
        }
        return false;
    }

    public function delete($id) {
        return $this->mapper->delete($id);
    }
    
    public function findAll() {
        return $this->mapper->findAll();
    }

}
