<?php
	include_once '../util/ConexaoBD.php';
	include_once '../model/Usuario.php';
	include_once "../model/InteradorDB.php";
	include_once '../dao/UsuarioDAO.php';
	include_once '../model/Erro.php';
	
	$con = ConexaoBD::CriarConexao();
	$dao = new UsuarioDAO($con);
	session_start();

	$retorno = $dao->removerUsuario($_POST['id']);

	if(get_class($retorno) == "Erro")
	{
		echo $retorno->getMensagem();
	}
	else
	{
		echo "sucesso";
	}

?>