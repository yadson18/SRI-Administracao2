$(document).ready(function(){
	function atualizar()
	{
		var $DOM = {
			mensagem: $('#contratoserie-index .message-box'),
			nome: $(this).find('span'),
			icone: $(this).find('i'),
			botao: $(this)
		};

		var atualizar = ($DOM.nome.text() === 'Ativar') ? 'T' : 'F';
		$DOM.botao.prop('disabled', true).find('i').hide();
		$DOM.nome.text('Aguarde...');

		$.ajax({
			url: '/ContratoSerie/edit',
			method: 'POST',
			dataType: 'json',
			data: { 
				seq_contrato: $DOM.botao.attr('seq'), 
				serie_impressora: $DOM.botao.val(),
				atualizar: atualizar
			}
		})
		.always(function(dados, status) {
			if (status === 'success') {
				if (dados.status === 'success') {
					$DOM.botao.prop('disabled', false)
					$DOM.botao.removeClass('btn-success').removeClass('btn-danger');
					$DOM.icone.removeAttr('class');

					if (atualizar === 'F') {
						$DOM.icone.addClass('fas fa-check').show();
						$DOM.botao.addClass('btn-success');
						$DOM.nome.text('Ativar');
					}
					else {
						$DOM.icone.addClass('fas fa-times').show();
						$DOM.botao.addClass('btn-danger');
						$DOM.nome.text('Desativar');
					}
				}
				$DOM.mensagem.bootstrapAlert(dados.status, dados.message);
			}
			else {
				$DOM.mensagem.bootstrapAlert(
                    'warning', 'Não foi possível completar a operação, verifique sua conexão com a internet.'
                );
			}
		});
	}

	function buscarLicencas(evento)
    {
        var $DOM = {
            filtro: $('#finder .search select'),
            mensagem: $('.message-box'),
            busca: $('#finder .search input')
        };

        if (evento.type === 'keypress' && evento.keyCode === 13 || 
            evento.type === 'click' && evento.keyCode === undefined
        ) {
            var busca = $DOM.busca.val();
            var filtro = $DOM.filtro.val();

            if (filtro && busca.replace(/[ ]/g, '') !== '') {
                window.location.assign('/ContratoSerie/index/busca/' + filtro + '/' + window.btoa(busca));
            }
            else {
                $DOM.mensagem.bootstrapAlert('error', 'Por favor, digite uma busca.');
            }
        }
    }

    $('#contratoserie-index .atualizar').on('click', atualizar);

    $('#finder .search input').on('keypress', buscarLicencas);

    $('#finder .search .find').on('click', buscarLicencas);
    
    $('#finder .filter button').on('click', function() {
		var $DOM = {
            mensagem: $('.message-box'),
            filtro: $('#finder .filter input:checked')
        };

        if ($DOM.filtro.length > 0 && $DOM.filtro.val()) {
        	window.location.assign('/ContratoSerie/index/busca/3/' + window.btoa($DOM.filtro.val()));
        }
        else {
            $DOM.mensagem.bootstrapAlert('error', 'Por favor, selecione um filtro.');
        }
	});
});