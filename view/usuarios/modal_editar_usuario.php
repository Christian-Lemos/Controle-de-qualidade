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
    $dao = new UsuarioDAO();
    $usuario = $dao->encontrarUsuario($_GET['id']);

?>

<div id = "modal-fechar-div" onclick="fecharmodal()">
   <span id = "modal-fechar">&times;</span>
</div>
<div id = "modal_conteudo">
   <h2>Editando <?php echo $usuario->getNome(); ?></h2>
   <hr />
   <div class = "mostrar_edit_usuario_div">
      <h3>Editar Login: </h3>
      <form id = "edit_usuario_form_login" onsubmit="return false">
         <label for = "login_atual">Login Atual:</label>
         <input type  = "text" name = "login_atual" id = "login_atual" value = "<?php echo $usuario->getLogin() ?>" disabled />
         <label for = "login_novo">Login Novo:</label>
         <input type  = "text" name = "login_novo" id = "login_novo" placeholder = "Novo login..." />
         <span id = "edit_usuario_form_login_span"></span>
         <div class = "mostrar_edit_usuario_div_btn_div">
            <button type = "submit" id = "edit_usuario_form_login_btn">Editar</button>
         </div>
      </form>
   </div>
   <hr />
   <div class = "mostrar_edit_usuario_div">
      <h3>Editar Nome: </h3>
      <form id = "edit_usuario_form_nome" onsubmit="return false">
         <label for = "nome_atual">Nome Atual:</label>
         <input type  = "text" name = "nome_atual" id = "nome_atual" value = "<?php echo $usuario->getNome() ?>" disabled />
         <label for = "nome_novo">Nome Novo:</label>
         <input type  = "text" name = "nome_novo" id = "nome_novo" placeholder = "Novo nome..." />
         <span id = "edit_usuario_form_nome_span"></span>
         <div class = "mostrar_edit_usuario_div_btn_div">
            <button type = "submit" id = "edit_usuario_form_nome_btn">Editar</button>
         </div>
      </form>
   </div>
   <hr />
   <div class = "mostrar_edit_usuario_div">
      <h3>Editar Email: </h3>
      <form id = "edit_usuario_form_email" onsubmit="return false">
         <label for = "email_atual">Email Atual:</label>
         <input type  = "email" name = "email_atual" id = "email_atual" value = "<?php echo $usuario->getEmail() ?>" disabled />
         <label for = "email_novo">Email Nome:</label>
         <input type  = "email" name = "email_novo" id = "email_novo" placeholder = "Novo novo..." />
         <span id = "edit_usuario_form_email_span"></span>
         <div class = "mostrar_edit_usuario_div_btn_div">
            <button type = "submit" id = "edit_usuario_form_email_btn">Editar</button>
         </div>
      </form>
   </div>
   <hr />
   <div class = "mostrar_edit_usuario_div">
      <h3>Editar Senha: </h3>
      <form id = "edit_usuario_form_senha" onsubmit="return false">
         <label for = "senha_nova">Senha Nova:</label>
         <input type  = "password" name = "senha_nova" id = "senha_nova" placeholder="Digite a nova senha" />
         <label for = "senha_conf">Confirmação da Senha Nova:</label>
         <input type  = "password" name = "senha_conf" id = "senha_conf" placeholder = "Confirmação da senha" />
         <span id = "edit_usuario_form_senha_span"></span>
         <div class = "mostrar_edit_usuario_div_btn_div">
            <button type = "submit" id = "edit_usuario_form_senha_btn">Editar</button>
         </div>
      </form>
   </div>
   <hr />
   <div class = "mostrar_edit_usuario_div">
      <h3>Editar Administrador: </h3>
      <form id = "edit_usuario_form_admin" onsubmit="return false">
         <label for = "adm_atual">Administrador:</label>
         <input type  = "checkbox" name = "adm_atual" id = "adm_atual" <?php if($usuario->getAdmin() == true){echo "checked";} ?> style = "width: initial;" />
         <span id = "edit_usuario_form_admin_span"></span>
         <div class = "mostrar_edit_usuario_div_btn_div">
            <button type = "submit" id = "edit_usuario_form_admin_btn">Editar</button>
         </div>
      </form>
   </div>
</div>
<script type = "text/javascript">
$(document).ready(function() {
    var id = <?php echo $usuario->getID(); ?>;
    var validando = false;
    $("#edit_usuario_form_login_btn").on('click', function() {
        if (validando == true) {
            return;
        }
        validando = true;

        var dadonovo = $("#login_novo").val();

        $.ajax({
            url: 'controller/usuario/atualizadorUsuarios.php',
            method: 'POST',
            data: {
                campo: 'login',
                novo: dadonovo,
                id: id
            },

            beforeSend: function() {
                $("#edit_usuario_form_login_btn").html("Atualizando...");
            },

            success: function(resposta) {
                validando = false;
                if (resposta == "sucesso") {
                    $("#login_atual").val(dadonovo);
                    $("#login_novo").val('');
                    $("#edit_usuario_form_login_span").html("");
                    alert("Login atualizado com sucesso");
                } else {
                    $("#edit_usuario_form_login_span").html(resposta);

                }

                $("#edit_usuario_form_login_btn").html("Editar");
            }

        });
    });

    $("#edit_usuario_form_nome_btn").on('click', function() {
        if (validando == true) {
            return;
        }
        validando = true;

        var dadonovo = $("#nome_novo").val();

        $.ajax({
            url: 'controller/usuario/atualizadorUsuarios.php',
            method: 'POST',
            data: {
                campo: 'nome',
                novo: dadonovo,
                id: id
            },

            beforeSend: function() {
                $("#edit_usuario_form_nome_btn").html("Atualizando...");
            },

            success: function(resposta) {
                validando = false;
                if (resposta == "sucesso") {
                    $("#nome_atual").val(dadonovo);
                    $("#nome_novo").val('');
                    $("#edit_usuario_form_nome_span").html('');
                    alert("Nome atualizado com sucesso");
                } else {
                    $("#edit_usuario_form_nome_span").html(resposta);
                }

                $("#edit_usuario_form_nome_btn").html("Editar");
            }

        });
    });

    $("#edit_usuario_form_email_btn").on('click', function() {
        if (validando == true) {
            return;
        }
        validando = true;

        var dadonovo = $("#email_novo").val();

        $.ajax({
            url: 'controller/usuario/atualizadorUsuarios.php',
            method: 'POST',
            data: {
                campo: 'email',
                novo: dadonovo,
                id: id
            },

            beforeSend: function() {
                $("#edit_usuario_form_email_btn").html("Atualizando...");
            },

            success: function(resposta) {
                validando = false;
                if (resposta == "sucesso") {
                    $("#email_atual").val(dadonovo);
                    $("#email_novo").val('');
                    $("#edit_usuario_form_email_span").html('');
                    alert("E-mail atualizado com sucesso");
                } else {
                    $("#edit_usuario_form_email_span").html(resposta);
                }

                $("#edit_usuario_form_email_btn").html("Editar");
            }

        });
    });
    $("#edit_usuario_form_senha_btn").on('click', function() {
        if (validando == true) {
            return;
        }

        if ($("#senha_nova").val() != $("#senha_conf").val()) {
            alert("A confirmação de senha não confere com a nova senha")
            validando = false;
            return;
        }
        validando = true;

        var dadonovo = $("#senha_nova").val();

        $.ajax({
            url: 'controller/usuario/atualizadorUsuarios.php',
            method: 'POST',
            data: {
                campo: 'senha',
                novo: dadonovo,
                id: id
            },

            beforeSend: function() {
                $("#edit_usuario_form_senha_btn").html("Atualizando...");
            },

            success: function(resposta) {
                validando = false;
                if (resposta == "sucesso") {
                    $("#email_atual").val(dadonovo);
                    $("#email_novo").val('');
                    $("#edit_usuario_form_senha_span").html('');
                    alert("Senha atualizada com sucesso");
                } else {
                    $("#edit_usuario_form_senha_span").html(resposta);
                }

                $("#edit_usuario_form_senha_btn").html("Editar");
            }

        });

    });

    $("#edit_usuario_form_admin_btn").on('click', function() {
        if (validando == true) {
            return;
        }

        validando = true;

        var dadonovo;
        if ($("#adm_atual").is(":checked")) {
            dadonovo = 1;
        } else {
            dadonovo = 0;
        }

        $.ajax({
            url: 'controller/usuario/atualizadorUsuarios.php',
            method: 'POST',
            data: {
                campo: 'admin',
                novo: dadonovo,
                id: id
            },

            beforeSend: function() {
                $("#edit_usuario_form_admin_btn").html("Atualizando...");
            },

            success: function(resposta) {
                validando = false;
                if (resposta == "sucesso") {
                    $("#email_atual").val(dadonovo);
                    $("#email_novo").val('');
                    $("#edit_usuario_form_admin_span").html('');
                    alert("Privilégio atualizado com sucesso");
                } else {
                    $("#edit_usuario_form_admin_span").html(resposta);
                }
                $("#edit_usuario_form_admin_btn").html("Editar");
            }


        });

    });
});
</script>





