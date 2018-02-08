<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class ContratoTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH');

			$this->setTable('CONTRATO');

			$this->setPrimaryKey('seq');

			$this->setBelongsTo('', []);
		}

		public function quantidadeCadastrados()
		{
			$dataDeHoje = date("'". 'd.m.Y' ."'");
			
			return $this->find([])
				->sum('case when data_inclusao = '. $dataDeHoje .' then 1 else 0 end')->as('hoje')
				->count('contratante')->as('total')
				->where(['status !=' => 8])
				->fetch('class');
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('seq')->notEmpty()->int()->size(4);
			$validator->addRule('data_vencimento')->empty()->string()->size(4);
			$validator->addRule('contratante')->empty()->int()->size(4);
			$validator->addRule('data_inclusao')->empty()->string()->size(4);
			$validator->addRule('data_ativacao')->empty()->string()->size(4);
			$validator->addRule('valor_contrato')->empty()->int()->size(2);
			$validator->addRule('data_ultima_cobranca')->empty()->string()->size(4);
			$validator->addRule('data_ultima_renovacao')->empty()->string()->size(4);
			$validator->addRule('obs')->empty()->string()->size(100);
			$validator->addRule('modalidade')->empty()->int()->size(4);
			$validator->addRule('razao_social')->empty()->string()->size(60);
			$validator->addRule('fantasia')->empty()->string()->size(60);
			$validator->addRule('dia_vencimento')->empty()->string()->size(2);
			$validator->addRule('status')->empty()->int()->size(2);
			$validator->addRule('seq_banco')->notEmpty()->int()->size(4);
			$validator->addRule('master')->notEmpty()->int()->size(4);
			$validator->addRule('analitico')->notEmpty()->int()->size(4);
			$validator->addRule('sintetico')->notEmpty()->int()->size(4);
			$validator->addRule('cod_resp_financeiro')->notEmpty()->int()->size(4);
			$validator->addRule('valor_comissao')->empty()->int()->size(2);
			$validator->addRule('sintegra')->empty()->string()->size(1);
			$validator->addRule('efd')->empty()->string()->size(1);
			$validator->addRule('nota_fiscal_eletronica')->empty()->string()->size(1);
			$validator->addRule('num_termi_adm')->empty()->int()->size(4);
			$validator->addRule('hardware')->empty()->string()->size(1);
			$validator->addRule('cod_vendedor')->empty()->int()->size(4);
			$validator->addRule('data_cancelamento')->empty()->string()->size(4);
			$validator->addRule('cancelado')->empty()->string()->size(1);
			$validator->addRule('tipo_envio')->empty()->int()->size(2);

			return $validator;
		}
	}