<?php
	include_once '../../model/Usuario.php';

	if(!isset($_SESSION))
	{
            session_start();
	}
	if(!isset ($_SESSION['usuario']) || $_SESSION['usuario']->getAdmin() == false)
	{
            die();
	}
	include_once '../../dao/UsuarioDAO.php';
	include_once '../../dao/ProjetoDAO.php';
	include_once '../../model/Projeto.php';

	$projDAO = new ProjetoDAO();
	$usuDAO = new UsuarioDAO();
	$projeto = $projDAO->encontrarProjeto($_GET['id']);
	$usuarios = $usuDAO->getUsuarios();
	$desenvolvedores = json_decode($projeto->getDesenvolvedores());
	$gerenteOpcoes =  '';
	$devsOpcoes = '';
        foreach($usuarios as $linha)
        {
            $devsOpcoes .= '<option value = "'.$linha->getID().'" ';
            $gerenteOpcoes .= '<option value = "'.$linha->getID().'" ';

            if($linha->getID() == $projeto->getGerente())
            {
                $gerenteOpcoes .= 'selected';
            }

            for($i = 0; $i < count($desenvolvedores); $i++)
            {
                if($desenvolvedores[$i]->idusuario == $linha->getID())
                {
                    $devsOpcoes .= 'selected';
                    break;
                }
            }

            $gerenteOpcoes .= '>'.$linha->getNome().'</option>';
            $devsOpcoes .= '>'.$linha->getNome().'</option>';	
        }	
?>


<div id = "modal-fechar-div" onclick="fecharmodal()">
   <span id = "modal-fechar">&times;</span>
</div>
</div>
<div id = "modal_conteudo">
   <h2>Editando <?php echo $projeto->getNome(); ?></h2>
   <hr />
   <div class = "mostrar_edit_usuario_div">
      <h3>Editar Nome: </h3>
      <form id = "edit_projeto_form_nome" onsubmit="return false">
        <input type = "hidden" name = "campo" value = "nome">
        <input type = "hidden" class ="edit_projeto_form_id" name = "id" value ="<?php echo $_GET['id']; ?>"> 
         <label for = "nome_atual">Nome Atual:</label>
         <input type  = "text" name = "nome_atual" id = "nome_atual" value = "<?php echo $projeto->getNome() ?>" disabled />
         <label for = "nome_novo">Nome Novo:</label>
         <input type  = "text" name = "nome_novo" id = "nome_novo" class ="edit_projeto_form_novo" placeholder = "Novo nome..." />
         <span id = "edit_projeto_form_nome_span"></span>
         <div class = "mostrar_edit_projeto_div_btn_div">
            <button type = "submit" id = "edit_projeto_form_nome_btn">Editar</button>
         </div>
      </form>
   </div>
   <hr />
	<div class = "mostrar_edit_usuario_div">
      <h3>Editar Gerente: </h3>
      <form id = "edit_projeto_form_gerente" onsubmit="return false">
	  <input type = "hidden" name = "campo" value = "gerente">
	  <input type = "hidden" class ="edit_projeto_form_id" name = "id" value ="<?php echo $_GET['id']; ?>"> 
            <label for = "gerente">Gerente:</label>
            <select class="js-example-basic-single" id = "edit_projeto_gerente"  style = "padding:0;" name="gerente"  required>
		<?php
			echo $gerenteOpcoes;
		?>
		</select>
		 <span id = "edit_projeto_form_gerente_span"></span>
         <div class = "mostrar_edit_projeto_div_btn_div">
            <button type = "submit" id = "edit_projeto_form_gerente_btn">Editar</button>
         </div>
      </form>
   </div>

  <div class = "mostrar_edit_usuario_div">
      <h3>Editar Desenvolvedores: </h3>
      <form id = "edit_projeto_form_desenvolvedores" onsubmit = "return false">
	  <input type = "hidden" name = "id" value ="<?php echo $_GET['id']; ?>"> 
	  <input type = "hidden" name = "campo" value = "desenvolvedores">
         <label for = "desenvolvedores[]">Desenvolvedores:</label>
		<select class="js-example-basic-multiple" id = "edit_projeto_devs"  style = "padding:0;" name="desenvolvedores[]" multiple required>
		<?php
			echo $devsOpcoes;
		?>
		</select>
		 <span id = "edit_projeto_form_desenvolvedores_span"></span>
         <div class = "mostrar_edit_projeto_div_btn_div">
            <button type = "submit" id = "edit_projeto_form_desenvolvedores_btn">Editar</button>
         </div>
      </form>
   </div>
    <div class = "mostrar_edit_usuario_div">
      <h3>Editar data de assinatura do contrato: </h3>
      <form id = "edit_projeto_form_contrato" onsubmit="return false">
	  <input type = "hidden" name = "id" class ="edit_projeto_form_id" value ="<?php echo $_GET['id']; ?>"> 
	  <input type = "hidden" name = "campo" value = "datainicio">
      	 <label for="edit_projeto_form_contrato_antigo">Data atual:</label>
		 <input type = "text" onfocus = "blur()" name = "edit_projeto_form_contrato_antigo" value = "<?php echo $projeto->getDataInicio(); ?>" id = "edit_projeto_form_contrato_antigo" placeholder="Data da assinatura do contrato" disabled />

		 <label for="edit_projeto_form_contrato_novo">Data nova:</label>
		 <input type = "text" onfocus = "blur()" class ="edit_projeto_form_novo" name = "edit_projeto_form_contrato_novo" id = "edit_projeto_form_contrato_novo" placeholder="Data da assinatura do contrato" required/>
		 <span id = "edit_projeto_form_contrato_span"></span>
         <div class = "mostrar_edit_projeto_div_btn_div">
            <button type = "submit" id = "edit_projeto_form_assinatura_btn">Editar</button>
         </div>
      </form>
   </div>
   <div class = "mostrar_edit_usuario_div">
      <h3>Editar data de assinatura do termo de aceite: </h3>
      <form id = "edit_projeto_form_aceite" onsubmit="return false">
	  <input type = "hidden" class ="edit_projeto_form_id" name = "id" value ="<?php echo $_GET['id']; ?>"> 
	  <input type = "hidden" name = "campo" value = "datatermino">
            <label for="edit_projeto_form_aceite_antigo">Data atual:</label>
            <input type = "text" onfocus = "blur()" name = "edit_projeto_form_aceite_antigo" value = "<?php echo $projeto->getDataTermino(); ?>" id = "edit_projeto_form_aceite_antigo" disabled />

            <label for="edit_projeto_form_aceite_novo">Data nova:</label>
            <input type = "text" onfocus = "blur()" class ="edit_projeto_form_novo" name = "edit_projeto_form_aceite_novo" id = "edit_projeto_form_aceite_novo" placeholder="Data da assinatura do termo de aceite" required/>
            <span id = "edit_projeto_form_aceite_span"></span>
         <div class = "mostrar_edit_projeto_div_btn_div">
            <button type = "submit" id = "edit_projeto_form_aceite_btn">Editar</button>
         </div>
      </form>
   </div>
</div>
<script type = "text/javascript">

	$('#edit_projeto_form_contrato_novo').datepicker({
   dateFormat: 'dd/mm/yy',
   dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
   dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
   dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
   monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
   monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
   nextText: 'Proximo',
   prevText: 'Anterior'});
   
   $('#edit_projeto_form_aceite_novo').datepicker({
   dateFormat: 'dd/mm/yy',
   dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
   dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
   dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
   monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
   monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
   nextText: 'Proximo',
   prevText: 'Anterior'});
   
$(document).ready(function() {

    $('#edit_projeto_devs').select2();
    $('#edit_projeto_gerente').select2();


    var id = <?php echo $projeto->getID(); ?>;
    var validando = false;

    $("#edit_projeto_form_nome").on("submit", function() {
        if (validando == true) {
            return;
        }
        validando = true;
        var thisid = $("#edit_projeto_form_nome .edit_projeto_form_id").attr("value");
        var thisnovo = $("#edit_projeto_form_nome .edit_projeto_form_novo").val();
        var dadonovo = $(this).serialize();

        $.ajax({
            url: 'controller/projeto/atualizadorProjetos.php',
            method: 'POST',
            data: dadonovo,

            beforeSend: function() {
                $("#edit_projeto_form_nome_btn").html("Atualizando...");
            },

            success: function(resposta) {
                validando = false;
                if (resposta == "sucesso") {
                    $("#nome_atual").val($("#nome_novo").val());
                    $("#nome_novo").val('');
                    $("#edit_projeto_form_nome_span").html("");
                    $('.visualizar_proj_usuario_table tbody tr[data-id="'+thisid+'"] .visualizar_projeto_td_nome').html(thisnovo);
                    alert("Nome atualizado com sucesso");
                } else {
                    $("#edit_projeto_form_nome_span").html(resposta);

                }

                $("#edit_projeto_form_nome_btn").html("Editar");
            }

        });
    });
    $("#edit_projeto_form_gerente").on('submit', function() {
        if (validando == true) {
            return;
        }
        validando = true;
        var thisid = $("#edit_projeto_form_gerente .edit_projeto_form_id").attr("value");
        var thisnovo = $("#edit_projeto_gerente option:selected").html();
        var dadonovo = $(this).serialize();

        $.ajax({
            url: 'controller/projeto/atualizadorProjetos.php',
            method: 'POST',
            data: dadonovo,

            beforeSend: function() {
                $("#edit_projeto_form_gerente_btn").html("Atualizando...");
            },

            success: function(resposta) {
                validando = false;
                if (resposta == "sucesso") {
                    $("#edit_projeto_form_gerente_btn").html("");
                    $('.visualizar_proj_usuario_table tbody tr[data-id="'+thisid+'"] .visualizar_projeto_td_gerente').html(thisnovo);
                    alert("Gerente atualizado com sucesso");
                } else {
                    $("#edit_projeto_form_gerente_span").html(resposta);

                }

                $("#edit_projeto_form_gerente_btn").html("Editar");
            }

        });
    });

    $("#edit_projeto_form_desenvolvedores").on('submit', function() {
        if (validando == true) {
            return;
        }
        validando = true;

        var dadonovo = $(this).serialize();

        $.ajax({
            url: 'controller/projeto/atualizadorProjetos.php',
            method: 'POST',
            data: dadonovo,

            beforeSend: function() {
                $("#edit_projeto_form_desenvolvedores_btn").html("Atualizando...");
            },

            success: function(resposta) {
                validando = false;
                if (resposta == "sucesso") {
                    $("#edit_projeto_form_desenvolvedores_span").html('');
                    alert("Nome atualizado com sucesso");
                } else {
                    $("#edit_projeto_form_desenvolvedores_btn").html(resposta);
                }

                $("#edit_projeto_form_desenvolvedores_btn").html("Editar");
            }

        });
    });

    $("#edit_projeto_form_contrato").on('submit', function() {
        if (validando == true) {
            return;
        }
        validando = true;
        var thisid = $("#edit_projeto_form_contrato .edit_projeto_form_id").attr("value");
        var thisnovo = $("#edit_projeto_form_contrato .edit_projeto_form_novo").val();
        var dadonovo = $(this).serialize();
        $.ajax({
            url: 'controller/projeto/atualizadorProjetos.php',
            method: 'POST',
            data: dadonovo,

            beforeSend: function() {
                $("#edit_projeto_form_assinatura_btn").html("Atualizando...");
            },

            success: function(resposta) {
                validando = false;
                if (resposta == "sucesso") {
                    $("#edit_projeto_form_contrato_antigo").val($("#edit_projeto_form_contrato_novo").val());
                    $("#edit_projeto_form_contrato_novo").val('');
                    $("#edit_projeto_form_contrato_span").html('');
                    $('.visualizar_proj_usuario_table tbody tr[data-id="'+thisid+'"] .visualizar_projeto_td_datainicio').html(thisnovo);
                    alert("Assinatura do contrato atualizada com sucesso");
                } else {
                    $("#edit_projeto_form_contrato_span").html(resposta);
                }

                $("#edit_projeto_form_assinatura_btn").html("Editar");
            }

        });
    });

    $("#edit_projeto_form_aceite").on('submit', function() {
        if (validando == true) {
            return;
        }
        validando = true;
        var thisid = $("#edit_projeto_form_aceite .edit_projeto_form_id").attr("value");
        var thisnovo = $("#edit_projeto_form_aceite .edit_projeto_form_novo").val();
        var dadonovo = $(this).serialize();
        $.ajax({
            url: 'controller/projeto/atualizadorProjetos.php',
            method: 'POST',
            data: dadonovo,
            
            beforeSend: function() {
                $("#edit_projeto_form_aceite_btn").html("Atualizando...");
            },

            success: function(resposta) {
                validando = false;
                if (resposta == "sucesso") {
                    $("#edit_projeto_form_aceite_antigo").val($("#edit_projeto_form_aceite_novo").val());
                    $("#edit_projeto_form_aceite_novo").val('');
                    $("#edit_projeto_form_aceite_span").html('');
                    $('.visualizar_proj_usuario_table tbody tr[data-id="'+thisid+'"] .visualizar_projeto_td_datatermino').html(thisnovo);
                    alert("Assinatura do termo de aceite atualizada com sucesso");
                } else {
                    $("#edit_projeto_form_aceite_span").html(resposta);
                }

                $("#edit_projeto_form_aceite_btn").html("Editar");
            }

        });
    });


});
</script>





