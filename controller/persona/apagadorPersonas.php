<?php
	include_once '../../model/Usuario.php';
        if(!isset($_SESSION))
        {
            session_start();
        }

	if(!isset ($_SESSION['usuario']) || $_SESSION['usuario']->getAdmin() == false)
	{
            die();
	}

	include_once '../../dao/PersonaDAO.php';
        
	try
	{
            $dao = new PersonaDAO();
            $dao->removerPersona($_POST['id']);
            echo "Persona removida com sucesso";
	}
	catch(Exception $e)
	{
            echo $e->getMessage();
	}
	

?>