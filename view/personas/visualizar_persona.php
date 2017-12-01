<?php
	include_once "../../model/Usuario.php";

	if(!isset($_SESSION))
	{
		session_start();
	}

	if(!isset($_SESSION['usuario']))
	{
		die();
	}


	include_once "../../util/ConexaoBD.php";
	include_once "../../model/InteradorDB.php";
	include_once "../../model/Persona.php";
	include_once "../../dao/PersonaDAO.php";

	$con = ConexaoBD::CriarConexao();
	$dao = new PersonaDAO($con);
	$personas = $dao->getPersonas();
	foreach($personas as $persona)
	{
		echo '<div class = "persona_show_div_container" data-id = "'.$persona->getID().'">';
		echo
		'
			<!-- <div style = "background-image: url('.$persona->getImagem().');" class = "persona_show_div"></div>-->
			<div class = "persona_show_divider">
				<img src = "'.$persona->getImagem().'" class = "persona_show_img"/>
			</div>
			<div class = "persona_show_divider">
				<span>'.$persona->getNome().'</span>
			</div>
			<div class = "persona_show_arrow_div">
				<span></span>
				<img src = "img/seta_arrow.png" alt = "Visualizar" />
			</div>
		';
			echo "</div>";
	}

?>

<script type = "text/javascript">
    $(document).ready(function()
    {
        $(".persona_show_div_container").on('click', function()
        {
           id = $(this).data('id');
           
           $.ajax(
           {
               url : 'view/personas/modal_mostrar_persona.php',
               method : 'GET',
               data : {id : id},
               
               beforeSend : function()
               {
                   $("#modal-main").show();
                   $("#modal-box").html('<div class = "loader"></div>');
               },
               
               success : function(resposta)
               {
                   $("#modal-box").html(resposta);
               }
           });
        });
    });
</script>