<?php
    include_once "../../model/Usuario.php";
    if(!isset($_SESSION))
    {
        session_start();
    }
    if(!isset ($_SESSION['usuario']) || $_SESSION['usuario']->getAdmin() == false)
    {
        die();
    }
    include_once '../../dao/UsuarioDAO.php';
    $dao = new UsuarioDAO();
    $resultadosPorPagina = 5;
    $totalusuarios = $dao->getTotalUsuarios();
    $totalpaginas = ceil ($totalusuarios / $resultadosPorPagina);
?>
<div class = "ordenacao_btn_main">
    <form class = "pesquisa_user_proj" id = "pesquisa_user" onsubmit ="return false">
        <label for ="pesquisa">Nome do usuário que deseja pesquisar: </label>
        <input type = "text" id= "pesquisa_user_proj_pesquisa" name = "pesquisa" placeholder = "Digite o nome do usuário">
        <button type = "submit">Pesquisar</button>
    </form>
</div>
<div class = "ordenacao_btn_main">
    <div class = "ordenacao_btn_div">
        <label for = "filtro1">Ordenar por:</label>
        <select name = "filtro1" id = "filtro1">
            <option value="id">ID</option>
            <option value = "login">Login</option>
            <option value = "nome">Nome</option>
        </select>
    </div>
    <div class = "ordenacao_btn_div">
        <label for = "filtro2">Em ordem:</label>
        <select name = "filtro2" id = "filtro2">
            <option value = "asc">Crescente</option>
            <option value="desc">Descrecente</option>
        </select>
    </div>
</div>
 <div id ="visualisar_usuarios_table_loader">
 </div>

<div class = "pagination">
    <a href="#" class = "pagination_arrow" data-tipoflecha = "0">&laquo;</a>
    <div class = "pagination_numeros_div">

<?php
    for($i = 1; $i <= $totalpaginas; $i++)
    {
       echo '<a href="#" class = "pagination_pagina" data-idpagina="'.$i.'">'.$i.'</a>';
    }
?>
   </div>
   <a href="#" class = "pagination_arrow" data-tipoflecha = "1">&raquo;</a>
</div>

<script type = "text/javascript">
var procurandoListaUsuario = true;
$(".pagination_numeros_div .pagination_pagina:first-child").toggleClass("active");
var paginaatual = 1;
var totalpaginas = <?php echo $totalpaginas; ?>;
var resultadosPorPagina = <?php echo $resultadosPorPagina ?>;
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
$.ajax({
    url: "controller/usuario/carregadorPaginacaoCadUsuarios.php",
    method: 'GET',
    data: {
        inicio: 0,
        fim: resultadosPorPagina,
        ordenacao: 'id',
        ordem: 'asc'
    },
    beforeSend: function() {
        $("#visualisar_usuarios_table_loader").html('<div class="loader"></div>');
    },
    success: function(resposta) {
        $("#visualisar_usuarios_table_loader").html(resposta);
        procurandoListaUsuario = false;
        paginaatual = 1;
        if (!$(".pagination_numeros_div .pagination_pagina:first-child").hasClass("active")) {
            $(".active").toggleClass("active");
            $(".pagination_numeros_div .pagination_pagina:first-child").toggleClass("active");
        }
        ChecarLimite();
    }
});
$(document).ready(function() {
    
    ChecarLimite();
    
    $("#pesquisa_user").on('submit', function(){
       
       if(procurandoListaUsuario == true)
       {
           return;
       }
       procurandoListaUsuario = true;
       
       var pesquisa = $("#pesquisa_user_proj_pesquisa").val();
       var ordenacao = $("#filtro1 option:selected").val();
       var ordem = $("#filtro2 option:selected").val();
       
       $.ajax({
          method : "GET",
          url : "controller/usuario/carregadorPesquisaAvancadaUsuario.php",
          data : {pesquisa : pesquisa, ordenacao : ordenacao, ordem : ordem},
          
          beforeSend : function()
          {
              $("#visualisar_usuarios_table_loader").html('<div class="loader"></div>');
          },
          success : function(resposta)
          {
            $("#visualisar_usuarios_table_loader").html(resposta);
            procurandoListaUsuario = false;
            paginaatual = 1;
            if (!$(".pagination_numeros_div .pagination_pagina:first-child").hasClass("active")) 
            {
                $(".active").toggleClass("active");
                $(".pagination_numeros_div .pagination_pagina:first-child").toggleClass("active");
            }
            ChecarLimite();
          }
       });
       
    });
    
    $(".pagination .pagination_pagina").on("click", function() {

        if (procurandoListaUsuario == true) {
            return;
        }
        procurandoListaUsuario = true;
        $(".pagination .active").toggleClass('active');
        $(this).toggleClass('active');

        var idpagina = $(this).data('idpagina');
        var limitinicio = (idpagina - 1) * resultadosPorPagina;
        var ordenacao = $("#filtro1 option:selected").val();
        var ordem = $("#filtro2 option:selected").val();
        $.ajax({
            
            method : "GET",
            url : "controller/usuario/carregadorPaginacaoCadUsuarios.php",
            data: {
                inicio: limitinicio,
                fim: resultadosPorPagina,
                ordenacao: ordenacao,
                ordem: ordem
            },
            beforeSend: function() {
                $("#visualisar_usuarios_table_loader").html('<div class="loader"></div>');

                paginaatual = idpagina;
                ChecarLimite();
            },
            success: function(resposta) {

                $("#visualisar_usuarios_table_loader").html(resposta);
                procurandoListaUsuario = false;
                ChecarLimite();
            }
        });
    });

    $(".pagination .pagination_arrow").on("click", function() {

        if (procurandoListaUsuario == true) {
            return;
        }
        procurandoListaUsuario = true;
        var proximapagina;
        if ($(this).data('tipoflecha') == 1) {
            proximapagina = $(".pagination .active").next();
        } else {
            proximapagina = $(".pagination .active").prev();

        }

        if (!proximapagina.hasClass("pagination_pagina")) {

            proximapagina = $(".pagination .active");
            procurandoListaUsuario = false;
            return;
        } else {

            $(".pagination .active").toggleClass('active');
            proximapagina.toggleClass('active');
        }
        var idpagina = proximapagina.data('idpagina');
        var limitinicio = (idpagina - 1) * resultadosPorPagina;
        var ordenacao = $("#filtro1 option:selected").val();
        var ordem = $("#filtro2 option:selected").val();
        $.ajax({
            method: "GET",
            url: "controller/usuario/carregadorPaginacaoCadUsuarios.php",
            data: {
                inicio: limitinicio,
                fim: resultadosPorPagina,
                ordenacao: ordenacao,
                ordem: ordem
            },
            beforeSend: function() {
                $("#visualisar_usuarios_table_loader").html('<div class="loader"></div>');
                paginaatual = idpagina;
                ChecarLimite();
            },
            success: function(resposta) {

                $("#visualisar_usuarios_table_loader").html(resposta);
                procurandoListaUsuario = false;
                ChecarLimite();
            }
        });
    });

    $(".ordenacao_btn_main select").on('change', function() {
        if (procurandoListaUsuario == true) {
            return;
        }
        procurandoListaUsuario = true;
        var ordenacao = $("#filtro1").val();
        var ordem = $("#filtro2").val();
        $.ajax({
            url: "controller/usuario/carregadorPaginacaoCadUsuarios.php",
            method: 'GET',
            data: {
                inicio: 0,
                fim: resultadosPorPagina,
                ordenacao: ordenacao,
                ordem: ordem
            },
            beforeSend: function() {
                $("#visualisar_usuarios_table_loader").html('<div class="loader"></div>');
            },
            success: function(resposta) {
                $("#visualisar_usuarios_table_loader").html(resposta);
                procurandoListaUsuario = false;
                paginaatual = 1;
                if (!$(".pagination_numeros_div .pagination_pagina:first-child").hasClass("active")) {
                    $(".active").toggleClass("active");
                    $(".pagination_numeros_div .pagination_pagina:first-child").toggleClass("active");
                }
                ChecarLimite();
            }
        });
    });


    function ChecarLimite() {
        if (paginaatual == totalpaginas) {

            $('.pagination_arrow[data-tipoflecha = "1"]').css("pointer-events", "none");
            $('.pagination_arrow[data-tipoflecha = "1"]').css("visibility", "hidden");
        } else {
            $('.pagination_arrow[data-tipoflecha = "1"]').css("pointer-events", "all");
            $('.pagination_arrow[data-tipoflecha = "1"]').css("visibility", "visible");
        }

        if (paginaatual == 1) {
            $('.pagination_arrow[data-tipoflecha = "0"]').css("pointer-events", "none");
            $('.pagination_arrow[data-tipoflecha = "0"]').css("visibility", "hidden");
        } else {
            $('.pagination_arrow[data-tipoflecha = "0"]').css("pointer-events", "all");
            $('.pagination_arrow[data-tipoflecha = "0"]').css("visibility", "visible");
        }
    }
});
</script>

<script type = "text/javascript">

$("#pa-main").on('click', '.editar_usuario_btn', function() {
    var procid = $(this).data('id');
    $.ajax({
        url: 'view/usuarios/modal_editar_usuario.php',
        method: 'GET',
        data: {
            id: procid
        },
        beforeSend: function() {
            $("#modal-main").show();
            $("#modal-box").html('<div class="loader"></div>');
        },

        success: function(resposta) {
            $("#modal-box").html(resposta);
        }
    });
});

$("#pa-main").on('click', '.excluir_usuario_btn', function() {
    $("#modal-box").css("height", 'auto');

    var procid = $(this).data('id');

    $.ajax({
        url: 'view/modal_confirmacao.php',
        method: 'POST',
        data: {
            acao: 'deletarusuario',
            id: procid
        },
        beforeSend: function() {
            $("#modal-main").show();
            $("#modal-box").html('<div class="loader"></div>');
        },

        success: function(resposta) {
            $("#modal-box").html(resposta);
            return;
        }

    });
});

</script>
