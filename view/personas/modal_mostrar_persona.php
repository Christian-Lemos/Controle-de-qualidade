<?php
	include_once '../../model/Usuario.php';

	if(!isset($_SESSION))
	{
            session_start();
	}
	if(!isset ($_SESSION['usuario']) || !isset($_GET['id']))
	{
            die();
	}
          
        include_once '../../model/Persona.php';
        include_once '../../dao/PersonaDAO.php';
        
         echo '<div id = "modal-fechar-div" onclick="fecharmodal()"><span id = "modal-fechar">&times;</span> </div><div id = "modal_conteudo" class = "modal_mostrar_persona_conteudo_div">';
        $personadao = new PersonaDAO();
        $persona = $personadao->getPersona($_GET['id']);
        
        if($_SESSION['usuario']->getAdmin() == true)
        {?>
        <form id = "form_edicao_persona"onsubmit="return false" enctype="multipart/form-data">
            <img src ="<?php echo $persona->getImagem(); ?>" alt ="<?php echo $persona->getNome(); ?>" />
            <input type = "hidden" name = "id" value ="<?php echo $persona->getID(); ?>" />
            <label for="nome">Nome  da Persona:</label>
            <input type = "text" name = "nome" id = "cadastro_persona_nome" placeholder="Digite aqui o nome da persona" value ="<?php echo $persona->getNome(); ?>" required/>

            <label for = "descricao">Descrição da Persona:</label>
            <textarea name = "descricao"  id = "cadastro_persona_descricao" required rows = "9"  placeholder="Digite aqui a descrição da persona"><?php echo $persona->getDescricao(); ?></textarea>
            <label for = "perfil">Imagem de perfil da Persona:</label>
            <input type = "file" name = "perfil" id = "cadastro_persona_perfil">

            <button type = "submit"  id ="form_cadastro_persona_btn">Editar Dados</button>
            <button type = "button"  onclick="excluirPersona(<?php echo $persona->getID(); ?>)" id ="excluir_persona_btn">Excluir Persona</button>
          </form>
<script type = "text/javascript">
$("#form_edicao_persona").submit(function () {
    var formData = new FormData(this);

    $.ajax({
        url: 'controller/persona/editarpersona.php',
        type: 'POST',
        data: formData,
		beforeSend : function()
		{
                    $("#form_cadastro_persona_btn").html("Salvando...");
		},
		
        success: function (data) {
            alert(data);
            $("#form_cadastro_persona_btn").html("Editar Dados");
        },
        cache: false,
        contentType: false,
        processData: false,
    });
});

function excluirPersona(id)
{
   $.ajax({
      url : 'controller/persona/apagadorPersonas.php',
      type : 'POST',
      data : {id : id},
      beforeSend : function()
      {
          $("#excluir_persona_btn").html("Excluindo Persona");
      },
      
      success : function(resposta)
      {
          $('.persona_show_div_container[data-id="'+id+'"]').remove();
          alert(resposta);
          fecharmodal();
      }
   });
}

</script>
        <?php }
        
        else
        {?>
            <img src ="<?php echo $persona->getImagem(); ?>" alt ="<?php echo $persona->getNome(); ?>" />
            <h4><?php echo $persona->getNome(); ?></h4>
            
            <p><?php echo $persona->getDescricao(); ?></p>
        <?php } echo "</div>";
?>