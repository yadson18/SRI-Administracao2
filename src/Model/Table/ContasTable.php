<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class ContasTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH');

			$this->setTable('CONTAS');

			$this->setPrimaryKey('seq');

			$this->setBelongsTo('', []);
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('seq')->notEmpty()->int()->size(4);
			$validator->addRule('responsavel')->empty()->int()->size(4);
			$validator->addRule('data_emissao')->empty()->string()->size(4);
			$validator->addRule('data_venc')->empty()->string()->size(4);
			$validator->addRule('data_pagamento')->empty()->string()->size(4);
			$validator->addRule('descricao')->empty()->string()->size(600);
			$validator->addRule('valor')->empty()->int()->size(4);
			$validator->addRule('juros')->empty()->int()->size(4);
			$validator->addRule('multa')->empty()->int()->size(4);
			$validator->addRule('desconto')->empty()->int()->size(4);
			$validator->addRule('integral')->empty()->string()->size(1);
			$validator->addRule('documento')->empty()->string()->size(10);
			$validator->addRule('cfop')->empty()->string()->size(4);
			$validator->addRule('tipo_movimento')->empty()->int()->size(4);
			$validator->addRule('cancelado')->empty()->string()->size(1);
			$validator->addRule('plano_conta')->empty()->string()->size(11);
			$validator->addRule('tipo_cobranca')->empty()->int()->size(4);
			$validator->addRule('empresa')->empty()->int()->size(4);
			$validator->addRule('forma_pagamento')->empty()->int()->size(4);
			$validator->addRule('comissao')->empty()->int()->size(4);
			$validator->addRule('valor_pago')->empty()->int()->size(4);
			$validator->addRule('data_comissao')->empty()->string()->size(4);
			$validator->addRule('total_pagar')->empty()->int()->size(4);
			$validator->addRule('cadastrado_por')->empty()->int()->size(4);
			$validator->addRule('cadastrado_em')->empty()->string()->size(4);
			$validator->addRule('alterado_por')->empty()->int()->size(4);
			$validator->addRule('alterado_em')->empty()->string()->size(4);
			$validator->addRule('tipo_conta')->empty()->string()->size(1);
			$validator->addRule('cod_colaborador')->empty()->int()->size(4);
			$validator->addRule('sintetico')->empty()->int()->size(4);
			$validator->addRule('analitico')->empty()->int()->size(4);
			$validator->addRule('centro_custo')->empty()->int()->size(4);
			$validator->addRule('seq_banco')->empty()->int()->size(4);
			$validator->addRule('nr_cheque')->notEmpty()->string()->size(10);
			$validator->addRule('cod_finalizadora')->empty()->int()->size(4);
			$validator->addRule('caixa')->empty()->string()->size(4);
			$validator->addRule('nosso_numero')->empty()->string()->size(15);
			$validator->addRule('lote_remessa')->empty()->string()->size(6);

			return $validator;
		}
	}