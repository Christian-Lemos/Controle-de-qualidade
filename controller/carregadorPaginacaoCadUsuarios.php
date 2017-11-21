<?php

		include_once "../util/ConexaoBD.php";
		include_once "../model/Usuario.php";
		include_once "../model/InteradorDB.php";
		include_once '../dao/UsuarioDAO.php';

		if(!isset($_SESSION))
		{
			session_start();
		}
			
		if(!isset($_SESSION['usuario']) || $_SESSION['usuario']->getAdmin() == false)
		{
			die();
		}

		$con = ConexaoBD::CriarConexao();
		$dao = new UsuarioDAO($con);
		$resultado = $dao->getUsuariosFiltro($_POST['ordenacao'], $_POST['ordem'], $_POST['inicio'], $_POST['fim']);

		echo '
			<table id = "visualisar_usuarios_table">
			<thead>
				<tr>
					<th>ID</th>
					<th>Login</th>
					<th>Nome</th>
					<th>Ação</th>
				</tr>
			</thead>
			<tbody>
		';
		while($linha = $resultado->fetch(PDO::FETCH_NUM))
		{
			echo 
			'
			<tr>
				<td>'.$linha[0].'</td>
				<td>'.$linha[1].'</td>
				<td>'.$linha[2].'</td>
				<td>
					<div class = "editar_excluir_usuario_btn_div">
						<button type="button" class= "editar_usuario_btn" data-id="'.$linha[0].'">Editar</button>
						<button type="button" class= "excluir_usuario_btn" data-id="'.$linha[0].'">Excluir</button>
					</div>
				</td>
			</tr>
			';
		}
		echo '
				</tbody>
			</table>
		';



?>
