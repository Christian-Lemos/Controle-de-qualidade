<?php
	include_once '../util/ConexaoBD.php';

	include_once '../model/Usuario.php';

	include_once '../dao/UsuarioDAO.php';

	include_once '../model/Erro.php';


	$con = ConexaoBD::CriarConexao();

	$dao = new UsuarioDAO($con);
	session_start();


	switch ($_POST['campo']) 
	{
		case 'login':
			$retorno = $dao->AtualizarLogin($_POST['id'], $_POST['novo']);
			if(get_class($retorno) == "Erro")
			{
				echo $retorno->getMensagem();
			}
			else
			{
				echo "sucesso";
			}
			break;
		case 'nome':
			$dao->AtualizarNome($_POST['id'], $_POST['novo']);
			echo "sucesso";
			break;
		case 'email':
			$retorno = $dao->AtualizarEmail($_POST['id'], $_POST['novo']);

			if(get_class($retorno) == "Erro")
			{
				echo $retorno->getMensagem();
			}
			else
			{
				echo "sucesso";
			}
			break;
		case 'senha':
			$retorno = $dao->AtualizarSenha($_POST['id'], $_POST['novo']);

			if(get_class($retorno) == "Erro")
			{
				echo $retorno->getMensagem();
			}
			else
			{
				echo "sucesso";
			}
			break;
		case 'admin':
			$retorno = $dao->AtualizarAdmin($_POST['id'], $_POST['novo']);
			if(get_class($retorno) == "Erro")
			{
				echo $retorno->getMensagem();
			}
			else
			{
				echo "sucesso";
			}
			break;
	}

?>