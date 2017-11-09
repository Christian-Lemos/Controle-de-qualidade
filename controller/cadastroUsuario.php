<?php
	include_once "../util/ConexaoBD.php";
	include_once "../model/Usuario.php";
		include_once "../model/InteradorDB.php";
	include_once "../dao/UsuarioDAO.php";
	include_once "../model/Erro.php";
	if(!isset($_SESSION))
	{
		session_start();
	}

	if(!isset($_SESSION['usuario']) || $_SESSION['usuario']->getAdmin() != true)
	{
		exit();
	}

	isset($_POST['admin']) ? $admin = true : $admin = false;

	$con = ConexaoBD::CriarConexao();
	$dao = new UsuarioDAO($con);
	$retorno = $dao->AdicionarUsuario($_POST['login'], $_POST['nome'], $_POST['senha'], $_POST['email'], $admin);
	if($retorno == null)
	{
		echo "sucesso";
	}
	else
	{
		echo $retorno->getMensagem();
	}

?>