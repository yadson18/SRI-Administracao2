<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class ConfigCaixaTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH');

			$this->setTable('CONFIG_CAIXA');

			$this->setPrimaryKey('caixa');

			$this->setBelongsTo('', []);
		}

		public function getCaixas()
		{
			return $this->find(['caixa', 'online', 'modeloimpressora'])
				->orderBy(['caixa'])
				->fetch('all');
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('empresa')->notEmpty()->int()->size(4);
			$validator->addRule('caixa')->notEmpty()->string()->size(4);
			$validator->addRule('data')->notEmpty()->string()->size(4);
			$validator->addRule('ecf')->empty()->string()->size(100);
			$validator->addRule('portaecf')->empty()->string()->size(1);
			$validator->addRule('cfgportaecf')->empty()->string()->size(10);
			$validator->addRule('iplocal')->empty()->string()->size(50);
			$validator->addRule('pathcx')->empty()->string()->size(50);
			$validator->addRule('ipservidor')->empty()->string()->size(50);
			$validator->addRule('pathsvr')->empty()->string()->size(50);
			$validator->addRule('usuario')->empty()->int()->size(4);
			$validator->addRule('cupom')->empty()->string()->size(10);
			$validator->addRule('status')->empty()->int()->size(4);
			$validator->addRule('atualizacao')->empty()->string()->size(1);
			$validator->addRule('tipoimpressora')->empty()->string()->size(1);
			$validator->addRule('modeloimpressora')->empty()->string()->size(20);
			$validator->addRule('tipo_balanca')->empty()->string()->size(1);
			$validator->addRule('porta_balanca')->empty()->string()->size(1);
			$validator->addRule('cfgportbal')->empty()->string()->size(20);
			$validator->addRule('tef')->empty()->string()->size(1);
			$validator->addRule('menutef')->empty()->string()->size(4);
			$validator->addRule('lerarquivo')->empty()->string()->size(1);
			$validator->addRule('logotipo')->empty()->string()->size(50);
			$validator->addRule('gera_mapaecf')->empty()->string()->size(1);
			$validator->addRule('comissao_vendedor')->empty()->string()->size(1);
			$validator->addRule('tipo_desconto')->empty()->string()->size(1);
			$validator->addRule('vias_tef')->empty()->string()->size(1);
			$validator->addRule('controle_estoque')->empty()->string()->size(1);
			$validator->addRule('padraoconsulta')->notEmpty()->string()->size(1);
			$validator->addRule('online')->empty()->string()->size(1);
			$validator->addRule('gtecf')->empty()->int()->size(8);
			$validator->addRule('atvmonitor')->empty()->string()->size(1);
			$validator->addRule('exbmonitor')->empty()->string()->size(1);
			$validator->addRule('timermonitor')->empty()->int()->size(4);
			$validator->addRule('tecautom')->notEmpty()->string()->size(1);
			$validator->addRule('cpfcnpj')->empty()->string()->size(1);
			$validator->addRule('nrvias_rg_sangria')->notEmpty()->int()->size(4);
			$validator->addRule('nrvias_rg_suprim')->notEmpty()->int()->size(4);
			$validator->addRule('atv_imposto')->notEmpty()->int()->size(4);
			$validator->addRule('hab_retorno_ext')->notEmpty()->int()->size(4);
			$validator->addRule('busca_nritem_ecf')->notEmpty()->int()->size(4);
			$validator->addRule('mod_impr')->notEmpty()->int()->size(4);
			$validator->addRule('nrdiasaviso')->notEmpty()->int()->size(4);
			$validator->addRule('nrmaxtrtef')->notEmpty()->int()->size(4);
			$validator->addRule('checkgt')->notEmpty()->int()->size(4);
			$validator->addRule('usa_descpda')->notEmpty()->int()->size(4);
			$validator->addRule('vlr_descpda')->notEmpty()->int()->size(8);
			$validator->addRule('atv_menufuncoes')->notEmpty()->string()->size(50);
			$validator->addRule('pedsnha')->notEmpty()->int()->size(4);
			$validator->addRule('nrdigbal')->notEmpty()->string()->size(2);
			$validator->addRule('usanfecx')->notEmpty()->string()->size(1);
			$validator->addRule('timedel')->notEmpty()->int()->size(4);
			$validator->addRule('preco_dinamico')->notEmpty()->string()->size(1);
			$validator->addRule('indfuncoescx')->notEmpty()->string()->size(40);

			return $validator;
		}
	}