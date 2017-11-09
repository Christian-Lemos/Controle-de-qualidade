<?

	include_once '../util/ConexaoBD.php';
	include_once '../model/Usuario.php';
	include_once '../dao/UsuarioDAO.php';

	$con = ConexaoBD::CriarConexao();

	$dao = new UsuarioDAO($con);

	$usuario = $dao->encontrarUsuario($_POST['id']);

	if($_POST['acao'] == 'deletarusuario')
	{
		$mensagem = 'Tens certeza que querer <b>excluir</b> o usuario '.$usuario->getNome().'(login '.$usuario->getLogin().') ?';
	}
?>

<div id = "modal-fechar-div" onclick="fecharmodal()">

		<span id = "modal-fechar">&times;</span>

</div>	
<div id = "modal-conteudo">

	<h3 style = "text-align: center;">Aviso</h3>

	<hr />

	<p style = "text-align: center;"><?php echo $mensagem; ?></p>

	<hr />

	<button type = "button" class = "modal_confirmacao_button" id = "modal_confirmacao_nao" onclick="fecharmodal()">Não</button>

	<button type = "button" class = "modal_confirmacao_button" id = "modal_confirmacao_sim">Sim</button>

</div>

<script type="text/javascript">
	$(document).ready(function()
	{	
		$("#modal-box").on('click', '#modal_confirmacao_sim', function()
		{
			<?php if($_POST['acao'] == 'deletarusuario')
			{?>

				$.ajax
				({
					url : 'controller/apagadorUsuarios.php',
					method : 'POST',
					data : {id : <?php echo $usuario->getID(); ?>},

					beforeSend : function ()
					{
						$("#modal-box").html("<div class = 'loader'><div>");
					},

					success : function (resposta)
					{
						if(resposta == "sucesso")
						{
							alert("Usuario excluido com sucesso");
						}
						else
						{
							alert(resposta);
						}
						fecharmodal();
					}
				});
			<?php } ?>
		});
	});

</script>