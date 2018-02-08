<div id='colaborador-mudar-senha' class='col-sm-6 col-sm-offset-3'>
	<?= $this->Form->start('', ['class' => 'form-content col-sm-8 col-sm-offset-2']) ?>
			<div class='form-header text-center'>
				<h4>Modificar Senha</h4>
			</div>
			<div class='form-body'>
				<div class='message-box'>
					<?= $this->Flash->showMessage() ?>
				</div>
				<div class='user-icon text-center'>
					<i class='fas fa-user-circle fa-6x'></i>
					<h4><?= $usuarioNome ?></h4>
				</div>
				<div class='form-group icon-right'>
                    <?= $this->Form->input('Nova Senha', [
							'placeholder' => 'Digite uma nova senha',
							'class' => 'form-control input-sm senha inicial',
							'type' => 'password',
							'maxlength' => 12,
							'name' => 'senha'
                        ]) 
                    ?>
                    <i class='fas fa-lock-open icon icon-sm'></i>
                </div>
                <div class='form-group icon-right'>
                    <?= $this->Form->input('Confirmar Senha', [
							'placeholder' => 'Confirme sua nova senha',
							'class' => 'form-control input-sm senha confirmar',
							'type' => 'password',
							'maxlength' => 12,
							'name' => false
                        ]) 
                    ?>
                    <i class='fas fa-lock icon icon-sm'></i>
                </div>
			</div>
			<div class='form-footer'>
				<div class='form-group'>
					<button class='btn btn-success btn-block' type='submit'>
						Salvar <i class="fas fa-save"></i>
					</button>
				</div>
			</div>
	<?= $this->Form->end() ?>
</div>