$(document).ready(function() {
    $("#persona_view").html('<div class = "loader"></div>');
    $("#persona_view").load("view/personas/visualizar_persona.php");

    $("#pa-main").on('click', '#opc-cad-persona', function() {
        if (!$(this).hasClass('eq-opc-btn-ativo')) {
            $('.eq-opc-btn-ativo').toggleClass('eq-opc-btn-ativo');
            $(this).toggleClass('eq-opc-btn-ativo');
            $("#persona_view").html('<div class = "loader"></div>');
            $("#persona_view").load("view/personas/cad_persona.php");
        }
    });
    $("#pa-main").on('click', '#opc-view-persona', function() {
        if (!$(this).hasClass('eq-opc-btn-ativo')) {
            $('.eq-opc-btn-ativo').toggleClass('eq-opc-btn-ativo');
            $(this).toggleClass('eq-opc-btn-ativo');
            $("#persona_view").html('<div class = "loader"></div>');
            $("#persona_view").load("view/personas/visualizar_persona.php");
        }
    });
});