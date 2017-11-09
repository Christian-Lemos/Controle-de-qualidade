<?php
	class Erro
	{
		private $codigo;
		private $mensagem;

		public function __construct($codigo, $mensagem)
		{
			$this->codigo = $codigo;
			$this->mensagem = $mensagem;
		}

		public function getCodigo()
		{
			return $this->codigo;
		}
		public function getMensagem()
		{
			return $this->mensagem;
		}
	}
	
?>