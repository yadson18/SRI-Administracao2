<div id='contratoserie-index'>
	<h2 class='page-header'>
		Licenças
		<a href='#' class='btn btn-success'>
			Manutenção Automática <i class='fas fa-cogs'></i>
		</a>
	</h2>
	<div class='container-fluid cadastro-lista'>
		<div class='message-box'></div>
		<div class='row' id='finder'>
			<div class='col-sm-6 form-group'>
				<div class='input-group icon-right'>
					<span class='input-group-btn'>
						<select class='btn btn-default btn-sm filter'>
	  						<option value='1'>CÓDIGO</option>
	  						<option value='2'>CNPJ/CPF</option>
						</select>
					</span>
					<input class='form-control input-sm search text-uppercase' placeholder='Digite sua busca aqui'/>
					<button class='btn btn-sm button fas fa-search icon icon-sm find'></button>
				</div>
			</div>
		</div>
		<div class='table-responsive fixed-height'>
			<table class='table table-bordered'>
			    <thead>
			      	<tr>
			      		<th>#</th>
			        	<th>Razão Social</th>
			        	<th>Modalidade</th>
			        	<th>Situação</th>
			        	<th>Modelo do Equipamento</th>
			        	<th>Dias</th>
			        	<th>Atualizar</th>
			        	<th>Última Renovação</th>
			        	<th>Ações</th>
			      	</tr>
			    </thead>
			    <?php if(!empty($licencas)): ?>
				    <tbody class='text-capitalize'>
				    		<?php foreach($licencas as $indice => $licenca): ?>
					    		<tr id=<?= $licenca['serie_impressora'] ?>>
					    			<th><?= ++$indice ?></th>
						        	<td><?= $licenca['razao_social'] ?></td>
									<td><?= $licenca['modalidade'] ?></td>
									<td><?= $licenca['status'] ?></td>
									<td><?= $licenca['modelo_impressora'] ?></td>
									<td><?= $licenca['dias'] ?></td>
									<td><?= $licenca['atualizar'] ?></td>
									<td><?= date('d/m/Y', strtotime($licenca['ultima_renovacao'])) ?></td>
									<td class='actions'>
										<?php if ($licenca['atualizar'] === 'T'): ?>
											<button seq=<?= $licenca['seq_contrato'] ?> value=<?= $licenca['serie_impressora'] ?> class='btn btn-danger btn-xs btn-block atualizar'>
												<span>Desativar</span> <i class='fas fa-times'></i>
											</button>
										<?php else: ?>
											<button seq=<?= $licenca['seq_contrato'] ?> value=<?= $licenca['serie_impressora'] ?> class='btn btn-success btn-xs btn-block atualizar'>
												<span>Ativar</span> <i class='fas fa-check'></i>
											</button>
										<?php endif ?>
									</td>
					      		</tr>
					      	<?php endforeach; ?>
				    </tbody>
				<?php endif; ?>
			</table>
			<?php if(empty($licencas)): ?>
				<div class='text-center data-not-found'>
					<h4>Nada a ser exibido. <i class='far fa-frown'></i></h4>
				</div>		    	
			<?php endif; ?>
		</div>
		<div class='row'>
			<div class='col-sm-12'>
				<?= $this->Paginator->display(); ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function atualizar()
	{
		var $DOM = {
			botao: $(this),
			icone: $(this).find('i'),
			nome: $(this).find('span')
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
				$('.message-box').bootstrapAlert(dados.status, dados.message);
			}
		});
	}
	$('#contratoserie-index .atualizar').on('click', atualizar);
</script>