<?php

	include_once "../util/ConexaoBD.php";
	include_once "../model/Usuario.php";
	include_once '../model/Erro.php';
	include_once "../model/InteradorDB.php";
	include_once '../dao/ProjetoDAO.php';


		$con = ConexaoBD::CriarConexao();
		$dao = new ProjetoDAO($con);
		$resultado = $dao->getProjetosFiltro($_POST['ordenacao'], $_POST['ordem'], $_POST['inicio'], $_POST['fim']);

		echo '
		<table id = "visualisar_usuarios_table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Nome</th>
				<th>Gerênte</th>
				<th>Data de início</th>
				<th>Data de término</th>
				<th>Ação</th>
			</tr>
		</thead>
		<tbody>
	';
	while($linha = $resultado->fetch(PDO::FETCH_OBJ))
	{
		echo 
		'
		<tr>
			<td>'.$linha->id.'</td>
			<td>'.$linha->nome.'</td>
			<td>'.$linha->nomegerente.'</td>
			<td>'.str_replace('-', '/', date('d-m-Y', strtotime($linha->datainicio))).'</td>
			<td>'.$linha->datatermino.'</td>
			<td>
				<div class = "editar_excluir_usuario_btn_div">
					<button type="button" class= "editar_usuario_btn" data-id="'.$linha->id.'">Editar</button>
					<button type="button" class= "excluir_usuario_btn" data-id="'.$linha->id.'">Excluir</button>
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
