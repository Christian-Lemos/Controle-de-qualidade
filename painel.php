<?php
	include_once "model/Usuario.php";
	session_start();

	if(!isset($_SESSION['usuario']))
	{
		header('location: index.php');
	}
	

?>

<!DOCTYPE html>
<html lang = "pt-br">
	<head>
		<meta charset = "utf-8" />
		<meta name = "robots" content="noindex, nofollow" />
		<meta name = "viewport" content="width=device-width, initial-scale=1" />
		<title>Painel - Controle de qualidade</title>
		<link rel = "icon" href = "img/favicon.ico" type = "image/x-icon" />
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
		<link rel = "stylesheet" type = "text/css" href = "css/painel_layout.css" />
	</head>
	<body>
		<aside>
			<div id = "abrir_menu_div">
				<img src = "img/fechar.png" alt = "Menu" id = "abrir_menu_div_fechar" style = "display: none"/>
				<img src = "img/seta.png" alt = "Menu" id ="abrir_menu_div_seta" />
			</div>
			<ul>
				<li class = "ativo" id = "menu-inspec"><img src = "img/checklist.png" alt = ""> <span>Inspeções</span></li>
				<?php
					if($_SESSION['usuario']->getAdmin() == true)

						echo 
					'<li id = "menu-projetos"><img src = "img/projeto.png" alt =""><span>Projetos</span></li>
					<li id = "menu-estatisticas"><img src = "img/estatisticas.png" alt =""><span>Estatísticas</span></li>
					<li id = "menu-usuarios"><img src = "img/usuario.png" alt =""><span>Usuários</span></li>
					';
				?>
				<li id = "menu-personas"><img src = "img/persona.png" alt = ""/><span>Personas</span></li>
				<li id = "menu-conf"><img src = "img/engrenagem.png" alt = "" /><span>Conta</span></li>
				<li id = "menu-sair"><img src = "img/sair.png" alt = "" /><span>Sair</span></li>
			</ul>
		</aside>
		<main>
			<h1>Bem-vindo <?php echo $_SESSION['usuario']->getNome() ?></h1>
			<hr />
			<section id = "pa-main" class = "pa-main">
				
			</section>
			
		</main>

		<div id = "modal-main">
			<div id = "modal-box">
			</div>
			
		</div>

		<script type = "text/javascript" src = "js/jquery.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
		<script type = "text/javascript" src = "js/carregador.js"></script>
		<script type = "text/javascript" src = "js/cadastrador.js"></script>
		<script type = "text/javascript" src = "js/jqueryui.js"></script>
		<script type = "text/javascript">
			function fecharmodal()
			{
				$("#modal-main").hide();
				$("#modal-box").css("height", '');
				$("#modal-box").html('');
			}
		</script>
			<?php
				if($_SESSION['usuario']->getAdmin() == true)
				{
					include_once 'js/gatilho_editar_usuario_btns.html';
				}
			?>
	</body>
</html>
