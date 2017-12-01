<?php
	include_once '../model/Usuario.php';
        if(!isset($_SESSION))
        {
            session_start();
        }

	if(!isset ($_SESSION['usuario']) || $_SESSION['usuario']->getAdmin() == false)
	{
            die();
	}

	include_once '../util/ConexaoBD.php';
	include_once "../model/InteradorDB.php";
	include_once '../dao/PersonaDAO.php';
        
	try
	{
            $con = ConexaoBD::CriarConexao();
            $dao = new PersonaDAO($con);

            $dao->removerPersona($_POST['id']);
            echo "Persona removida com sucesso";
	}
	catch(Exception $e)
	{
            echo $e->getMessage();
	}
	

?>