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
    $resultado = $dao->getProjetosFiltro($_GET['ordenacao'], $_GET['ordem'], $_GET['inicio'], $_GET['fim']);
    echo '
    <table id = "visualisar_usuarios_table">
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
        <tr>
            <td>'.$projeto->getID().'</td>
            <td>'.$projeto->getNome().'</td>
            <td>'.$projeto->getNomeGerente().'</td>
            <td>'.str_replace('-', '/', date('d-m-Y', strtotime($projeto->getDataInicio()))).'</td>
            <td>'.str_replace('-', '/', date('d-m-Y', strtotime($projeto->getDataTermino()))).'</td>
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
