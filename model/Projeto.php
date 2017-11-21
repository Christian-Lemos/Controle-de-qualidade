<?php

class Projeto
{
	private $id;
	private $nome;
	private $gerente;
	private $nomegerente;
	private $dataInicio;
	private $dataTermino;
	private $desenvolvedores;

	public function __construct($id, $nome, $gerente, $nomegerente, $dataInicio, $dataTermino, $desenvolvedores)
	{
		$this->id = $id;
		$this->nome = $nome;
		$this->gerente = $gerente;
		$this->nomegerente = $nomegerente;
		$dataInicio = date('d-m-Y', strtotime($dataInicio));
		$dataInicio = str_replace('-', '/', $dataInicio);
		$dataTermino = date('d-m-Y', strtotime($dataTermino));
		$dataTermino = str_replace('-', '/', $dataTermino);
		$this->dataInicio = $dataInicio;
		$this->dataTermino = $dataTermino;
		$this->desenvolvedores = $desenvolvedores;
	}
	
	
	public function getID()
	{
		return $this->id;
	}
	
	public function getNome()
	{
		return $this->nome;
	}

	public function getGerente()
	{
		return $this->gerente;
	}
	
	public function getNomeGerente()
	{
		$this->nomegerente;
	}
	
	public function getDataInicio()
	{
		return $this->dataInicio;
	}

	public function getDataTermino()
	{
		return $this->dataTermino;
	}

	public function getDesenvolvedores()
	{
		return $this->desenvolvedores;
	}

}

?>
