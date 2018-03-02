<div id='page-login' class='container'>
    <div class='col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3'>
        <?= $this->Form->start('', ['class' => 'form-content']) ?>
            <div class='form-header'>
                <h4 class='text-center'>Entrar</h4>
            </div>
            <div class='form-body'>
                <div class='message-box'>
                    <?= $this->Flash->showMessage() ?>
                </div>
                <div class='form-group icon-right'>
                    <?= $this->Form->input('', [
                            'placeholder' => 'Digite seu usuário',
                            'class' => 'form-control',
                            'autofocus' => true,
                            'name' => 'login',
                            'id' => false
                        ]) 
                    ?>
                    <i class='fas fa-user icon'></i>
                </div>
                <div class='form-group icon-right'>
                    <?= $this->Form->input('', [
                            'placeholder' => 'Digite sua senha',
                            'class' => 'form-control',
                            'type' => 'password',
                            'name' => 'senha',
                            'id' => false
                        ]) 
                    ?>
                    <i class='fas fa-key icon'></i>
                </div>
            </div>
            <div class='form-footer'>
                <div class='form-group'>
                    <button class='btn btn-success btn-block'>
                        <span>Entrar</span> <i class='fas fa-sign-in-alt'></i>
                    </button>
                </div>     
            </div>    
            <div class='copy'>
                <strong><i class='far fa-copyright'></i> SRI Automação</strong>
            </div>               
        <?= $this->Form->end() ?>
    </div>
</div>