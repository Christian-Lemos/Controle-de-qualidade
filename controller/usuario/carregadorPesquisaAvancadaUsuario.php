<?php
    include_once "../../model/Usuario.php";

    if(!isset($_SESSION))
    {
        session_start();
    }

    if(!isset($_SESSION['usuario']) || $_SESSION['usuario']->getAdmin() == false)
    {
        die();
    }
    
    include_once '../../dao/UsuarioDAO.php';
    $dao = new UsuarioDAO();
    
    $resultado = $dao->getUsuariosFiltroAvancado($_GET['ordenacao'], $_GET['ordem'], 0, 5, $_GET['pesquisa']);
    echo 
    '
        <table id = "visualisar_usuarios_table" class = "visualizar_proj_usuario_table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Login</th>
                <th>Nome</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
    ';
    
    foreach($resultado as $usuario)
    {
        echo 
        '
        <tr data-id = "'.$usuario->getID().'">
            <td>'.$usuario->getID().'</td>
            <td class = "visualizar_usuario_td_login">'.$usuario->getLogin().'</td>
            <td class = "visualizar_usuario_td_nome">'.$usuario->getNome().'</td>
            <td>
                <div class = "editar_excluir_usuario_btn_div">
                    <button type="button" class= "editar_usuario_btn" data-id="'.$usuario->getID().'">Editar</button>
                    <button type="button" class= "excluir_usuario_btn" data-id="'.$usuario->getID().'">Excluir</button>
                </div>
            </td>
        </tr>
        ';
    }
    echo '</tbody></table>';
?>