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
?>

<h2>Projetos</h2>
<div id="escolher-opc-btn-div">
	<div class="escolher-opc-btn eq-opc-btn-ativo" id = "opc-cad-proj">
		Cadastrar Projetos
	</div>
	<div class="escolher-opc-btn" id = "opc-view-proj">
		Visualizar Projetos
	</div>

</div>
<div id = "projeto_view">
</div>
<script type="text/javascript" src = "js/opcoes_projeto.js"></script>

