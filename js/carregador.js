$("#pa-main").html('<div class="loader"></div>');
var estado_menu = 0;
$(document).ready(function()
{
		$("#pa-main").load("view/inspecoes.php");

		$("aside li").click(function()
		{
			var qual = $(this).attr('id');
			var carregar;
			switch(qual)
			{
				case 'menu-projetos':
					carregar = 'projetos.php';
				break;
				case 'menu-usuarios':
					carregar = 'usuarios.php';
				break;
				case 'menu-personas':
					carregar = "persona.php";
				break;
				case 'menu-conf':
					carregar = "configuracoes.php";
				break;
				case 'menu-inspec':
					carregar = 'inspecoes.php';
				break;
				case 'menu-estatisticas' :
					carregar = 'estatisticas.php';
				break;
				case 'menu-sair':
					window.location.replace("controller/logout.php");
				break;
			};
			$(".ativo").toggleClass("ativo");
			$(this).toggleClass("ativo");
			$("#pa-main").html('<div class="loader"></div>');
			
			if($(window).width() <= 892)
			{
				if(estado_menu == 1)
				{
					$("#abrir_menu_div_seta").css("display", "block"); 
					$("#abrir_menu_div_fechar").css("display", "none"); 
					$("aside").css("width", "");
					estado_menu = 0;
				}
			}
			
			$("#pa-main").load("view/"+carregar);

		});
		
		$("#abrir_menu_div").on('click', function()
		{	
			if(estado_menu == 0)
			{
				$("#abrir_menu_div_seta").css("display", "none"); 
				$("#abrir_menu_div_fechar").css("display", "block"); 
				$("aside").css("width", "100%");
				estado_menu = 1;
			}
			else
			{
				
				$("#abrir_menu_div_seta").css("display", "block"); 
				$("#abrir_menu_div_fechar").css("display", "none");  
				$("aside").css("width", "");
				estado_menu  = 0;
			}
		
		});
});