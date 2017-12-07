<?php

	include_once '../util/ConexaoBD.php';
	include_once '../model/InteradorDB.php';
	$con = ConexaoBD::CriarConexao();
	switch($_POST['acao'])
	{
		case 'deletarusuario' :
			include_once '../model/Usuario.php';
			include_once '../dao/UsuarioDAO.php';
			$dao = new UsuarioDAO($con);
			$usuario = $dao->encontrarUsuario($_POST['id']);
			$mensagem = 'Tens certeza que querer <b>excluir</b> o usuario <i>'.$usuario->getNome().'(login '.$usuario->getLogin().') </i> ?';
			break;
			
		case 'deletarprojeto' :
				include_once '../model/Projeto.php';
				include_once '../dao/ProjetoDAO.php';
				$dao = new ProjetoDAO($con);
				$projeto = $dao->encontrarProjeto($_POST['id']);
				$mensagem = 'Tens certeza que querer <b>excluir</b> o projeto <i>'.$projeto->getNome().'</i> ?';
			break;
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
	<button type = "button" class = "modal_confirmacao_button" id = "modal_confirmacao_sim" onclick= "acaosim()">Sim</button>
</div>

<script type="text/javascript">

		function acaosim()
		{
			<?php if($_POST['acao'] == 'deletarusuario')
			{?>

				$.ajax
				({
					url : 'controller/usuario/apagadorUsuarios.php',
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
			<?php 
			}
			else if ($_POST['acao'] == 'deletarprojeto')
			{?>


				$.ajax
				({
					url : 'controller/projeto/apagadorProjetos.php',
					method : 'POST',
					data : {id : <?php echo $projeto->getID(); ?>},

					beforeSend : function ()
					{
						$("#modal-box").html("<div class = 'loader'><div>");
					},

					success : function (resposta)
					{
						if(resposta == "sucesso")
						{
							alert("Projetos excluido com sucesso");
						}
						else
						{
							alert(resposta);
						}
						fecharmodal();
					}
				});

			<?php } ?>
		}

</script>