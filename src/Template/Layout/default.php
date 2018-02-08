<!DOCTYPE html>
<html lang='pt-br'>
	<head>
		<title>
			<?= $this->fetch('appName') ?> - <?= $this->fetch('title') ?>
		</title>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		
		<?= $this->Html->encoding() ?>

		<?= $this->Html->font('Montserrat') ?>
		<?= $this->Html->css('bootstrap.min.css') ?>
		<?= $this->Html->css('fontawesome-all.min.css') ?>
		<?= $this->Html->css('jquery-datetimepicker.min.css') ?>
		
		<?= $this->Html->script('jquery.min.js') ?>
		<?= $this->Html->script('bootstrap.min.js') ?>
		<?= $this->Html->script('jquery-mask.min.js') ?>
		<?= $this->Html->script('jquery-mask-money.min.js') ?>
		<?= $this->Html->script('jquery.cpfcnpj.min.js') ?>
		<?= $this->Html->script('jquery-datetimepicker.min.js') ?>
		<?= $this->Html->script('internal-functions.js') ?>
		<script src='https://cdnjs.cloudflare.com/ajax/libs/chroma-js/1.3.6/chroma.min.js'></script>
		
		<?= $this->Html->less('mixin.less') ?>
		<?= $this->Html->less($this->fetch('controller') . '.less') ?>
		<?= $this->Html->script($this->fetch('controller') . '.js') ?>
		<?= $this->Html->script('less.min.js') ?>
	</head>
	<body>	
		<nav class='navbar navbar-inverse' id='main-nav'>
		    <div class='container-fluid'>
		        <div class='navbar-header'>
		            <button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#responsive-menu' aria-expanded='false'>
		                <span class='sr-only'>Toggle navigation</span>
		                <span class='icon-bar'></span>
		                <span class='icon-bar'></span>
		                <span class='icon-bar'></span>
		            </button>
		        </div>
		        <div class='collapse navbar-collapse' id='responsive-menu'>
		        	<?php 
		            	if ($this->fetch('controller') === 'Colaborador' &&
		            		$this->fetch('view') === 'login'
		            	): 
		            ?>
		            	<ul class='nav navbar-nav'>
		            		<li>
		            			<a href='#'>SRI</i></a>
		            		</li>
		            	</ul>
		        	<?php else: ?>
			        	<ul class='nav navbar-nav'>
			        		<li>
			        			<a href='/Page/home'><i class='fas fa-home'></i> Início</a>
			        		</li>
			        		<li>
			        			<a href='/Cadastro/index'>
			        				<i class='fas fa-users'></i> Clientes
			        			</a>
			        		</li>
			        		<li>
			        			<a href='#'><i class='fas fa-file-alt'></i> Contratos</a>
			        		</li>
			        	</ul>
			        	<ul class='nav navbar-nav navbar-right'>
		        			<li class='dropdown'>
						        <a class='dropdown-toggle' data-toggle='dropdown' href='#'>
						        	<i class='fas fa-user'></i>
		            				<?= $usuarioNome ?> <span class='caret'></span>
						        </a>
						        <ul class='dropdown-menu'>
						          	<li>
						          		<a href='/Colaborador/mudarSenha'>
						          			<i class='fas fa-key'></i> Modificar Senha
						          		</a>
						          	</li>
						          	<li>
					        			<a href='#'>
					        				<i class='fas fa-cogs'></i> Configurações
					        			</a>
					        		</li>
						          	<li>
						          		<a href='/Colaborador/logout'>
						          			<i class='fas fa-sign-out-alt'></i> Sair
						          		</a>
						          	</li>
						        </ul>
						    </li>
						</ul>
			        <?php endif; ?>
		        </div>
		    </div>
		</nav>
		<div class='content container-fluid'>
			<?= $this->fetch('content') ?>
		</div>
	</body>
</html>