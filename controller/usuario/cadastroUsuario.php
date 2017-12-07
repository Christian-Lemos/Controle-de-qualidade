<?php
    include_once "../../model/Usuario.php";
    if(!isset($_SESSION))
    {
        session_start();
    }

    if(!isset($_SESSION['usuario']) || $_SESSION['usuario']->getAdmin() != true)
    {
        exit();
    }
    include_once "../../dao/UsuarioDAO.php";
    isset($_POST['admin']) ? $admin = true : $admin = false;

    try
    {
        $dao = new UsuarioDAO();
        $dao->AdicionarUsuario($_POST['login'], $_POST['nome'], $_POST['senha'], $_POST['email'], $admin);
        echo "sucesso";
    }
    catch(Exception $e)
    {
        $e->getMessage();
    }
?>