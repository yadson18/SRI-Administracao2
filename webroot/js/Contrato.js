$(document).ready(function(){
	$('#finder').on('show.bs.modal', function(evento) {
        var $DOM = {
            mensagem: $(this).find('.message-box'),
            busca: $(this).find('.search-content'),
            carregando: $(this).find('.loading'),
        	tabela: $(this).find('table tbody'),
            filtro: $(this).find('.filter'),
            buscar: $(this).find('.find')
        };

        $DOM.buscar.on('click', function() {
        	$DOM.mensagem.empty();

        	if ($DOM.filtro.val() && $DOM.busca.val().replace(/[ ]/g, '') !== '') {
		        $.ajax({
					url: '/Cadastro/buscaCadastro',
					method: 'POST',
					dataType: 'json',
					data: { 
						filtro: $DOM.filtro.val(), 
						busca: $DOM.busca.val() 
					},
					beforeSend: function() { $DOM.carregando.removeClass('hidden'); }
				})
				.always(function(dados, status) {
					$DOM.tabela.empty();

					if (status === 'success') {
						if (dados.status === 'success') {
							var $linhasTabela = [];

							$.each(dados.data, function(indice, valor) {
								$linhasTabela.push($('<tr></tr>', {
									html: [
										$('<th></th>', { html: ++indice }),
										$('<td></td>', { html: valor.cod_cadastro, class: 'cod_cadastro' }),
										$('<td></td>', { 
											html: valor.cnpj, 
											class: 'cnpj'
										}).mask(function(valor) {
											return (valor.length === 14) ? '00.000.000/0000-00' : '000.000.000-00';
										}),
										$('<td></td>', { html: valor.razao, class: 'razao' }),
										$('<td></td>', { html: valor.cep, class: 'cep' }).mask('00000-000'),
										$('<td></td>', { 
											html: [ $('<input/>', { class: 'check-unic', type: 'checkbox' }) ]
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
        	}
        	else {
                $DOM.mensagem.bootstrapAlert('error', 'Por favor, preencha o campo de busca e tente novamente.');
            }
        });
    })
    .on('hidden.bs.modal', function(evento) {
        $(this).find('.find').off('click');
    });

    $(this).on('click', 'input.check-unic', function() {
        $('input.check-unic').prop('checked', false);
        $(this).prop('checked', true);
    });

    $('#finder .inserir').on('click', function() {
    	var $DOM = {
    		linhaSelecionada: $('#finder .check-unic:checked').closest('tr'),
    		respFinanceiro: $('input[name=cod_resp_financeiro]'),
    		equipamentos: $('table tbody.equipamentos'),
    		contratante: $('input[name=contratante]'),
    		razao: $('input[name=razao_social]'),
    		mensagem: $('#finder .message-box'),
    		modal: $('#finder')
    	};

    	if ($DOM.linhaSelecionada.length === 1) {
    		var cod_cadastro = $DOM.linhaSelecionada.find('.cod_cadastro').text();
    		var razao = $DOM.linhaSelecionada.find('.razao').text();
    		var cnpj = $DOM.linhaSelecionada.find('.cnpj').cleanVal();
    		var cep = $DOM.linhaSelecionada.find('.cep').cleanVal();

            $DOM.mensagem.empty();
    		$DOM.contratante.val(cod_cadastro);
    		$DOM.razao.val(razao);
    		$DOM.equipamentos.find('tr:nth-child(1)').remove();
    		$DOM.equipamentos.prepend($('<tr></tr>', {
    			html: [
    				$('<th></th>', { html: 1 }),
    				$('<td></td>', {
    					html: $('<input/>', { 
    						class: 'form-control input-sm disabled',
    						name: 'equipamento[0][numero_ecf]',
                            maxlength: 4,
    						value: 0
    					})
    				}),
    				$('<td></td>', {
    					html: $('<input/>', { 
    						class: 'form-control input-sm disabled',
    						name: 'equipamento[0][serie_impressora]',
                            value: 'SRI' + cnpj + cep,
                            maxlength: 30
    					})
    				}),
    				$('<td></td>', {
    					html: $('<input/>', { 
    						class: 'form-control input-sm disabled',
    						name: 'equipamento[0][modelo_impressora]',
                            value: 'SRICASH',
                            maxlength: 12
    					})
    				}),
    				$('<td></td>').css({ 'background-color': '#eee' })
    			]
    		}));
    		$DOM.respFinanceiro.val(cod_cadastro);
    		$DOM.modal.modal('toggle');
    	}
    	else {
    		$DOM.mensagem.bootstrapAlert('error', 'Desculpe, nenhum cadastro foi selecionado.');
    	}
    });

    $('.add-equip').on('click', function() {
        var $DOM = {
            equipamentos: $('table tbody.equipamentos'),
            mensagem: $('.form-body .message-box')
        };
        var equipamentos = $DOM.equipamentos.children().length;

        if (equipamentos > 0) {
            $DOM.mensagem.empty();
            $DOM.equipamentos.append($('<tr></tr>', {
                id: equipamentos,
                html: [
                    $('<th></th>', { html: (equipamentos + 1) }),
                    $('<td></td>', {
                        html: $('<input/>', { 
                            name: 'equipamento[' + equipamentos + '][numero_ecf]',
                            class: 'form-control input-sm',
                            placeholder: 'EX: 072',
                            required: true,
                            maxlength: 4
                        })
                    }),
                    $('<td></td>', {
                        html: $('<input/>', { 
                            name: 'equipamento[' + equipamentos + '][serie_impressora]',
                            class: 'form-control input-sm',
                            placeholder: 'EX: RD58545664',
                            required: true,
                            maxlength: 30
                        })
                    }),
                    $('<td></td>', {
                        html: $('<input/>', { 
                            name: 'equipamento[' + equipamentos + '][modelo_impressora]',
                            class: 'form-control input-sm',
                            placeholder: 'EX: HP DESKJET',
                            required: true,
                            maxlength: 12
                        })
                    }),
                    $('<td></td>', {
                        html: $('<button></button>', {
                            html: $('<i></i>', { class: 'fas fa-trash-alt' }),
                            class: 'btn btn-danger btn-xs',
                            'data-target': '#delete',
                            'data-toggle': 'modal',
                            value: equipamentos,
                            type: 'button'
                        })
                    })
                ]
            }));
        }
        else {
            $DOM.mensagem.bootstrapAlert('warning', 'Por favor, adicione um cliente ao contrato.');
        }
    });

    $('#contrato-add #delete').on('show.bs.modal', function(evento) {
        var $DOM = {
            equipamentos: $('table tbody.equipamentos'),
            mensagem: $('.form-body .message-box'),
            botao: $(evento.relatedTarget)
        };

        $(this).find('.confirm').on('click', function() {
            $DOM.linhaParaRemover = $('#' + $DOM.botao.val());

            if ($DOM.linhaParaRemover.length > 0) {
                $DOM.linhaParaRemover.remove();
                $DOM.equipamentos.find('th').each(function(indice) { $(this).text(++indice); });
            }
            else {
                $DOM.mensagem.bootstrapAlert('error', 'Desculpe, o equipamento não pode ser deletado.');
            }
        });
    })
    .on('hidden.bs.modal', function(evento) {
        $(this).find('.confirm').off('click');
    });

    $('#vendedores .inserir').on('click', function() {
        var $DOM = {
            linhaSelecionada: $('#vendedores .check-unic:checked').closest('tr'),
            codVendedor: $('input[name=cod_vendedor]'),
            mensagem: $('#vendedores .message-box'),
            nomeVendedor: $('input#vendedor'), 
            modal: $('#vendedores')
        };

        if ($DOM.linhaSelecionada.length === 1) {
            $DOM.mensagem.empty();
            $DOM.codVendedor.val($DOM.linhaSelecionada.find('.id').text());
            $DOM.nomeVendedor.val($DOM.linhaSelecionada.find('.nome').text());
            $DOM.modal.modal('toggle');
        }
        else {
            $DOM.mensagem.bootstrapAlert('error', 'Desculpe, nenhum vendedor foi selecionado.');
        }
    });

	$('select[name=sintetico]').on('change', function() {
		var $DOM = {
			mensagem: $('.form-body .message-box'),
			analitico: $('select[name=analitico]')
		};

		$.ajax({
			url: '/PlanoConta/getAnaliticosPorCod',
			method: 'POST',
			dataType: 'json',
			data: { sintetico: $(this).val() },
			beforeSend: function() {
				$DOM.analitico.prop('disabled', true);
			}
		})
		.always(function(dados, status) {
			if (status === 'success') {
				if (dados.status === 'success') {
					var $opcoes = [];

					$.each(dados.data, function(indice, valor) {
						$opcoes.push($('<option></option>', {
							value: valor.analitico,
							html: valor.descricao
						}));
					});

					$DOM.analitico.empty().append($opcoes).prop('disabled', false);
				}
			}
			else {
				$DOM.mensagem.bootstrapAlert(
                    'warning', 'Não foi possível completar a operação, verifique sua conexão com a internet.'
                );
			}
		});
	});

	$('#breadcrumb .contract-pages a').on('click', function() {
        var $DOM = {
            contratante: $('.contratante'),
            financeiro: $('.financeiro')
        };

        $('#breadcrumb .contract-pages li').removeClass('active');
        $(this).parent().addClass('active');
        
        switch ($(this).attr('id')) {
            case 'CONTRATANTE':
                $DOM.contratante.removeClass('hidden');
                $DOM.financeiro.addClass('hidden');
                break;
            case 'FINANCEIRO':
                $DOM.financeiro.removeClass('hidden');
            	$DOM.contratante.addClass('hidden');
               	break;
        }
    });
});