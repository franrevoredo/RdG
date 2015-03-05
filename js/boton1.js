$(document).ready(function () {
    $('#form').hide();

    $('#boton').on('click', function () {
        $(this).hide(500);
        $('#form').show(400);
    });
});