<?php
	session_start();

	if(isset($_SESSION['usuario']))
	{
		header('location: painel.php');
	}
?>

<!DOCTYPE html>
<html lang = "pt-br">
	<head>
		<meta charset = "utf-8" />
		<meta name = "robots" content="noindex, nofollow" />
		<meta name = "viewport" content="width=device-width, initial-scale=1" />
		<title>Controle de qualidade - CompAct Jr.</title>
		<link rel = "icon" href = "img/favicon.ico" type = "image/x-icon" />
		<link rel = "stylesheet" type = "text/css" href = "css/index.css" />
	</head>
	<body>
		<main>
			<div id = "form-div">
				<img src = "img/logo.png" alt = "CompAct Jr." />
				<h1>Sistema de controle de Qualidade de Projetos</h1>
				<form id = "form" onsubmit="return false">
					<label for = "login">Usuário:</label>
					<input type = "text" placeholder= "Digite aqui o nome do usuário" name = "login" id = "login"/>
					<label for = "senha">Senha:</label>
					<input type = "password" placeholder="Digite aqui a senha" name = "senha" id = "senha"/>
					<span id = "aviso"></span>
					<button type = "submit" id = "btn-entrar">Entrar</button>
				</form>
			</div>
		</main>
		<script type = "text/javascript" src = "js/jquery.js"></script>
		<script type="text/javascript" src = "js/validacaologin.js"></script>
	</body>
</html>

