$(document).ready(function(){
    function login(evento) {
        var $DOM = {
            formulario: $('#login form'),
            botao: $('#enter')
        };

        if (evento.type === 'click' && $(this).attr('id') === 'enter' ||
            evento.type === 'keydown' && evento.keyCode === 13
        ) {
            $.ajax({
                url: '/Colaborador/login',
                data: $DOM.formulario.formToJSON(),
                method: 'POST',
                dataType: 'json',
                beforeSend: function() {
                    $DOM.botao.disable().find('span').text('Entrando...').parent().find('i').hide();
                }
            })
            .always(function(dados, status) {
                $DOM.botao.enable().find('span').text('Entrar').parent().find('i').show();

                if (status === 'success') {
                    if (dados.redirect) {
                        $(location).redirect(dados.redirect)
                    }
                    else {
                        $.each($DOM.formulario.find('input'), function() {
                            $(this).inputAlert((!$(this).notEmpty()) ? 'error' : 'none');
                            $(this).on('focusout', function() {
                                $(this).inputAlert((!$(this).notEmpty()) ? 'error' : 'none');
                            });
                        });
                        $('#login #message-box').bootstrapAlert(dados.status, dados.message);
                    }
                }
                else { 
                    $('#login #message-box').bootstrapAlert(
                        'warning', 'Não foi possível completar a operação, verifique sua conexão com a internet.'
                    );
                }
            });
        }
    }

    $('#login form').on('keydown', login);

    $('#enter').on('click', login);
});