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
    
    $resultado = $dao->getUsuariosFiltro($_GET['ordenacao'], $_GET['ordem'], $_GET['inicio'], $_GET['fim']);
    echo 
    '
        <table id = "visualisar_usuarios_table">
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
        <tr>
            <td>'.$usuario->getID().'</td>
            <td>'.$usuario->getLogin().'</td>
            <td>'.$usuario->getNome().'</td>
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