<?php
	include_once "../util/ConexaoBD.php";
	include_once "../model/Usuario.php";
	include_once "../model/InteradorDB.php";
	include_once "../dao/ProjetoDAO.php";

	session_start();

	if(!isset($_SESSION['usuario']) || $_SESSION['usuario']->getAdmin() != true)
	{
		die();
	}
	try
	{
		$con = ConexaoBD::CriarConexao();
		$dao = new ProjetoDAO($con);
		$dao->AdicionarProjeto($_POST['nome'], $_POST['gerente'], $_POST['desenvolvedores'], $_POST['cadastro_projeto_contrato']);
		echo "sucesso";
		unset($con);
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
	}


?>