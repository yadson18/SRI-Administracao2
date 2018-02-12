$(document).ready(function(){
	/*$('#busca-vendedor').on('click', function() {
		console.log('ok');
	});*/

	$('select[name=sintetico]').on('change', function() {
		var $DOM = {
			mensagem: $('.form-content .message-box'),
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
            mensagem: $('.form-content .message-box'),
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