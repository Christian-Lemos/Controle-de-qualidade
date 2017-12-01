<?php
	class Persona
	{
		private $id;
		private $nome;
		private $descricao;
		private $imagem;

		public function __construct($id, $nome, $descricao, $imagem)
		{
			$this->id = $id;
			$this->nome = $nome;
			$this->descricao = $descricao;

			$this->imagem = $imagem;
		}

		public function getID()
		{
			return $this->id;
		}

		public function getNome()
		{
			return $this->nome;
		}

		public function getDescricao()
		{
			return $this->descricao;
		}
		public function getImagem()
		{
			return $this->imagem;
		}

	}
?>