<div id='contrato-add' class='col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1'>
	<?= $this->Form->start('', ['class' => 'form-content col-sm-12']) ?>
		<div class='form-header text-center'>
			<h4>Adicionar Contrato</h4>
		</div>
		<div class='form-body'>
			<div class='form-group' id='breadcrumb'>
				<ul class='nav nav-tabs contract-pages'>
					<li role='breadcrumb-item' class='active'>
						<a href='#' id='CONTRATANTE'>Contratante</a>
					</li>
					<li role='breadcrumb-item'>
						<a href='#' id='FINANCEIRO'>Financeiro</a>
					</li>
				</ul>
			</div>
			<div class='message-box'>
				<?= $this->Flash->showMessage() ?>
			</div>
			<div class='contratante'>
				<fieldset>
					<legend>
						<i class='fas fa-angle-double-right text-primary'></i> Dados do Contrato
					</legend>
					<div class='form-group col-md-3 col-sm-4'>
						<label>Código do Cliente</label>
						<div class='input-group'>
					      	<?= $this->Form->input('', [
									'value' => (isset($cadastro->cod_cadastro)) ? $cadastro->cod_cadastro : '',
									'class' => 'form-control input-sm disabled',
									'placeholder' => 'EX: 1',
									'name' => 'contratante',
									'min' => 0
								]) 
							?>
					      	<span class='input-group-btn'>
					        	<button class='btn btn-primary btn-sm' type='button'>
					        		Alterar <i class='fas fa-search'></i>
					        	</button>
					      	</span>
		    			</div>	
					</div>
					<div class='form-group col-md-6 col-sm-8'>
						<?= $this->Form->input('Razão Social', [
								'value' => (isset($cadastro->razao)) ? $cadastro->razao : '',
								'placeholder' => 'EX: FRUTAS E VERDURAS LTDA',
								'class' => 'form-control input-sm disabled'
							]) 
						?>
					</div>
					<div class='form-group col-md-3 col-sm-4'>
						<?= $this->Form->select('Status', array_column(
								$status, 'seq', 'descricao'
							)) 
						?>
					</div>
					<div class='form-group col-md-3 col-sm-4'>
						<?= $this->Form->select('Modalidade', array_column(
								$modalidades, 'seq', 'descricao'
							)) 
						?>
					</div>
					<div class='form-group col-md-3 col-sm-4'>
						<?= $this->Form->input('Data de Inclusão', [
								'value' => (isset($cadastro->cod_cadastro)) ? date('d/m/Y') : '',
								'class' => 'form-control input-sm date',
								'placeholder' => 'EX: ' . date('d/m/Y'),
								'name' => 'data_inclusao'
							]) 
						?>
					</div>
					<div class='form-group col-md-3 col-sm-4'>
						<?= $this->Form->input('Data de Ativação', [
								'class' => 'form-control input-sm date',
								'placeholder' => 'EX: ' . date('d/m/Y'),
								'name' => 'data_ativacao'
							]) 
						?>
					</div>
					<div class='form-group col-md-3 col-sm-4'>
						<?= $this->Form->input('Data de Vencimento', [
								'class' => 'form-control input-sm date',
								'placeholder' => 'EX: ' . date('d/m/Y'),
								'name' => 'data_vencimento'
							]) 
						?>
					</div>
					<fieldset class='col-sm-12'>
						<legend>
							<i class='fas fa-angle-right text-primary'></i> Arquivos
						</legend>
						<div class='row'>
							<div class='col-sm-12'>
								<div class='form-group col-md-3 col-sm-4'>
									<?= $this->Form->select('NF-e', ['NÃO' => 0, 'SIM' => 1], [
											'name' => 'nota_fiscal_eletronica'
										]) 
									?>
								</div>
								<div class='form-group col-md-3 col-sm-4'>
									<?= $this->Form->select('EFD', ['NÃO' => 0, 'SIM' => 1], [
											'name' => 'efd'
										]) 
									?>
								</div>
								<div class='form-group col-md-3 col-sm-4'>
									<?= $this->Form->select('Sintegra', ['NÃO' => 0, 'SIM' => 1], [
											'name' => 'sintegra'
										]) 
									?>
								</div>
							</div>
						</div>
						<div class='form-group col-md-3 col-sm-4'>
							<?= $this->Form->input('N° de Terminais ADM', [
									'name' => 'num_termi_adm',
									'placeholder' => 'EX: 2',
									'type' => 'number',
									'value' => 0,
									'min' => 0
								]) 
							?>
						</div>
						<div class='form-group col-md-3 col-sm-4'>
							<?= $this->Form->input('PDV', [
									'placeholder' => 'EX: 5',
									'type' => 'number',
									'name' => 'pdv',
									'value' => 0,
									'min' => 0
								]) 
							?>
						</div>
					</fieldset>
				</fieldset>	
				<fieldset class='col-sm-12'>
						<legend>
							<i class='fas fa-angle-right text-primary'></i> Lista de Equipamentos
						</legend>
						<div class='form-group col-sm-12'>
							<button type='button' class='btn btn-success btn-sm'>
								Adicionar Equipamento <i class='fas fa-plus'></i>
							</button>
						</div>
						<div class='col-sm-12'>
							<div class='form-group table-responsive'>
								<table class='table table-bordered'>
								    <thead>
								      	<tr>
								      		<th>#</th>
								        	<th>Número de Ordem</th>
								        	<th>Número de Série</th>
								        	<th>Modelo</th>
								        	<th>Ações</th>
								      	</tr>
								    </thead>
								    <tbody class='text-capitalize'>
								    	<?php if (isset($cadastro->cod_cadastro)): ?>
								    		<tr>
								    			<th>1</th>
								    			<td>
								    				<?= $this->Form->input('', [
															'class' => 'form-control input-sm disabled',
															'name' => 'equip_ordem[]',
															'type' => 'number',
															'value' => 0
														]) 
													?>
								    			</td>
								    			<td>
								    				<?= $this->Form->input('', [
															'value' => 'SRI' . $cadastro->cnpj . $cadastro->cep,
															'class' => 'form-control input-sm disabled',
															'name' => 'equip_serie[]'
														]) 
													?>
								    			</td>
								    			<td>
								    				<?= $this->Form->input('', [
															'class' => 'form-control input-sm disabled',
															'name' => 'equip_modelo[]',
															'value' => 'SRICASH'
														]) 
													?>
								    			</td>
								    			<td style='background-color: #eee'></td>
								    		</tr>
								    	<?php endif ?>
								    </tbody>
								</table>
							</div>
						</div>
				</fieldset>
			</div>
			<div class='financeiro row hidden'>
				<fieldset class='col-sm-12'>
					<legend>
						<i class='fas fa-angle-double-right text-primary'></i> Dados Financeiros
					</legend>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='form-group col-md-4 col-sm-6'>
								<?= $this->Form->input('Código do Responsável Financeiro', [
										'value' => (isset($cadastro->cod_cadastro)) ? $cadastro->cod_cadastro : '',
										'class' => 'form-control input-sm disabled',
										'name' => 'cod_resp_financeiro'
									]) 
								?>
							</div>
						</div>
					</div>
					<div class='form-group col-md-3 col-sm-4'>
						<label>Código do Vendedor</label>
						<div class='input-group'>
					      	<?= $this->Form->input('', [
									'class' => 'form-control input-sm disabled',
									'placeholder' => 'EX: 1',
									'name' => 'cod_vendedor',
									'min' => 0
								]) 
							?>
					      	<span class='input-group-btn'>
					        	<button class='btn btn-primary btn-sm' type='button' id='busca-vendedor'>
					        		Alterar <i class='fas fa-search'></i>
					        	</button>
					      	</span>
		    			</div>	
					</div>
					<div class='form-group col-md-6 col-sm-8'>
						<?= $this->Form->input('Nome do Vendedor', [
								'class' => 'form-control input-sm disabled',
								'placeholder' => 'EX: MATHEUS',
								'name' => 'comissionado_nome'
							]) 
						?>
					</div>
					<div class='form-group col-md-3 col-sm-5'>
						<?= $this->Form->input('Valor da Comissão (R$)', [
								'class' => 'form-control input-sm money',
								'placeholder' => 'EX: 10,55',
								'name' => 'valor_comissao',
								'value' => '0,00'
							]) 
						?>
					</div>
					<div class='form-group col-md-3 col-sm-5'>
						<?= $this->Form->input('Valor do Contrato (R$)', [
								'class' => 'form-control input-sm money',
								'placeholder' => 'EX: 150,00',
								'name' => 'valor_contrato',
								'value' => '0,00'
							]) 
						?>
					</div>
					<div class='form-group col-md-4 col-sm-5'>
						<?= $this->Form->input('Data da Última Cobrança', [
								'class' => 'form-control input-sm date',
								'placeholder' => 'EX: ' . date('d/m/Y'),
								'name' => 'data_ultima_cobranca'
							]) 
						?>
					</div>
					<div class='form-group col-md-3 col-sm-5'>
						<?= $this->Form->input('Dia de Vencimento', [
								'name' => 'dia_vencimento',
								'placeholder' => 'EX: 25',
								'type' => 'number',
								'max' => 31,
								'min' => 1
							]) 
						?>
					</div>
					<fieldset class='col-sm-12'>
						<legend>
							<i class='fas fa-angle-right text-primary'></i> Plano de Contas
						</legend>
						<div class='form-group col-sm-4'>
							<?= $this->Form->select('Sintética', array_column(
									$sinteticos, 'sintetico', 'descricao'
								), [
									'name' => 'sintetico'
								]) 
							?>
						</div>
						<div class='form-group col-sm-4'>
							<?= $this->Form->select('Analítica', array_column(
									$analiticos, 'analitico', 'descricao'
								), [
									'disabled' => (!empty($analiticos)) ? false : true,
									'name' => 'analitico'
								]) 
							?>
						</div>
						<div class='form-group col-sm-4'>
							<?= $this->Form->select('Banco', array_column(
									$bancos, 'seq_banco', 'descricao'
								), [
									'name' => 'seq_banco'
								]) 
							?>
						</div>
					</fieldset>
				</fieldset>
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