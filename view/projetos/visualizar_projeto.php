
<div class = "ordenacao_btn_main">
	<div class = "ordenacao_btn_div">
		<label for = "filtro1">Ordenar por:</label>
		<select name = "filtro1" id = "filtro1">
				<option value = "id">Id</option>
				<option value = "nome">Nome</option>	
				<option value = "nomegerente">Gerênte</option>
				<option value = "datainicio">Data de início</option>
				<option value = "datatermino">Data de término</option>
		</select>
	</div>
	<div class = "ordenacao_btn_div">
		<label for = "filtro2">Em ordem:</label>
			<select name = "filtro1" id = "filtro2">
				<option value = "asc">Crescente</option>
				<option value="desc">Descrecente</option>
		</select>
	</div>
</div>



<?php
	include_once "../../util/ConexaoBD.php";
	include_once "../../model/Usuario.php";
	include_once '../../model/Erro.php';
	include_once '../../model/InteradorDB.php';
	include_once '../../dao/UsuarioDAO.php';
	include_once '../../dao/ProjetoDAO.php';
	$con = ConexaoBD::CriarConexao();
	$dao = new ProjetoDAO($con);
	$resultadosPorPagina = 5 ;
	$resultado = $dao->getProjetosFiltro('id', 'asc', 0, $resultadosPorPagina);
	echo '
	<div id ="visualisar_usuarios_table_loader">
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
	</div>
	<div class = "pagination">
		<a href="#" class = "pagination_arrow" data-tipoflecha = "0">&laquo;</a><div class = "pagination_numeros_div">';
		$totalusuarios = $dao->getTotalProjetos();
	$totalpaginas = ceil ($totalusuarios / $resultadosPorPagina);
	for($i = 1; $i <= $totalpaginas; $i++)
	{
		
		 echo '<a href="#" class = "pagination_pagina" data-idpagina="'.$i.'">'.$i.'</a>';
	}
	echo ' </div><a href="#" class = "pagination_arrow" data-tipoflecha = "1">&raquo;</a></div>';
?>

<script type = "text/javascript">
	var procurandoListaUsuario = false;
	$(".pagination_numeros_div .pagination_pagina:first-child").toggleClass("active");
	$(document).ready(function(){
		var paginaatual = 1;
		var totalpaginas = <?php echo $totalpaginas; ?>;
		var resultadosPorPagina = <?php echo $resultadosPorPagina ?>;
		ChecarLimite();
		$(".pagination .pagination_pagina").on("click", function()
		{
			
			if(procurandoListaUsuario == true)
			{
				return;
			}
			procurandoListaUsuario = true;
			$(".pagination .active").toggleClass('active');
			$(this).toggleClass('active');
			
			var idpagina = $(this).attr('data-idpagina');
			var limitinicio = (idpagina - 1)* resultadosPorPagina;
			var ordenacao = $("#filtro1 option:selected").val();
			var ordem =  $("#filtro2 option:selected").val();
			$.ajax({
				method : "POST",
				url : "controller/carregadorPaginacaoCadProjetos.php",
				data : { inicio : limitinicio, fim: resultadosPorPagina, ordenacao : ordenacao, ordem : ordem},
				beforeSend : function()
				{
					$("#visualisar_usuarios_table_loader").html('<div class="loader"></div>');
					
					paginaatual = idpagina;
					ChecarLimite();
				},
				success : function (resposta)
				{
					$("#visualisar_usuarios_table_loader").html(resposta);
					procurandoListaUsuario = false;
					ChecarLimite();
				}
			
			});
		});
			
		$(".pagination .pagination_arrow").on("click", function()
		{
			
			if(procurandoListaUsuario == true)
			{
				return;
			}
			procurandoListaUsuario = true;
			var proximapagina;
			if($(this).attr('data-tipoflecha') == 1)
			{
				proximapagina  = $(".pagination .active").next();
			}
			else
			{
				proximapagina  = $(".pagination .active").prev();
			}
			
			if(!proximapagina.hasClass("pagination_pagina"))
			{
				proximapagina = $(".pagination .active");
				procurandoListaUsuario = false;
				return;
			}
			else
			{
				
				$(".pagination .active").toggleClass('active');
				proximapagina.toggleClass('active');
			}
			var idpagina = proximapagina.attr('data-idpagina');
			var limitinicio = (idpagina - 1)* resultadosPorPagina  ;
			var ordenacao = $("#filtro1 option:selected").val();
			var ordem =  $("#filtro2 option:selected").val();
			$.ajax({
				method : "POST",
				url : "controller/carregadorPaginacaoCadProjetos.php",
				data : { inicio : limitinicio, fim: resultadosPorPagina, ordenacao : ordenacao, ordem : ordem},
				beforeSend : function()
				{
					$("#visualisar_usuarios_table_loader").html('<div class="loader"></div>');		
					paginaatual = idpagina;
					ChecarLimite();
				},
				success : function (resposta)
				{
					$("#visualisar_usuarios_table_loader").html(resposta);
					procurandoListaUsuario = false;
					ChecarLimite();
				}
			
			});
		});
		$(".ordenacao_btn_main select").on('change', function()
		{
			 if(procurandoListaUsuario == true)
			 {
			 	return;
			 }
			 procurandoListaUsuario = true;
			 var ordenacao = $("#filtro1").val();
			 var ordem = $("#filtro2").val();
			 
			 $.ajax({
			 	url : "controller/carregadorPaginacaoCadProjetos.php",
			 	method : 'POST',
			 	data : { inicio : 0, fim: resultadosPorPagina, ordenacao : ordenacao, ordem : ordem},
			 	beforeSend : function()
			 	{
			 		$("#visualisar_usuarios_table_loader").html('<div class="loader"></div>');
			 	},
			 	success : function(resposta)
			 	{
			 		$("#visualisar_usuarios_table_loader").html(resposta);
					procurandoListaUsuario = false;
					paginaatual = 1;
					if(!$(".pagination_numeros_div .pagination_pagina:first-child").hasClass("active"))
					{
						$(".active").toggleClass("active");
						$(".pagination_numeros_div .pagination_pagina:first-child").toggleClass("active");
						
					}
					
					ChecarLimite();
			 	}
			 });
		});
		function ChecarLimite()
		{
			if(paginaatual == totalpaginas)
			{
				$('.pagination_arrow[data-tipoflecha = "1"]').css("pointer-events", "none");
				$('.pagination_arrow[data-tipoflecha = "1"]').css("visibility", "hidden");
			}
			else
			{
				$('.pagination_arrow[data-tipoflecha = "1"]').css("pointer-events", "all");
				$('.pagination_arrow[data-tipoflecha = "1"]').css("visibility", "visible");
			}
			if(paginaatual == 1)
			{
				$('.pagination_arrow[data-tipoflecha = "0"]').css("pointer-events", "none");
				$('.pagination_arrow[data-tipoflecha = "0"]').css("visibility", "hidden");
			}
			else
			{
				$('.pagination_arrow[data-tipoflecha = "0"]').css("pointer-events", "all");
				$('.pagination_arrow[data-tipoflecha = "0"]').css("visibility", "visible");
			}
		}
	});
</script>