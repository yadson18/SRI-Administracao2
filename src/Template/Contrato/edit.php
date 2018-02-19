<div id='contrato-edit' class='col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1'>
	<?php if(!empty($contrato)): ?>
		<?= $this->Form->start('', ['class' => 'form-content col-sm-12']) ?>
			<div class='form-header text-center'>
				<h4>Modificar Contrato</h4>
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
										'class' => 'form-control input-sm disabled',
										'value' => $contrato->contratante,
										'placeholder' => 'EX: 1',
										'name' => 'contratante',
										'min' => 0
									]) 
								?>
						      	<span class='input-group-btn'>
						        	<button class='btn btn-primary btn-sm' type='button' data-toggle='modal' data-target='#finder'>
						        		Alterar <i class='fas fa-search'></i>
						        	</button>
						      	</span>
			    			</div>	
						</div>
						<div class='form-group col-md-6 col-sm-8'>
							<?= $this->Form->input('Razão Social', [
									'placeholder' => 'EX: FRUTAS E VERDURAS LTDA',
									'class' => 'form-control input-sm disabled',
									'value' => $contrato->razao_social,
									'maxlength' => 60
								]) 
							?>
						</div>
						<div class='form-group col-md-3 col-sm-4'>
							<?= $this->Form->select('Status', array_column(
									$status, 'seq', 'descricao'
								), [
									'selected' => $contrato->status
								]) 
							?>
						</div>
						<div class='form-group col-md-3 col-sm-4'>
							<?= $this->Form->select('Modalidade', array_column(
									$modalidades, 'seq', 'descricao'
								), [
									'selected' => $contrato->modalidade
								]) 
							?>
						</div>
						<div class='form-group col-md-3 col-sm-4'>
							<?= $this->Form->input('Data de Inclusão', [
									'value' => date('d/m/Y', strtotime($contrato->data_inclusao)),
									'class' => 'form-control input-sm date',
									'placeholder' => 'EX: ' . date('d/m/Y'),
									'name' => 'data_inclusao'
								]) 
							?>
						</div>
						<div class='form-group col-md-3 col-sm-4'>
							<?= $this->Form->input('Data de Ativação', [
									'value' => date('d/m/Y', strtotime($contrato->data_ativacao)),
									'class' => 'form-control input-sm date',
									'placeholder' => 'EX: ' . date('d/m/Y'),
									'name' => 'data_ativacao'
								]) 
							?>
						</div>
						<div class='form-group col-md-3 col-sm-4'>
							<?= $this->Form->input('Data de Vencimento', [
									'value' => date('d/m/Y', strtotime($contrato->data_vencimento)),
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
												'selected' => $contrato->nota_fiscal_eletronica,
												'name' => 'nota_fiscal_eletronica'
											]) 
										?>
									</div>
									<div class='form-group col-md-3 col-sm-4'>
										<?= $this->Form->select('EFD', ['NÃO' => 0, 'SIM' => 1], [
												'selected' => $contrato->efd,
												'name' => 'efd'
											]) 
										?>
									</div>
									<div class='form-group col-md-3 col-sm-4'>
										<?= $this->Form->select('Sintegra', ['NÃO' => 0, 'SIM' => 1], [
												'selected' => $contrato->sintegra,
												'name' => 'sintegra'
											]) 
										?>
									</div>
								</div>
							</div>
							<div class='form-group col-md-3 col-sm-4'>
								<?= $this->Form->input('PDV', [
										'value' => $contrato->hardware,
										'placeholder' => 'EX: 5',
										'name' => 'hardware',
										'type' => 'number',
										'max' => 9,
										'min' => 0
									]) 
								?>
							</div>
							<div class='form-group col-md-3 col-sm-4'>
								<?= $this->Form->input('N° de Terminais ADM', [
										'value' => $contrato->num_termi_adm,
										'name' => 'num_termi_adm',
										'placeholder' => 'EX: 2',
										'type' => 'number',
										'max' => 9999,
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
								<button type='button' class='btn btn-success btn-sm add-equip'>
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
									    <tbody class='text-capitalize equipamentos'>
									    	<?php if (!empty($equipamentos)): ?>
									    		<?php foreach ($equipamentos as $indice => $equipamento): ?>
										    		<tr <?= ($indice !== 0) ? 'id=' . $indice : '' ?>>
										    			<th><?= ($indice + 1) ?></th>
										    			<td>
										    				<?= $this->Form->input('', [
																	'class' => ($indice === 0) 
																		? 'form-control input-sm disabled' 
																		: 'form-control input-sm text-uppercase',
																	'name' => 'equipamento['. $indice .'][numero_ecf]',
																	'value' => $equipamento['numero_ecf'],
																	'type' => 'number',
																	'maxlength' => 4,
																]) 
															?>
										    			</td>
										    			<td>
										    				<?= $this->Form->input('', [
																	'class' => ($indice === 0) 
																		? 'form-control input-sm disabled' 
																		: 'form-control input-sm text-uppercase',
																	'name' => 'equipamento['. $indice .'][serie_impressora]',
																	'value' => $equipamento['serie_impressora'],
																	'maxlength' => 30
																]) 
															?>
										    			</td>
										    			<td>
										    				<?= $this->Form->input('', [
																	'class' => ($indice === 0) 
																		? 'form-control input-sm disabled' 
																		: 'form-control input-sm text-uppercase',
																	'name' => 'equipamento['. $indice .'][modelo_impressora]',
																	'value' => $equipamento['modelo_impressora'],
																	'maxlength' => 12
																]) 
															?>
										    			</td>
										    			<?php if ($indice === 0): ?>
										    				<td style='background-color: #eee'></td>
										    			<?php else: ?>
										    				<td>
										    					<button class='btn btn-danger btn-xs' data-target='#delete' data-toggle='modal' value=<?= $indice ?> type='button'>
										    						<i class='fas fa-trash-alt'></i>
										    					</button>
										    				</td>
									    				<?php endif ?>
										    		</tr>
									    		<?php endforeach ?>
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
											'class' => 'form-control input-sm disabled',
											'value' => $contrato->contratante,
											'name' => 'cod_resp_financeiro',
											'placeholder' => 'EX: 15',
											'maxlength' => 5
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
										'value' => $contrato->cod_vendedor,
										'placeholder' => 'EX: 1',
										'name' => 'cod_vendedor',
										'maxlength' => 5,
										'min' => 0
									]) 
								?>
						      	<span class='input-group-btn'>
						        	<button class='btn btn-primary btn-sm' type='button' data-toggle='modal' data-target='#vendedores'>
						        		Alterar <i class='fas fa-search'></i>
						        	</button>
						      	</span>
			    			</div>	
						</div>
						<div class='form-group col-md-6 col-sm-8'>
							<?= $this->Form->input('Nome do Vendedor', [
									'class' => 'form-control input-sm disabled',
									'value' => $contrato->vendedor,
									'placeholder' => 'EX: MATHEUS',
									'id' => 'vendedor',
									'name' => false
								]) 
							?>
						</div>
						<div class='form-group col-md-3 col-sm-5'>
							<?= $this->Form->input('Valor da Comissão (R$)', [
									'value' => floatParaDinheiro($contrato->valor_comissao),
									'class' => 'form-control input-sm money',
									'placeholder' => 'EX: 10,55',
									'name' => 'valor_comissao'
								]) 
							?>
						</div>
						<div class='form-group col-md-3 col-sm-5'>
							<?= $this->Form->input('Valor do Contrato (R$)', [
								'value' => floatParaDinheiro($contrato->valor_contrato),
									'class' => 'form-control input-sm money',
									'placeholder' => 'EX: 150,00',
									'name' => 'valor_contrato'
								]) 
							?>
						</div>
						<div class='form-group col-md-4 col-sm-5'>
							<?= $this->Form->input('Data da Última Cobrança', [
									'value' => date('d/m/Y', strtotime($contrato->data_ultima_cobranca)),
									'class' => 'form-control input-sm date',
									'placeholder' => 'EX: ' . date('d/m/Y'),
									'name' => 'data_ultima_cobranca'
								]) 
							?>
						</div>
						<div class='form-group col-md-3 col-sm-5'>
							<?= $this->Form->input('Dia de Vencimento', [
									'value' => $contrato->dia_vencimento,
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
										'selected' => $contrato->sintetico,
										'name' => 'sintetico'
									]) 
								?>
							</div>
							<div class='form-group col-sm-4'>
								<?= $this->Form->select('Analítica', array_column(
										$analiticos, 'analitico', 'descricao'
									), [
										'disabled' => (!empty($analiticos)) ? false : true,
										'selected' => $contrato->analitico,
										'name' => 'analitico'
									]) 
								?>
							</div>
							<div class='form-group col-sm-4'>
								<?= $this->Form->select('Banco', array_column(
										$bancos, 'seq_banco', 'descricao'
									), [
										'selected' => $contrato->seq_banco,
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
	<?php else: ?>
		<div class='text-center data-not-found'>
			<h4>Desculpe, contrato inexistente, deseja retornar?.</h4>
			<div class='col-sm-4 col-sm-offset-4'>
				<a href='/Cadastro/index' class='btn btn-primary btn-block'>
					<i class='fas fa-angle-double-left'></i> Retornar 
				</a>
			</div>
		</div>
	<?php endif; ?>
	<!-- Modal Listar Clientes -->
        <div class='modal fade' id='finder' tabindex='-1' role='dialog'>
			<div class='modal-dialog modal-lg' role='document'>
				<div class='modal-content'>
					<div class='modal-header'>
						<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
							<span aria-hidden='true'>&times;</span>
						</button>
						<h4 class='modal-title text-center'>Consultar Cadastros</h4>
					</div>
					<div class='modal-body'>
						<div class='message-box'></div>
						<div class='row'>
							<div class='col-sm-6 form-group'>
		  						<div class='input-group icon-right'>
		  							<span class='input-group-btn'>
		      							<select class='btn btn-default btn-sm filter'>
				      						<option value='1'>CÓDIGO</option>
				      						<option value='2'>CNPJ/CPF</option>
				      						<option value='3'>RAZÃO SOCIAL</option>
				      						<option value='4'>CEP</option>
		      							</select>
		  							</span>
				      				<?= $this->Form->input('', [
				                           	'class' => 'form-control input-sm search-content text-uppercase',
				                           	'placeholder' => 'Digite sua busca aqui',
				                           	'required' => false,
				                           	'name' => false,
				                           	'id' => false
				                       	]) 
				                    ?>
		                			<i class='fas fa-search icon icon-sm button find'></i>
		  						</div>
							</div>
							<div class='col-sm-12'>
								<div class='table-responsive fixed-height'>
									<table class='table table-bordered'>
										<thead>
											<tr>
									      		<th>#</th>
									        	<th>Código</th>
									        	<th>CNPJ/CPF</th>
									        	<th>Razão Social</th>
									        	<th>CEP</th>
									        	<th>Selecionado</th>
									      	</tr>
										</thead>
										<tbody class='text-capitalize'></tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class='modal-footer'>
						<button type='button' class='btn btn-danger' data-dismiss='modal'>
							Fechar <i class='fas fa-times'></i>
						</button>
			 			<button type='button' class='btn btn-success inserir'>
			 				Concluir <i class='fas fa-check'></i>
			 			</button>
					</div>
					<div class='text-center loading hidden'> 
						<div class='loading-content change-loading-height'>
							<i class='fas fa-circle-notch fa-spin fa-3x'></i>
			                <h5>Carregando os dados...</h5>
						</div>
		            </div>
				</div>
			</div>
		</div>
    <!-- Modal End -->
    <!-- Modal Confirmar Exclusão -->
        <div class='modal fade' id='delete' role='dialog'>
            <div class='modal-dialog' role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal'>
                            <i class='fas fa-times'></i>
                        </button>
                        <h4 class='modal-title text-center'>Excluir Equipamento</h4>
                    </div>
                    <div class='modal-body text-center'>
                        <h4>Deseja realmente excluir este equipamento?</h4>
                    </div>
                    <div class='modal-footer'>
                    	<button data-dismiss='modal' class='btn btn-danger exit'>
                    		Não <i class='fas fa-times'></i>
                    	</button>
                    	<button class='btn btn-success confirm' data-dismiss='modal'>
                    		Sim <i class='fas fa-check'></i>
                    	</button>
                    </div>
                </div>
            </div>
        </div>
    <!-- Modal End -->
    <!-- Modal Listar Vendedores -->
        <div class='modal fade' id='vendedores' tabindex='-1' role='dialog'>
			<div class='modal-dialog modal-lg' role='document'>
				<div class='modal-content'>
					<div class='modal-header'>
						<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
							<span aria-hidden='true'>&times;</span>
						</button>
						<h4 class='modal-title text-center'>Vendedores</h4>
					</div>
					<div class='modal-body'>
						<div class='message-box'></div>
						<div class='table-responsive fixed-height'>
							<table class='table table-bordered'>
								<thead>
									<tr>
									    <th>#</th>
									    <th>Código</th>
									    <th>CPF</th>
									    <th>Nome</th>
									    <th>Selecionado</th>
									</tr>
								</thead>
								<?php if (!empty($vendedores)): ?>
									<tbody class='text-capitalize'>
										<?php foreach ($vendedores as $indice => $vendedor): ?>
											<tr>
								    			<th><?= ++$indice ?></th>
									        	<td class='id'><?= $vendedor['id'] ?></td>
									        	<td class='cpfMask'><?= unmask($vendedor['cpf']) ?></td>
									        	<td class='nome'><?= $vendedor['nome'] ?></td>
									        	<td><input class='check-unic' type='checkbox'></td>
									        </tr>
										<?php endforeach ?>
									</tbody>
								<?php endif ?>
							</table>
							<?php if(empty($vendedores)): ?>
								<div class='text-center data-not-found'>
									<h4>Nada a ser exibido. <i class='far fa-frown'></i></h4>
								</div>		    	
							<?php endif; ?>
						</div>
					</div>
					<div class='modal-footer'>
						<button type='button' class='btn btn-danger' data-dismiss='modal'>
							Fechar <i class='fas fa-times'></i>
						</button>
			 			<button type='button' class='btn btn-success inserir'>
			 				Concluir <i class='fas fa-check'></i>
			 			</button>
					</div>
				</div>
			</div>
		</div>
    <!-- Modal End -->
</div>