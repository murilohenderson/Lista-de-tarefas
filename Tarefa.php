<?php
    class Tarefa {
        private $nome;
        private $descricao;
        private $urgencia;
        

        public function __construct($nome, $descricao, $urgencia)
        {
                $this->nome = $nome;
                $this->descricao = $descricao;
                $this->urgencia = $urgencia;
        }


        public function getNome()
        {
                return $this->nome;
        }
        public function setNome($nome)
        {
                $this->nome = $nome;

                return $this;
        }
        public function getDescricao()
        {
                return $this->descricao;
        }
        public function setDescricao($descricao)
        {
                $this->descricao = $descricao;

                return $this;
        }
        public function getUrgencia()
        {
                return $this->urgencia;
        }
        public function setUrgencia($ugencia)
        {
                $this->urgencia = $ugencia;

                return $this;
        }
    }
    

?>