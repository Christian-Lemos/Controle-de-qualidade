<?php
	include_once "../../model/Usuario.php";
	session_start();
	if(!isset($_SESSION['usuario']) || $_SESSION['usuario']->getAdmin() != true)
	{
            exit();
	}
?>

<h2>Usuários</h2>
<div id="escolher-opc-btn-div">
    <div class="escolher-opc-btn eq-opc-btn-ativo" id = "opc-cad-user">
            Cadastrar Usuários
    </div>
    <div class="escolher-opc-btn" id = "opc-view-user">
            Visualizar Usuários
    </div>
</div>
<div id = "usuario_view">
</div>
<script type="text/javascript" src = "js/opcoes_usuario.js"></script>

