<?php
    if(!isset($_SESSION))
    {
        session_start();
    }

    include_once "../../model/Usuario.php";
    include_once "../../dao/UsuarioDAO.php";
    try
    {
        $dao = new UsuarioDAO();
        $retorno = $dao->Autenticar($_POST['login'], $_POST['senha']);
        $_SESSION['usuario'] = $retorno;
        echo "sucesso";
    }	

    catch(Exception $e)
    {
        echo $e->getMessage();
    }
?>