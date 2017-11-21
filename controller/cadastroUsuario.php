<?php
	include_once "../util/ConexaoBD.php";
	include_once "../model/Usuario.php";
	include_once "../model/InteradorDB.php";
	include_once "../dao/UsuarioDAO.php";
	
	if(!isset($_SESSION))
	{
		session_start();
	}

	if(!isset($_SESSION['usuario']) || $_SESSION['usuario']->getAdmin() != true)
	{
		exit();
	}

	isset($_POST['admin']) ? $admin = true : $admin = false;

	try
	{
	
		$con = ConexaoBD::CriarConexao();
		$dao = new UsuarioDAO($con);
		$dao->AdicionarUsuario($_POST['login'], $_POST['nome'], $_POST['senha'], $_POST['email'], $admin);
		echo "sucesso";
	}
	catch(Exception $e)
	{
		$e->getMessage();
	}


?>