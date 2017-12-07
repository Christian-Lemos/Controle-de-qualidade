<?php
    include_once "../../model/Usuario.php";
    if(!isset($_SESSION))
    {
        session_start();
    }
    if(!isset($_SESSION['usuario']) || $_SESSION['usuario']->getAdmin() != true)
    {
        die();
    }
    include_once "../../dao/ProjetoDAO.php";
    try
    {
        $dao = new ProjetoDAO();
        $dao->AdicionarProjeto($_POST['nome'], $_POST['gerente'], $_POST['desenvolvedores'], $_POST['cadastro_projeto_contrato']);
        echo "sucesso";
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
    }
?>