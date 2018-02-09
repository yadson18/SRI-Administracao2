<div id='cadastro-index'>
	<h2 class='page-header'>
		Clientes 
		<a href='/Cadastro/add' class='btn btn-success'>
			Adicionar Novo <i class="fas fa-plus-circle"></i>
		</a>
	</h2>
	<div class='container-fluid cadastro-lista'>
		<div class='message-box'></div>
		<div class='table-responsive fixed-height'>
			<table class='table table-bordered'>
			    <thead>
			      	<tr>
			      		<th>#</th>
			        	<th>Código</th>
			        	<th>CNPJ/CPF</th>
			        	<th>Razão</th>
			        	<th>Fantasia</th>
			        	<th>Estado</th>
			        	<th>CEP</th>
			        	<th>Cidade</th>
			        	<th>Endereço</th>
			        	<th>Bairro</th>
			        	<th>Contratos</th>
			        	<th>Ações</th>
			      	</tr>
			    </thead>
			    <?php if(!empty($cadastros)): ?>
				    <tbody class='text-capitalize'>
				    		<?php foreach($cadastros as $index => $cadastro): ?>
					    		<tr id=<?= $cadastro['cod_cadastro'] ?>>
					    			<th><?= ($index + 1) ?></th>
						        	<td><?= $cadastro['cod_cadastro'] ?></td>
									<td class='cnpjCpfMask'><?= unmask($cadastro['cnpj']) ?></td>
									<td><?= mb_strtolower($cadastro['razao']) ?></td>
									<td><?= mb_strtolower($cadastro['fantasia']) ?></td>
									<td><?= $cadastro['estado'] ?></td>
									<td class='cepMask'><?= unmask($cadastro['cep']) ?></td>
									<td><?= mb_strtolower($cadastro['cidade']) ?></td>
									<td><?= mb_strtolower($cadastro['endereco']) ?></td>
									<td><?= mb_strtolower($cadastro['bairro']) ?></td>
									<td>
										<span class='badge'><?= $cadastro['contratos'] ?></span>
										<?php if ($cadastro['contratos'] > 0): ?>
											<button value=<?= $cadastro['cod_cadastro'] ?> class='btn btn-info btn-xs btn-block' data-toggle='modal' data-target='#contracts'>
												Visualizar <i class='fas fa-eye'></i>
											</button>
										<?php endif ?>
									</td>
									<td class='actions'>
										<a href=/Cadastro/edit/<?= $cadastro['cod_cadastro'] ?> class='btn btn-primary btn-xs'>
											<i class='fas fa-pencil-alt'></i>
										</a>
										<button value=<?= $cadastro['cod_cadastro'] ?> class='btn btn-danger btn-xs' data-toggle='modal' data-target='#delete'>
											<i class='fas fa-trash-alt'></i>
										</button>
									</td>
					      		</tr>
					      	<?php endforeach; ?>
				    </tbody>
				<?php endif; ?>
			</table>
			<?php if(empty($cadastros)): ?>
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
	<!-- Modal Confirmar Exclusão -->
        <div class='modal fade' id='delete' role='dialog'>
            <div class='modal-dialog' role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal'>
                            <i class='fas fa-times'></i>
                        </button>
                        <h4 class='modal-title text-center'>Excluir Cliente</h4>
                    </div>
                    <div class='modal-body text-center'>
                        <h4>Deseja realmente excluir este cliente?</h4>
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
    <!-- Modal Listar Contratos -->
        <div class='modal fade' id='contracts' role='dialog'>
            <div class='modal-dialog modal-lg' role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal'>
                            <i class='fas fa-times'></i>
                        </button>
                        <h4 class='modal-title text-center'>Lista de Contratos</h4>
                    </div>
                    <div class='modal-body text-center'>
                    	<div class='message-box'></div>
                      	<div class='table-responsive fixed-height'>
							<table class='table table-bordered'>
							    <thead>
							      	<tr>
							      		<th>#</th>
							        	<th>Sequencial</th>
							        	<th>Vencimento</th>
							        	<th>Ativação</th>
							        	<th>Última Cobrança</th>
							        	<th>Valor (R$)</th>
							        	<th>Modalidade</th>
							        	<th>NF-e</th>
							        	<th>N° Terminais ADM</th>
							        	<th>Situação</th>
							      	</tr>
							    </thead>
							    <tbody class='text-capitalize'></tbody>
							</table>
						</div>
                    </div>
                    <div class='modal-footer'>
                    	<button data-dismiss='modal' class='btn btn-danger exit'>
                    		Fechar <i class='fas fa-times'></i>
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
</div>