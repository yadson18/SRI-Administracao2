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
			<div class='col-sm-5 form-group search'>
				<div class='input-group icon-right'>
					<span class='input-group-btn'>
						<select class='btn btn-default btn-sm'>
	  						<option value='1'>CNPJ/CPF</option>
	  						<option value='2'>RAZÃO SOCIAL</option>
						</select>
					</span>
					<input class='form-control input-sm text-uppercase' placeholder='Digite sua busca aqui'/>
					<button class='btn btn-sm button fas fa-search icon icon-sm find'></button>
				</div>
			</div>
			<div class='col-sm-7 pull-right filter'>
				<div class='pull-right'>					
					<label>Filtro <i class='fas fa-filter'></i>:</label>
					<input type='radio' name='type' value='T'> Licenças Ativas.
					<input type='radio' name='type' value='F'> Licenças Canceladas.
					<button class='btn btn-primary btn-sm'>
						Filtrar <i class='fas fa-search'></i>
					</button>
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
			        	<th>Serie do Equipamento</th>
			        	<th>Dias</th>
			        	<th>Última Renovação</th>
			        	<th>Atualizar</th>
			      	</tr>
			    </thead>
			    <?php if(!empty($licencas)): ?>
				    <tbody class='text-capitalize'>
				    		<?php foreach($licencas as $indice => $licenca): ?>
					    		<tr id=<?= $licenca['serie_impressora'] ?>>
					    			<th><?= ++$indice ?></th>
						        	<td><?= $licenca['razao'] ?></td>
									<td><?= $licenca['modalidade'] ?></td>
									<td><?= $licenca['status'] ?></td>
									<td><?= $licenca['modelo_impressora'] ?></td>
									<td><?= $licenca['serie_impressora'] ?></td>
									<td><?= $licenca['dias'] ?></td>
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