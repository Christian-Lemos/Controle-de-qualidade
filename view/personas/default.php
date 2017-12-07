<?php
    include_once "../../model/Usuario.php";
    if(!isset($_SESSION))
    {
        session_start();
    }

    if(!isset($_SESSION['usuario']))
    {
        exit(); 
    }
?>

<h2>Personas</h2>

<?php if ($_SESSION['usuario']->getAdmin() == true)

{?>

<div id="escolher-opc-btn-div">

	<div class="escolher-opc-btn eq-opc-btn-ativo" id = "opc-view-persona">

		Visualizar Personas

	</div>

	<div class="escolher-opc-btn" id = "opc-cad-persona">

		Cadastrar Personas

	</div>

</div>

<?php } ?>

<div id = "persona_view">

</div>

<script type="text/javascript" src = "js/opcoes_persona.js"></script>



