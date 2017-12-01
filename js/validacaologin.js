$(document).ready(function()
{
	var validando = false;
	
	$("#form").submit(function(){
		if(validando === true)
		{
			return;
		}
		if($("#login").val() === '')
		{
			alert("Digite o nome do usuário");
			$("#login").css("border-color", "red");
			return;
		}
		else
		{
			$("#login").css("border-color", "unset");
		}

		if($("#senha").val() === '')
		{
			alert("Digite a senha");
			$("#senha").css("border-color", "red");
			return;
		}
		else
		{
			$("#senha").css("border-color", "unset");
		}
		
		validando = true;
		var dados = $("#form").serialize();

		$.ajax
		({
			url : "controller/controleLogin.php",
			method : "POST",
			data : dados,
			beforeSend: function()
			{	
				$("#login").css("border-color", "unset");
				$("#senha").css("border-color", "unset");
				$("#btn-entrar").html("Validando...");
			},
			success : function(resposta)
			{
				if(resposta === "sucesso")
				{
					window.location.href = "painel.php";
					return;
				}
				$("#btn-entrar").html("Entrar");
				$("#aviso").css("display", "block");
				$("#aviso").text(resposta);
				$("#btn-entrar").css("margin-top", "12px");
				validando = false;
			}

		});

	});
});
