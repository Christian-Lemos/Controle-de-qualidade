$(document).ready(function() {
    var validando = false;
    var validando2 = false;
    $('#pa-main').on('submit', '#form_cadastro_usuario', function() {
        if (validando == true) {
            return;
        }
        if ($("#cadastro_usuario_login").val() == '') {
            alert("Digite o login do usuário");
            $("#cadastro_usuario_login").css("border-color", "red");
            return;
        } else {
            $("#cadastro_usuario_login").css("border-color", "unset");
        }

        if ($("#cadastro_usuario_senha").val() == '') {
            alert("Digite a senha do usuario");
            $("#cadastro_usuario_senha").css("border-color", "red");
            return;
        } else {
            $("#cadastro_usuario_senha").css("border-color", "unset");
        }

        if ($("#cadastro_usuario_senha2").val() == '') {
            alert("Digite a senha a confirmacao de senha do usuário");
            $("#cadastro_usuario_senha2").css("border-color", "red");
            return;
        } else {
            $("#cadastro_usuario_senha2").css("border-color", "unset");
        }

        if ($("#cadastro_usuario_senha2").val() != $("#cadastro_usuario_senha").val()) {
            alert("A confirmação de senha não corresponde");
            $("#cadastro_usuario_senha").css("border-color", "red");
            $("#cadastro_usuario_senha2").css("border-color", "red");
            return;
        } else {
            $("#cadastro_usuario_senha").css("border-color", "unset");
            $("#cadastro_usuario_senha2").css("border-color", "unset");
        }

        if ($("#cadastro_usuario_nome").val() == '') {
            alert("Digite o nome do usuário");
            $("#cadastro_usuario_nome").css("border-color", "red");
            return;
        } else {
            $("#cadastro_usuario_nome").css("border-color", "unset");
        }

        if ($("#cadastro_usuario_email").val() == '') {
            alert("Digite o email do usuário");
            $("#cadastro_usuario_email").css("border-color", "red");
            return;
        } else {
            $("#cadastro_usuario_email").css("border-color", "unset");
        }

        validando = true;
        var dados = $("#form_cadastro_usuario").serialize();

        $.ajax({
            url: "controller/usuario/cadastroUsuario.php",
            method: "POST",
            data: dados,
            beforeSend: function() {
                $("#form_cadastro_usuario input").css("border-color", "unset");
                $("#cadastro_usuario_btn").html("Cadastarando...");

            },
            success: function(resposta) {
                if (resposta == "sucesso") {
                    alert("Usuário cadastrado com sucesso");
                    $("#cadastro_usuario_btn").css("margin-top", "30px");
                    $("#aviso").css("display", "none");
                    validando = false;
                } else {
                    $("#aviso").css("display", "block");
                    $("#aviso").text(resposta);
                    $("#cadastro_usuario_btn").css("margin-top", "12px");
                }
                $("#cadastro_usuario_btn").html("Cadastrar");

                validando = false;
            },

        });

    });

    $('#pa-main').on('submit', '#form_cadastro_projeto', function() {
        if (validando2 == true) {
            return;
        }
        validando2 = true;
        var data = $("#form_cadastro_projeto").serialize();

        $.ajax({

            url: 'controller/projeto/AdicionarProjeto.php',
            method: 'POST',
            data: data,
            beforeSend: function() {
                $("#form_cadastro_projeto_btn").html("Cadastrando Projeto...");
            },

            success: function(resposta) {
                $("#form_cadastro_projeto_btn").html("Cadastrar");
                if (resposta == "sucesso") {
                    alert("Projeto cadastrado com sucesso");
                } else {
                    alert(resposta);
                }
                validando2 = false;
            }
        });

    });
});