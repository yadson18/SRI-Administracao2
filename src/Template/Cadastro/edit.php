<div id='cadastro-edit' class='col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1'>
	<?php if(!empty($cadastro)): ?>
		<?= $this->Form->start('', ['class' => 'form-content col-sm-12']) ?>
			<div class='form-header text-center'>
				<h4>Modificar Cliente</h4>
			</div>
			<div class='form-body'>
				<div class='form-group' id='breadcrumb'>
					<ul class='nav nav-tabs destinatarie-type'>
						<li class=<?php echo ($cadastroTipo === 'cpf') ? 'active' : '' ?> role='breadcrumb-item'>
							<a href='#' id='CPF'>Pessoa Física</a>
						</li>
						<li class=<?php echo ($cadastroTipo === 'cnpj') ? 'active' : '' ?> role='breadcrumb-item'>
							<a href='#' id='CNPJ'>Pessoa Jurídica</a>
						</li>
					</ul>
				</div>
				<div class='message-box'>
					<?= $this->Flash->showMessage() ?>
				</div>
				<div class='row'>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='form-group col-sm-6 icon-right cnpj-block'>
								<label><?= strtoupper($cadastroTipo) ?></label>
								<div class='row'>
									<div class='col-sm-12'>
										<?php if ($cadastroTipo === 'cnpj'): ?>
											<div class='col-sm-10 col-xs-10 group group-input'>
												<?= $this->Form->input('' , [
														'class' => 'cnpjMask form-control input-sm',
														'placeholder' => 'EX: 53.965.649/0001-03',
														'value' => $cadastro->cnpj,
														'autofocus' => true,
														'name' => 'cnpj'
													]) 
												?>	
											</div>
											<div class='col-sm-2 col-xs-2 group group-button'>
												<button id='find-cnpj' class='btn btn-primary btn-sm btn-block' type='button'>
													<i class='fas fa-search'></i>
												</button>
											</div>
										<?php else: ?>
											<div class='col-sm-12 group group-input'>
												<?= $this->Form->input('' , [
														'class' => 'cpfMask form-control input-sm',
														'placeholder' => 'EX: 095.726.241-80',
														'value' => $cadastro->cnpj,
														'autofocus' => true,
														'name' => 'cnpj'
													]) 
												?>	
											</div>
											<div class='col-sm-2 col-xs-2 group group-button hidden'>
												<button id='find-cnpj' class='btn btn-primary btn-sm btn-block' type='button'>
													<i class='fas fa-search'></i>
												</button>
											</div>
										<?php endif; ?>	
									</div>
								</div>
							</div>
							<div class='form-group col-sm-6 estadual'>
								<?php if($cadastroTipo === 'cnpj'): ?>
									<?= $this->Form->input('Inscrição Estadual', [
											'value' => ($cadastro->estadual) 
												? $cadastro->estadual 
												: 'NÃO INFORMADO',
											'placeholder' => 'EX: ISENTO', 
											'name' => 'estadual',
											'maxlength' => 20
										]) 
									?>
								<?php else: ?>
									<?= $this->Form->input('N° Identidade', [
											'class' => 'form-control input-sm text-uppercase rgMask',
											'placeholder' => 'EX: 45.570.332-2', 
											'value' => $cadastro->estadual,
											'name' => 'estadual',
											'maxlength' => 12
										]) 
									?>
								<?php endif; ?>
							</div> 
						</div>
					</div>
					<div class='form-group col-sm-6'>
						<?= $this->Form->input('Razão Social', [
								'placeholder' => 'EX: FRUTAS E VERDURAS LTDA',
								'value' => $cadastro->razao,
								'maxlength' => 60,
								'name' => 'razao'
							]) 
						?>
					</div>
					<div class='form-group col-sm-6'>
						<?= $this->Form->input('Fantasia', [
								'placeholder' => 'EX: FRUTAS E VERDURAS',
								'value' => $cadastro->fantasia,
								'maxlength' => 40
							]) 
						?>
					</div>
					<div class='form-group col-md-3 col-sm-4'>
						<?= $this->Form->select('País', array_column(
								$paises, 'cpais', 'xpais'
							), [
								'selected' => $cadastro->cpais,
								'name' => 'cpais'
							]) 
						?>
					</div>
					<div class='form-group col-md-3 col-sm-5 icon-right'>
						<?= $this->Form->input('CEP', [
								'class' => 'form-control input-sm cepMask',
								'placeholder' => 'EX: 50000-000',
								'value' => $cadastro->cep
							]) 
						?>
						<i class='fas fa-search icon col-icon icon-sm button' id='find-cep'></i>	
					</div>
					<div class='form-group col-md-2 col-sm-3'>
						<?= $this->Form->select('Estado', array_column(
								$estados, 'sigla', 'sigla'
							), [
								'selected' => $cadastro->estado
							]) 
						?>
					</div>
					<div class='form-group col-md-4 col-sm-5'>	
						<?= $this->Form->select('Cidade', array_column(
								$municipios, 'nome_municipio', 'nome_municipio'
							), [
								'selected' => $cadastro->cidade
							]) 
						?>
					</div>
					<div class='form-group col-md-5 col-sm-7'>	
						<?= $this->Form->input('Endereço', [
								'placeholder' => 'EX: RUA CARLOS AFONSO',
								'value' => $cadastro->endereco,
								'maxlength' => 40
							]) 
						?>
					</div>
					<div class='form-group col-md-2 col-sm-4'>	
						<?= $this->Form->input('Número', [
								'value' => $cadastro->nrend1,
								'placeholder' => 'EX: S/N',
								'maxlength' => 12,
								'name' => 'nrend1'
							]) 
						?> 
					</div>
					<div class='form-group col-md-5 col-sm-8'>	
						<?= $this->Form->input('Bairro', [
								'placeholder' => 'EX: CENTRO',
								'value' => $cadastro->bairro,
								'maxlength' => 30
							]) 
						?>
					</div>
					<div class='form-group col-md-5 col-sm-6'>	 
						<?= $this->Form->input('Complemento', [
								'placeholder' => 'EX: EMPRESARIAL ABC, 22',
								'value' => $cadastro->complementar,
								'name' => 'complementar',
								'maxlength' => 40
							]) 
						?>
					</div>
					<div class='form-group col-md-7 col-sm-6'>	
						<?= $this->Form->select('Código de Regime Tributário', [
								'SIMPLES NACIONAL - EXCESSO DE SUBLIMITE DA RECEITA BRUTA' => 2,
								'SIMPLES NACIONAL' => 1,
								'REGIME NORMAL' => 3
							], [
								'selected' => $cadastro->cod_reg_trib,
								'name' => 'cod_reg_trib'
							]) 
						?>
					</div>
				</div>
			</div>
			<div class='form-footer row'>
				<div class='form-group col-sm-5'>
					<a href='/Cadastro/index' class='btn btn-primary btn-block'>
						<i class='fas fa-angle-double-left'></i> Retornar
					</a>
				</div>
				<div class='form-group col-sm-7'>
					<button class='btn btn-success btn-block'>
						Salvar <i class='fas fa-save'></i>
					</button>
				</div>
			</div>
		<?= $this->Form->end() ?>
	<?php else: ?>
		<div class='text-center data-not-found'>
			<h4>Desculpe, cliente inexistente, deseja retornar?.</h4>
			<div class='col-sm-4 col-sm-offset-4'>
				<a href='/Cadastro/index' class='btn btn-primary btn-block'>
					<i class='fas fa-angle-double-left'></i> Retornar 
				</a>
			</div>
		</div>
	<?php endif; ?>
</div>