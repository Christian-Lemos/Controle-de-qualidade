<?php

class Projeto
{
	private $id;
	private $gerente;
	private $dataInicio;
	private $dataTermino;
	private $desenvolvedores;

	public function __construct($id, $gerente, $dataInicio, $dataTermino, $desenvolvedores)
	{
		$this->id = $id;
		$this->gerente = $gerente;
		$this->dataInicio = $dataInicio;
		$this->dataTermino $dataTermino;
		$this->desenvolvedores = $desenvolvedores;
	}


	public function getID()
	{
		return $this->id;
	}

	public function getGerente()
	{
		return $this->gerente;
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
