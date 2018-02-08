$(document).ready(function(){
	$('.senha').on('keyup', function() {
		var $DOM = {
			formulario: $('#colaborador-mudar-senha form'),
			mensagem: $('.message-box'),
			senha: $('.senha.inicial'),
			confirmarSenha: $('.senha.confirmar')
		};
		var senha = $DOM.senha.val();
		var confirmar = $DOM.confirmarSenha.val();

		if (senha.search(/[ ]/g) === -1 && confirmar.search(/[ ]/g) === -1) {
			$DOM.mensagem.empty();

			if (senha !== '' && confirmar !== '') {
				if (senha.length > 3 && confirmar.length > 3) {
					if (senha === $DOM.confirmarSenha.val()) {
						$DOM.formulario.on('submit', function(){ return true; });
						$DOM.senha.closest('div').removeClass('has-error');
						$DOM.confirmarSenha.closest('div').removeClass('has-error');
						$DOM.mensagem.bootstrapAlert('success', 'Senha válida.');
					}
					else {
						$DOM.formulario.on('submit', function(){ return false; });
						$DOM.senha.closest('div').addClass('has-error');
						$DOM.confirmarSenha.closest('div').addClass('has-error');
						$DOM.mensagem.bootstrapAlert('error', 'As senhas digitadas não conferem.');
					}
				}
				else {
					$DOM.formulario.on('submit', function(){ return false; });
					$DOM.mensagem.bootstrapAlert('error', 'As senhas devem conter mais de 3 caracteres.');
				}
			}
		}	
		else {
			$DOM.formulario.on('submit', function(){ return false; });
			$DOM.mensagem.bootstrapAlert('error', 'As senhas não podem conter espaços.');
		}
	})
	.on('keydown', function() {
		$('#colaborador-mudar-senha form').off('submit');
	});
});