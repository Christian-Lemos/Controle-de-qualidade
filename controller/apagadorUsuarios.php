<?php
	include_once '../model/Usuario.php';
	session_start();


	if(!isset ($_SESSION['usuario']) || $_SESSION['usuario']->getAdmin() == false)
	{
		die();
	}


	include_once '../util/ConexaoBD.php';
	include_once "../model/InteradorDB.php";
	include_once '../dao/UsuarioDAO.php';
	try
	{
		$con = ConexaoBD::CriarConexao();
		$dao = new UsuarioDAO($con);
	
		$dao->removerUsuario($_POST['id']);
	
		echo "sucesso";
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
	}
	
?>