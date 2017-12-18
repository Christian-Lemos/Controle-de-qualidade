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
    include_once '../../dao/ProjetoDAO.php';
    $dao = new ProjetoDAO();
    $resultado = $dao->getProjetosFiltroAvancada($_GET['ordenacao'], $_GET['ordem'], 0, 5, $_GET['pesquisa']);
    echo '
    <table id = "visualisar_usuarios_table" class = "visualizar_proj_usuario_table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Gerênte</th>
            <th>Data de início</th>
            <th>Data de término</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>';
    foreach ($resultado as $projeto)
    {
        echo 
        '
        <tr data-id = "'.$projeto->getID().'">
            <td>'.$projeto->getID().'</td>
            <td class = "visualizar_projeto_td_nome">'.$projeto->getNome().'</td>
            <td class = "visualizar_projeto_td_gerente">'.$projeto->getNomeGerente().'</td>
            <td class = "visualizar_projeto_td_datainicio">'.$projeto->getDataInicio().'</td>
            <td class = "visualizar_projeto_td_datatermino">'.$projeto->getDataTermino().'</td>
            <td>
                <div class = "editar_excluir_projeto_btn_div">
                    <button type="button" class= "editar_projeto_btn" data-id="'.$projeto->getID().'">Editar</button>
                    <button type="button" class= "excluir_projeto_btn" data-id="'.$projeto->getID().'">Excluir</button>
                </div>
            </td>
        </tr>
        ';
    }
    
    echo '</tbody> </table>';
?>
