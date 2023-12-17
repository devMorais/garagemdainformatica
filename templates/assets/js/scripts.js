document.addEventListener('DOMContentLoaded', function () {
    const typed = new Typed('#typed-output', {
        strings: ['Transformando ideias em realidade!'],
        typeSpeed: 100,
        backSpeed: 50,
        backDelay: 500,
        loop: true
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const typedElements = document.querySelectorAll('.typed-intro');
    typedElements.forEach(function (element) {
        const typed = new Typed(element, {
            strings: ['Landing Pages Cativantes', 'Vídeos 2D Inovadores', 'Websites Atraentes'],
            typeSpeed: 100,
            backSpeed: 50,
            backDelay: 2000,
            loop: true
        });
    });
});

//################# BOOTSTRAP #####################

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[tooltip="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});

//################# FIM BOOTSTRAP #################

$(document).ready(function () {

    $('.formularioAjax').submit(function (event) {
        event.preventDefault();

        var carregando = $('.ajaxLoading');
        var botao = $(':input[type="submit"]');

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            processData: false,
            beforeSend: function () {
                carregando.show().fadeIn(200);
                botao.prop('disable', false).addClass('disabled');
            },
            success: function (retorno) {

                if (retorno.erro) {
                    alerta(retorno.erro, 'yellow');
                }
                if (retorno.successo) {
                    $('.formularioAjax')[0].reset();
                    $('#contatoModal').modal('hide');

                    alerta(retorno.successo, 'green');
                }

                if (retorno.redirecionar) {
                    window.location.href = retorno.redirecionar;
                }

            },
            complete: function () {
                carregando.hide().fadeOut(200);
                botao.removeClass('disabled');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            }
        });

    });

});


function alerta(mensagem, cor) {
    new jBox('Notice', {
        content: mensagem,
        color: cor,
        animation: 'pulse',
        showCountdown: true
    });
}