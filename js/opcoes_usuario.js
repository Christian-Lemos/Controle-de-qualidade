$(document).ready(function(){
	$("#usuario_view").html('<div class = "loader"></div>');
	$("#usuario_view").load("view/usuarios/cad_usuario.php");
console.log("ola");
	$("#pa-main").on('click', '#opc-cad-user', function()
	{
		console.log("oi");
		if(!$(this).hasClass('eq-opc-btn-ativo'))
		{
			$('.eq-opc-btn-ativo').toggleClass('eq-opc-btn-ativo');
			$(this).toggleClass('eq-opc-btn-ativo');
			$("#usuario_view").html('<div class = "loader"></div>');
			$("#usuario_view").load("view/usuarios/cad_usuario.php");
		}
	});	
	$("#pa-main").on('click', '#opc-view-user', function()
	{
		console.log("ola");
		if(!$(this).hasClass('eq-opc-btn-ativo'))
		{
			$('.eq-opc-btn-ativo').toggleClass('eq-opc-btn-ativo');
			$(this).toggleClass('eq-opc-btn-ativo');
			$("#usuario_view").html('<div class = "loader"></div>');
			$("#usuario_view").load("view/usuarios/visualizar_usuario.php");
		}
	});
});