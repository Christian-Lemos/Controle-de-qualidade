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
    
    include_once '../../dao/ProjetoDAO.php';
    try
    {
        $con = ConexaoBD::CriarConexao();
        $dao = new ProjetoDAO($con);
        $dao->removerProjeto($_POST['id']);
        echo "sucesso";
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
    }
?>