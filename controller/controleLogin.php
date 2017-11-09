<?php
	if(!isset($_SESSION))
	{
		session_start();
	}
	
	include_once "../util/ConexaoBD.php";
	include_once "../model/Usuario.php";
	include_once "../dao/UsuarioDAO.php";
	include_once "../model/Erro.php";
	$con = ConexaoBD::CriarConexao();
	$dao = new UsuarioDAO($con);
	$retorno = $dao->Autenticar($_POST['login'], $_POST['senha']);


	if(get_class($retorno) == "Usuario")
	{
		$_SESSION['usuario'] = $retorno;
		echo "sucesso";

	}
	else if(get_class($retorno) == "Erro")
	{
		echo $retorno->getMensagem();
	}


	unset($con);


?>