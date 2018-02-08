$(document).ready(function(){
    function municipiosUF(sigla) {
        return $.ajax({
            url: '/Ibge/municipiosUF',
            data: { sigla: sigla },
            dataType: 'json',
            method: 'POST'
        });
    }

    var $destinatarie = (function() {
        var cpf, cnpj, rg, inscricaoEstadual;

        return {
            setCpf: function(cpfValue) {
                if (!cpf && cpfValue.length === 14) {
                    cpf = cpfValue;
                }
            },
            getCpf: function() { 
                return cpf; 
            },
            setCnpj: function(cnpjValue) {
                if (!cnpj && cnpjValue.length === 18) {
                    cnpj = cnpjValue;
                }
            },
            getCnpj: function() { 
                return cnpj; 
            },
            setInscEstadual: function(estadual) {
                if (!inscricaoEstadual) {
                    inscricaoEstadual = estadual;
                }
            },
            getInscEstadual: function() { 
                return inscricaoEstadual; 
            },
            setRg: function(numeroRg) {
                if (!rg) {
                    rg = numeroRg;
                }
            },
            getRg: function() { 
                return rg; 
            }
        };
    })();

    var $defaultMaskConfigs = {
        clearIfNotMatch: true,
        reverse: true,
        optional: false,
        translation: { '0': { pattern: /[0-9]/ } }
    };

    $('#breadcrumb .destinatarie-type a').on('click', function() {
        var $DOM = {
            inputCnpj: $('input[name=cnpj]'),
            divEstadual: $('div.estadual')
        };

        $('#breadcrumb .destinatarie-type li').removeClass('active');
        $(this).parent().addClass('active');
        
        switch ($(this).attr('id')) {
            case 'CPF':
                $destinatarie.setCnpj($DOM.inputCnpj.val());
                $destinatarie.setInscEstadual($DOM.divEstadual.find('input').val());

                $DOM.inputCnpj.closest('div').find('label').text('CPF');
                $DOM.divEstadual.find('label').text('N° Identidade');
                $DOM.divEstadual.find('input').addClass('rgMask').attr({ 
                    placeholder: 'EX: 45.570.332-2',
                    maxlength: 12
                }).val($destinatarie.getRg()).mask('00.000.000-0', $defaultMaskConfigs);
                $DOM.inputCnpj.removeClass('cnpjMask').addClass('cpfMask').attr({ 
                    placeholder: 'EX: 095.726.241-80',
                    maxlength: 14
                })
                .val($destinatarie.getCpf()).mask(
                    '000.000.000-00', $defaultMaskConfigs
                ).focusout();
                break;
            case 'CNPJ':
                $destinatarie.setCpf($DOM.inputCnpj.val());
                $destinatarie.setRg($DOM.divEstadual.find('input').val());

                $DOM.inputCnpj.closest('div').find('label').text('CNPJ');
                $DOM.divEstadual.find('label').text('Inscrição Estadual');
                $DOM.divEstadual.find('input').removeClass('rgMask').attr({ 
                    placeholder: 'EX: ISENTO', 
                    maxlength: 20 
                }).val($destinatarie.getInscEstadual()).unmask();
                $DOM.inputCnpj.removeClass('cpfMask').addClass('cnpjMask').attr({ 
                    maxlength: 18, 
                    placeholder: 'EX: 53.965.649/0001-03' 
                })
                .val($destinatarie.getCnpj()).mask(
                    '00.000.000/0000-00', $defaultMaskConfigs
                ).focusout();
                break;
        }
    });

    $('#cadastro-index #delete').on('show.bs.modal', function(evento) {
        var $DOM = {
            mensagem: $('#cadastro-index .cadastro-lista .message-box'),
            botao: $(evento.relatedTarget),
            paginador: $('#cadastro-index .list-shown')
        };

        $(this).find('button.confirm').on('click', function() {
            $DOM.linhaParaRemover = $('#' + $DOM.botao.val());

            $.ajax({
                url: '/Cadastro/delete',
                method: 'POST',
                dataType: 'json',
                data: { cod_cadastro: $DOM.botao.val() }
            })
            .always(function(dados, status) {
                if (status === 'success') {
                    if (dados.status === 'success') {
                        $DOM.linhaParaRemover.remove();
                        $DOM.paginador.find('.shown, .quantity').each(function() {
                            $(this).mask('000.000.000.000', { reverse: true }).text(
                                $(this).masked(parseInt($(this).cleanVal()) - 1)
                            );
                        });
                        $('#cadastro-index table tbody th').each(function(indice) {
                            $(this).text(++indice);
                        });
                    }
                    $DOM.mensagem.bootstrapAlert(dados.status, dados.message);
                }
                else {
                    $DOM.mensagem.bootstrapAlert(
                        'warning', 'Não foi possível completar a operação, verifique sua conexão com a internet.'
                    );
                }
            });
        });
    })
    .on('hidden.bs.modal', function(evento) {
        $(this).find('button.confirm').off('click');
    });

    $('select[name=estado]').on('change', function() {
        var $DOM = {
            cidade: $('select[name=cidade]'),
            mensagem: $('.message-box')
        };
        $DOM.cidade.prop('disabled', true);

        municipiosUF($(this).val()).always(function(dados, status) {
            if (status === 'success' && dados.municipios) {
                var $opcoes = [];
                $DOM.cidade.prop('disabled', false);
                
                $.each(dados.municipios, function(indice, valor) {
                    $opcoes.push($('<option></option>', {
                        value: valor.nome_municipio, 
                        text: valor.nome_municipio
                    }));
                });

                $DOM.cidade.empty().append($opcoes);
            }   
            else {
                $DOM.mensagem.bootstrapAlert(
                    'warning', 'Não foi possível completar a operação, verifique sua conexão com a internet.'
                );
            }
        });
    });

    $('#find-cep').on('click', function() {
        $DOM = {
            estado: $('select[name=estado] option'),
            cidade: $('select[name=cidade] option'),
            endereco: $('input[name=endereco]'),
            bairro: $('input[name=bairro]'),
            mensagem: $('.message-box'),
            cep: $('input[name=cep]')
        };
        $DOM.cepDiv = $DOM.cep.closest('div');
        $DOM.mensagem.empty();

        if ($DOM.cep.cleanVal().length === 8) {
            $.ajax({
                url: 'https://viacep.com.br/ws/' + $DOM.cep.cleanVal() + '/json/',
                dataType: 'json',
                method: 'GET',
                beforeSend: function() {
                    $DOM.cepDiv.removeClass('has-error');
                    $DOM.estado.parent().prop('disabled', true);
                    $DOM.cidade.parent().prop('disabled', true);
                    $DOM.endereco.prop('disabled', true);
                    $DOM.bairro.prop('disabled', true);
                }
            })
            .always(function(dados, status) {
                var $opcoes = [];
                var $opcao = null;
                $DOM.estado.parent().prop('disabled', false);
                $DOM.cidade.parent().prop('disabled', false);
                $DOM.endereco.prop('disabled', false);
                $DOM.bairro.prop('disabled', false);

                if (status === 'success' && !dados.erro) {
                    var cidade = dados.localidade.toUpperCase();
                    $DOM.estado.filter(':contains('+ dados.uf +')').prop('selected', true);
                    $DOM.cidade.filter(':contains('+ cidade +')').prop('selected', true);
                    $DOM.endereco.val(dados.logradouro.toUpperCase());
                    $DOM.bairro.val(dados.bairro.toUpperCase());

                    if ($DOM.cidade.filter(':contains('+ cidade +')').length === 0) {
                        municipiosUF(dados.uf).always(function(dataAjax, status) {
                            if (status === 'success' && dataAjax.municipios) {
                                $.each(dataAjax.municipios, function(indice, valor) {
                                    $opcao = $('<option></option>', {
                                        value: valor.nome_municipio, 
                                        text: valor.nome_municipio
                                    });
                                    if (valor.nome_municipio === cidade) {
                                        $opcao.prop('selected', true);
                                    }
                                    $opcoes.push($opcao);
                                });
                                $DOM.cidade.parent().empty().append($opcoes);
                            }   
                            else {
                                $DOM.mensagem.bootstrapAlert(
                                    'error', 'Desculpe, não encontramos nenhum município relacionado a esse CEP.'
                                );
                            }
                        });
                    }
                }
                else {
                    $DOM.cepDiv.addClass('has-error');
                    $DOM.mensagem.bootstrapAlert('error', 'CEP inválido, tente novamente.');
                    $DOM.estado.filter(':contains(AC)').prop('selected', true).change();
                    $DOM.bairro.val('');
                    $DOM.endereco.val('');
                }
            });
        }
        else {
            $DOM.mensagem.bootstrapAlert('error', 'Por favor, digite um CEP.');
        }
    });
});