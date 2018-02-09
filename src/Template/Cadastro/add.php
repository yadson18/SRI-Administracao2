<div id='cadastro-add' class='col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1'>
	<?= $this->Form->start('', ['class' => 'form-content col-sm-12']) ?>
		<div class='form-header text-center'>
			<h4>Adicionar Cliente</h4>
		</div>
		<div class='form-body'>
			<div class='form-group' id='breadcrumb'>
				<ul class='nav nav-tabs destinatarie-type'>
					<li role='breadcrumb-item' class='active'>
						<a href='#' id='CPF'>Pessoa Física</a>
					</li>
					<li role='breadcrumb-item'>
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
							<label>CPF</label>
							<div class='row'>
								<div class='col-sm-12'>
									<div class='col-sm-12 group group-input'>
										<?= $this->Form->input('' , [
												'class' => 'form-control input-sm cpfMask',
												'placeholder' => 'EX: 095.726.241-80',
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
								</div>
							</div>
						</div>
						<div class='form-group col-sm-6 estadual'>
							<?= $this->Form->input('N° Identidade', [
									'class' => 'form-control input-sm text-uppercase rgMask',
									'placeholder' => 'EX: 45.570.332-2', 
									'name' => 'estadual',
									'maxlength' => 20
								]) 
							?>
						</div> 
					</div>
				</div>
				<div class='form-group col-sm-6'>
					<?= $this->Form->input('Razão Social', [
							'placeholder' => 'EX: FRUTAS E VERDURAS LTDA',
							'maxlength' => 60,
							'name' => 'razao'
						]) 
					?>
				</div>
				<div class='form-group col-sm-6'>
					<?= $this->Form->input('Fantasia', [
							'placeholder' => 'EX: FRUTAS E VERDURAS',
							'maxlength' => 40
						]) 
					?>
				</div>
				<div class='form-group col-sm-4 icon-right'>
					<?= $this->Form->input('CEP', [
							'class' => 'form-control input-sm cepMask',
							'placeholder' => 'EX: 50000-000'
						]) 
					?>	
					<i class='fas fa-search icon col-icon icon-sm button' id='find-cep'></i>
				</div>
				<div class='form-group col-sm-3'>
					<?= $this->Form->select('Estado', array_column(
							$estados, 'sigla', 'sigla'
						)) 
					?>
				</div>
				<div class='form-group col-sm-5'>	
					<?= $this->Form->select('Cidade', array_column(
							$municipios, 'nome_municipio', 'nome_municipio'
						)) 
					?>
				</div>
				<div class='form-group col-md-5 col-sm-6'>	
					<?= $this->Form->input('Bairro', [
							'placeholder' => 'EX: CENTRO',
							'maxlength' => 30
						]) 
					?>
				</div>
				<div class='form-group col-md-5 col-sm-6'>	
					<?= $this->Form->input('Endereço', [
							'placeholder' => 'EX: RUA CARLOS AFONSO',
							'maxlength' => 40
						]) 
					?>
				</div>
				<div class='form-group col-md-2 col-sm-4'>	
					<?= $this->Form->input('Número', [
							'placeholder' => 'EX: S/N',
							'name' => 'nrend1',
							'maxlength' => 12
						]) 
					?> 
				</div>
				<div class='form-group col-md-5 col-sm-8'>	 
					<?= $this->Form->input('Complemento', [
							'placeholder' => 'EX: EMPRESARIAL ABC, 22',
							'name' => 'complementar',
							'maxlength' => 40
						]) 
					?>
				</div>
				<div class='form-group col-sm-7'>	
					<?= $this->Form->select('Código de Regime Tributário', [
							'SIMPLES NACIONAL - EXCESSO DE SUBLIMITE DA RECEITA BRUTA' => 2,
							'SIMPLES NACIONAL' => 1,
							'REGIME NORMAL' => 3
						], [
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
</div>