$(document).ready(function() {
    $("#projeto_view").html('<div class = "loader"></div>');
    $("#projeto_view").load("view/projetos/cad_projeto.php");

    $("#pa-main").on('click', '#opc-cad-proj', function() {
        if (!$(this).hasClass('eq-opc-btn-ativo')) {
            $('.eq-opc-btn-ativo').toggleClass('eq-opc-btn-ativo');
            $(this).toggleClass('eq-opc-btn-ativo');
            $("#projeto_view").html('<div class = "loader"></div>');
            $("#projeto_view").load("view/projetos/cad_projeto.php");
        }
    });
    $("#pa-main").on('click', '#opc-view-proj', function() {
        if (!$(this).hasClass('eq-opc-btn-ativo')) {
            $('.eq-opc-btn-ativo').toggleClass('eq-opc-btn-ativo');
            $(this).toggleClass('eq-opc-btn-ativo');
            $("#projeto_view").html('<div class = "loader"></div>');
            $("#projeto_view").load("view/projetos/visualizar_projeto.php");
        }
    });
});