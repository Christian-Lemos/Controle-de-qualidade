<?php
	include_once "../util/ConexaoBD.php";
	include_once "../model/Erro.php";
	include_once "../model/Usuario.php";
	include_once "../model/InteradorDB.php";
	include_once "../dao/ProjetoDAO.php";

	session_start();

	if(!isset($_SESSION['usuario']) || $_SESSION['usuario']->getAdmin() != true)
	{
		die();
	}

	$con = ConexaoBD::CriarConexao();
	$dao = new ProjetoDAO($con);
	$resultado = $dao->AdicionarProjeto($_POST['nome'], $_POST['gerente'], $_POST['desenvolvedores'], $_POST['cadastro_projeto_contrato']);
	unset($con);

	if($resultado != null)
	{
		echo $resultado->getMensagem();
	}
	else
	{
		echo "sucesso";
	}


?>