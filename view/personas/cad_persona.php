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
?>

<form id = "form_cadastro_persona" onsubmit="return false" enctype="multipart/form-data">
	<label for="nome">Nome  da Persona:</label>
	<input type = "text" name = "nome" id = "cadastro_persona_nome" placeholder="Digite aqui o nome da persona" required/>
	
	<label for = "descricao">Descrição da Persona:</label>
	<textarea name = "descricao"  id = "cadastro_persona_descricao" required rows = "9"  placeholder="Digite aqui a descrição da persona"></textarea>
	<label for = "perfil">Imagem de perfil da Persona:</label>
	<input type = "file" name = "perfil" id = "cadastro_persona_perfil">

	<button type = "submit"  id ="form_cadastro_persona_btn">Cadastrar</button>
</form>

<script type = "text/javascript">
$("#form_cadastro_persona").submit(function () {
    var formData = new FormData(this);

    $.ajax({
        url: 'controller/cadastrarpersona.php',
        type: 'POST',
        data: formData,
		beforeSend : function()
		{
			$("#form_cadastro_persona_btn").html("Cadastrando...");
		},
		
        success: function (data) {
            alert(data);
            $("#form_cadastro_persona_btn").html("Cadastrar");
        },
        cache: false,
        contentType: false,
        processData: false,
        /*xhr: function() {  // Custom XMLHttpRequest
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                myXhr.upload.addEventListener('progress', function () {
                    $("#form_cadastro_persona_btn").html("Fazendo upload da imagem...");
                }, false);
            }
        return myXhr;
        }*/
    });
});
</script>