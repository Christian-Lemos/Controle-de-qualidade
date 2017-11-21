<?php
	if(!isset($_SESSION))
	{
		session_start();
	}
	
	include_once "../util/ConexaoBD.php";
	include_once "../model/Usuario.php";
	include_once "../model/InteradorDB.php";
	include_once "../dao/UsuarioDAO.php";
	try
	{
$con = ConexaoBD::CriarConexao();
	$dao = new UsuarioDAO($con);
	$retorno = $dao->Autenticar($_POST['login'], $_POST['senha']);
	$_SESSION['usuario'] = $retorno;
	echo "sucesso";
	unset($con);
	}	
	
	catch(Exception $e)
	{
		echo $e->getMessage();
	}
?>