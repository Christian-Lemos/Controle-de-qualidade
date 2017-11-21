<?php
	include_once "../../model/Usuario.php";
	if(!isset($_SESSION))
	{
		session_start();
	}

	if($_SESSION['usuario']->getAdmin() == false)
	{
		exit();
	}

	include_once "../../util/ConexaoBD.php";

	include_once '../../model/InteradorDB.php';
	include_once "../../dao/UsuarioDAO.php";

	$con = ConexaoBD::CriarConexao();
	$dao = new UsuarioDAO($con);

	$resultado = $dao->getUsuarios();
	$membrosOpcoes;
	while($linha = $resultado->fetch(PDO::FETCH_OBJ))
	{
		$membrosOpcoes .= '<option value = "'.$linha->id.'">'.$linha->nome.'</option>';
	}
	unset($con);	

?>

<form id = "form_cadastro_projeto" onsubmit="return false">
	<label for="nome">Nome  do Projeto:</label>
	<input type = "text" name = "nome" id = "cadastro_projeto_nome" placeholder="Digite aqui o nome do projeto" required/>
	<label for = "gerente">Gerente do projeto</label>
	<select name = "gerente"  id = "gerente" class = "js-example-basic-single">
		<?php
			echo $membrosOpcoes;
		?>
	</select>
	<label for = "desenvolvedores">Desenvolvedores</label>
	<div id = "cad_projeto_desenvolvedores_div">
		<select class="js-example-basic-multiple" id = "desenvolvedores"  style = "padding:0;" name="desenvolvedores[]" multiple="multiple" placeholder = "Selecione um desenvolvedor" required>
		<?php
			echo $membrosOpcoes;
		?>
		</select>
	</div>
	<label for="cadastro_projeto_contrato">Data de assinatura do contrato:</label>
	<input type = "text" onfocus = "blur()" name = "cadastro_projeto_contrato" id = "cadastro_projeto_contrato" placeholder="Data da assinatura do contrato" required/>
	<button type = "submit"  id ="form_cadastro_projeto_btn">Cadastrar</button>
</form>

<script type = "text/javascript">
	$(document).ready(function()
	{
		$("#gerente").select2();
		$('#desenvolvedores').select2();	
	});
</script>

<script type = "text/javascript">
	$('#cadastro_projeto_contrato').datepicker({
   dateFormat: 'dd/mm/yy',
   dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
   dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
   dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
   monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
   monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
   nextText: 'Proximo',
   prevText: 'Anterior'
});
</script>