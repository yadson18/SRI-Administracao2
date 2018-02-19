$(document).ready(function(){
    function municipiosUF(sigla) {
        return $.ajax({
            url: '/Ibge/municipiosUF',
            data: { sigla: sigla },
            dataType: 'json',
            method: 'POST'
        });
    }

    function removeAcentuacao(palavra) {
        var palavraFormatada = palavra;
        var mapaAcentosHex = {
            a: /[\xE0-\xE6]/g,
            A: /[\xC0-\xC6]/g,
            e: /[\xE8-\xEB]/g,
            E: /[\xC8-\xCB]/g,
            i: /[\xEC-\xEF]/g,
            I: /[\xCC-\xCF]/g,
            o: /[\xF2-\xF6]/g,
            O: /[\xD2-\xD6]/g,
            u: /[\xF9-\xFC]/g,
            U: /[\xD9-\xDC]/g,
            c: /\xE7/g,
            C: /\xC7/g,
            n: /\xF1/g,
            N: /\xD1/g,
        };

        for ( var letra in mapaAcentosHex ) {
            palavraFormatada = palavraFormatada.replace(mapaAcentosHex[letra], letra);
        }

        return palavraFormatada;
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
            divEstadual: $('div.estadual'),
            divCnpj: $('.cnpj-block'),
            mensagem: $('.form-content .message-box'),
            complemento: $('input[name=complementar]'),
            estadual: $('input[name=estadual]'),
            fantasia: $('input[name=fantasia]'),
            numero: $('input[name=nrend1]'),
            razao: $('input[name=razao]'),
            cep: $('input[name=cep]')
        };

        $('#breadcrumb .destinatarie-type li').removeClass('active');
        $(this).parent().addClass('active');
        
        switch ($(this).attr('id')) {
            case 'CPF':
                $destinatarie.setCnpj($DOM.inputCnpj.val());
                $destinatarie.setInscEstadual($DOM.divEstadual.find('input').val());

                $DOM.divEstadual.find('label').text('N° Identidade');
                $DOM.divEstadual.find('input').addClass('rgMask').attr({ 
                        placeholder: 'EX: 45.570.332-2',
                        maxlength: 12
                    })
                    .val($destinatarie.getRg()).mask('00.000.000-0', $defaultMaskConfigs);

                $DOM.divCnpj.find('label').text('CPF');
                $DOM.divCnpj.find('.group-input').removeAttr('class').addClass('col-sm-12 group group-input');
                $DOM.inputCnpj.removeClass('cnpjMask').addClass('cpfMask').attr({ 
                        placeholder: 'EX: 095.726.241-80',
                        maxlength: 14
                    })
                    .val($destinatarie.getCpf()).mask(
                        '000.000.000-00', $defaultMaskConfigs
                    ).focusout();
                $DOM.divCnpj.find('.group-button').addClass('hidden').off('click');
                break;
            case 'CNPJ':
                $destinatarie.setCpf($DOM.inputCnpj.val());
                $destinatarie.setRg($DOM.divEstadual.find('input').val());

                $DOM.divEstadual.find('label').text('Inscrição Estadual');
                $DOM.divEstadual.find('input').removeClass('rgMask').attr({ 
                        placeholder: 'EX: ISENTO', 
                        maxlength: 20 
                    })
                    .val($destinatarie.getInscEstadual()).unmask();

                $DOM.divCnpj.find('label').text('CNPJ');
                $DOM.divCnpj.find('.group-input').removeAttr('class').addClass('col-sm-10 col-xs-10 group group-input');
                $DOM.inputCnpj.removeClass('cpfMask').addClass('cnpjMask').attr({ 
                        maxlength: 18, 
                        placeholder: 'EX: 53.965.649/0001-03' 
                    })
                    .val($destinatarie.getCnpj()).mask(
                        '00.000.000/0000-00', $defaultMaskConfigs
                    ).focusout();
                $DOM.divCnpj.find('.group-button').removeClass('hidden')
                    .off('click').on('click', function() {
                        if ($DOM.inputCnpj.cleanVal() !== '') {
                            $.ajax({
                                url: 'http://receitaws.com.br/v1/cnpj/' + $DOM.inputCnpj.cleanVal(),
                                crossDomain: true,
                                dataType: 'jsonp'
                            })
                            .always(function(dados, status) {
                                if (status === 'success') {
                                    if (dados.status === 'OK') {
                                        if (dados.situacao === 'ATIVA') {
                                            $DOM.razao.val(dados.nome);
                                            $DOM.fantasia.val(dados.fantasia);
                                            $DOM.cep.val(
                                                dados.cep.replace(/[.]/g, '')
                                            ).closest('div').find('i').click();
                                            $DOM.numero.val(dados.numero);
                                            $DOM.complemento.val(dados.complemento);
                                        }
                                        else {
                                            $DOM.mensagem.bootstrapAlert(
                                                'error', 'Os dados cadastrais referentes a esse CNPJ, estão desativados.'
                                            );
                                        }
                                    }
                                    else {
                                        $DOM.mensagem.bootstrapAlert('error', 'Desculpe, nada foi encontrado.');
                                    }
                                }
                                else {
                                    $DOM.mensagem.bootstrapAlert(
                                        'warning', 'Não foi possível completar a operação, verifique sua conexão com a internet.'
                                    );
                                }
                            });
                        }
                        else {
                            $DOM.mensagem.bootstrapAlert('error', 'Por favor, digite o CNPJ.');
                        }
                    });
                break;
        }
    });

    function dataFormatoBr(data) {
        return data.split('-').reverse().join('/');
    }

    $('#cadastro-index #contracts').on('show.bs.modal', function(evento) {
        var $DOM = {
            mensagem: $(this).find('.message-box'),
            carregando: $('#contracts .loading'),
            tabela: $(this).find('table tbody'),
            botao: $(evento.relatedTarget)
        };

        $.ajax({
            url: '/Contrato/listaContratosPorCod',
            method: 'POST',
            dataType: 'json',
            data: { contratante: $DOM.botao.val() },
            beforeSend: function() {
                $DOM.carregando.removeClass('hidden');
            }
        })
        .always(function(dados, status) {
            $DOM.tabela.empty();

            if (status === 'success') {
                if (dados.status === 'success') {
                    var $linhasTabela = [];

                    $.each(dados.data, function(indice, valor) {
                        $linhasTabela.push($('<tr></tr>', {
                            html: [
                                $('<th></th>', { html: (++indice) }),
                                $('<td></td>', { html: valor.seq }),
                                $('<td></td>', { html: dataFormatoBr(valor.vencimento) }),
                                $('<td></td>', { html: dataFormatoBr(valor.ativacao) }),
                                $('<td></td>', { html: dataFormatoBr(valor.ultima_cobranca) }),
                                $('<td></td>', { html: valor.valor}).mask(
                                    '000.000.000,0', { reverse: true }
                                ),
                                $('<td></td>', { html: valor.modalidade }),
                                $('<td></td>', { html: (valor.nfe == 1) ? 'SIM' : 'NÃO' }),
                                $('<td></td>', { html: valor.termi_adm }),
                                $('<td></td>', { html: valor.status }),
                                $('<td></td>', { 
                                    class: 'actions',
                                    html: [
                                        $('<a></a>', {
                                            html: $('<i></i>', { class: 'fas fa-pencil-alt' }),
                                            href: '/Contrato/edit/' + valor.seq,
                                            class: 'btn btn-primary btn-xs'
                                        })
                                    ]
                                })
                            ]
                        }));
                    });
                    $DOM.tabela.append($linhasTabela);
                }
                else {
                    $DOM.mensagem.bootstrapAlert(dados.status, dados.message);
                }
            }
            else {
                $DOM.mensagem.bootstrapAlert(
                    'warning', 'Não foi possível completar a operação, verifique sua conexão com a internet.'
                );
            }
            $DOM.carregando.addClass('hidden');
        });
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

    function buscarCadastros(evento)
    {
        var $DOM = {
            filtro: $('#finder .filter'),
            mensagem: $('.message-box'),
            busca: $('#finder .search')
        };

        if (evento.type === 'keypress' && evento.keyCode === 13 || 
            evento.type === 'click' && evento.keyCode === undefined
        ) {
            var busca = $DOM.busca.val();
            var filtro = $DOM.filtro.val();

            if (filtro && busca.replace(/[ ]/g, '') !== '') {
                window.location.assign('/Cadastro/index/busca/' + filtro + '/' + window.btoa(busca));
            }
            else {
                $DOM.mensagem.bootstrapAlert('error', 'Por favor, digite uma busca.');
            }
        }
    }

    $('#finder .search').on('keypress', buscarCadastros);
    $('#finder .find').on('click', buscarCadastros);

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
        var $DOM = {
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
                console.log(dados);
                var $opcoes = [];
                var $opcao = null;
                $DOM.estado.parent().prop('disabled', false);
                $DOM.cidade.parent().prop('disabled', false);
                $DOM.endereco.prop('disabled', false);
                $DOM.bairro.prop('disabled', false);

                if (status === 'success' && !dados.erro) {
                    var cidade = removeAcentuacao(dados.localidade).toUpperCase();
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