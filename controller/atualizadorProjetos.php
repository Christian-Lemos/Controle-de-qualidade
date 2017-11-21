<?php
	include_once '../model/Usuario.php';
	if(!isset($_SESSION))
	{
		session_start();
	}
	
	if(!isset($_SESSION['usuario']) || $_SESSION['usuario']->getAdmin() == false)
	{
		die();
	}
	
	include_once '../util/ConexaoBD.php';
	include_once '../model/InteradorDB.php';
	include_once '../dao/ProjetoDAO.php';

	$con = ConexaoBD::CriarConexao();
	$dao = new ProjetoDAO($con);
	try
	{
		switch ($_POST['campo']) 
		{
			case 'nome':
				$dao->AtualizarNome($_POST['id'], $_POST['nome_novo']); 
				break;
			case 'gerente':
				$dao->AtualizarGerente($_POST['id'], $_POST['gerente']);
				break;
			case 'desenvolvedores':
				$dao->AtualizarDesenvolvedores($_POST['id'], $_POST['desenvolvedores']);
				break;
			case 'datainicio':
				$dao->AtualizarDataInicio($_POST['id'], $_POST['edit_projeto_form_contrato_novo']);
				break;
			case 'datatermino':
				$dao->AtualizarDataTermino($_POST['id'], $_POST['edit_projeto_form_aceite_novo']);
				break;
		}
		echo "sucesso";
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
	}
	

?>