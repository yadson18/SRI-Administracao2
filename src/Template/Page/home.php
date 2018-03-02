<div id='page-home'>
	<h2 class='page-header text-center'>Informações Gerais</h2>
    <div class='cards-informacoes col-sm-8 col-sm-offset-2'>
    	<div class='card col-sm-6'>
	    	<div class='card-content'>
	    		<div class='card-header text-center'>
	    			<h4>Clintes</h4>
	    		</div>
	    		<div class='card-body'>
	    			<ul class='list-group'>
	    				<li class='list-group-item text-center'>
	    					<strong>Cadastrados</strong>
	    				</li>
	    				<li class='list-group-item'>
	    					Hoje 
	    					<span class='badge'><?= numeroFormatoBR($cadastros->hoje) ?></span>
	    				</li>
	    				<li class='list-group-item'>
	    					Total 
	    					<span class='badge'><?= numeroFormatoBR($cadastros->total) ?></span>
	    				</li>
	    			</ul>
	    			<div class='text-center'>
	    				<a href='/Cadastro/index' class='btn btn-warning form-control'>
	    					Detalhado <i class='fas fa-angle-double-right'></i>
	    				</a>
	    			</div>
	    		</div>
	    	</div>
	    </div>
	    <div class='card col-sm-6'>
	    	<div class='card-content'>
	    		<div class='card-header text-center'>
	    			<h4>Contratos</h4>
	    		</div>
	    		<div class='card-body'>
	    			<ul class='list-group'>
	    				<li class='list-group-item text-center'>
	    					<strong>Cadastrados</strong>
	    				</li>
	    				<li class='list-group-item'>
	    					Hoje 
	    					<span class='badge'>
	    						<?= numeroFormatoBR($contratos->hoje) ?>
	    					</span>
	    				</li>
	    				<li class='list-group-item'>
	    					Total 
	    					<span class='badge'>
	    						<?= numeroFormatoBR($contratos->total) ?>
	    					</span>
	    				</li>
	    			</ul>
	    			<div class='text-center'>
	    				<a href='#' class='btn btn-success form-control'>
	    					Detalhado <i class='fas fa-angle-double-right'></i>
	    				</a>
	    			</div>
	    		</div>
	    	</div>
	    </div>
    </div>
</div>