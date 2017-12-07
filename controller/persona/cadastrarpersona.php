<?php

    include_once "../../model/Usuario.php";
    if(!isset($_SESSION))
    {
        session_start();
    }

    if(!isset($_SESSION['usuario']) || $_SESSION['usuario']->getAdmin() == false)
    {
        exit();
    }
    include_once "../../dao/PersonaDAO.php";

    require_once("../../util/tinypng/lib/Tinify/Exception.php");
    require_once("../../util/tinypng/lib/Tinify/ResultMeta.php");
    require_once("../../util/tinypng/lib/Tinify/Result.php");
    require_once("../../util/tinypng/lib/Tinify/Source.php");
    require_once("../../util/tinypng/lib/Tinify/Client.php");
    require_once("../../util/tinypng/lib/Tinify.php");

    define('MB', 1048576);
    $target_dir = '../../uploads/'; 
    $_FILES['perfil']['name'] =  "persona_".md5(rand());
    $target_file = $target_dir . basename ($_FILES['perfil']['name']);
    $target_name = pathinfo($target_file, PATHINFO_FILENAME);
    $check = getimagesize($_FILES['perfil']['tmp_name']);

    if($check === false)
    {
        echo 'Arquivo não é uma imagem';
        exit();
    }
    $imageFileType = image_type_to_extension($check[2]);

    $target_size = $_FILES['perfil']['size'] / MB;
    if($target_size > 10*MB)
    {
        echo 'Arquivo muito grande';
        exit();
    }

    if($imageFileType != '.jpg' && $imageFileType  != '.jpeg' && $imageFileType != '.png' && $imageFileType != '.gif' && $imageFileType != '.svg')
    {
        echo 'Formato de imagem não suportado';
        exit();
    }

    \Tinify\setKey("TLQWkxJnzUSsBpro7Vce9eFYVVrCm2Zt");
    $source = \Tinify\fromFile($_FILES['perfil']['tmp_name']);
    $source->toFile($_FILES['perfil']['tmp_name']);
    if(move_uploaded_file($_FILES['perfil']['tmp_name'], $target_file.$imageFileType))
    {
        $dao = new PersonaDAO();
        $dao->AdicionarPersona($_POST['nome'], $_POST['descricao'], "uploads/".$_FILES['perfil']['name'].$imageFileType);
        echo "sucesso";
    }

    else
    {
        echo "Erro no upload da imagem";
    }
?>