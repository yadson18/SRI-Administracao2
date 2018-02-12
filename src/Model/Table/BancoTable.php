<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class BancoTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH');

			$this->setTable('BANCO');

			$this->setPrimaryKey('seq_banco');

			$this->setBelongsTo('', []);
		}

		public function getBancos()
		{
			return $this->find(['seq_banco', 'descricao'])
				->orderBy(['descricao'])
				->fetch('all');
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('seq_banco')->notEmpty()->int()->size(4);
			$validator->addRule('banco')->empty()->int()->size(4);
			$validator->addRule('descricao')->empty()->string()->size(30);
			$validator->addRule('cedente_caixaecon')->empty()->string()->size(10);
			$validator->addRule('conta_corrente')->empty()->string()->size(10);
			$validator->addRule('data_ultimo')->empty()->string()->size(4);
			$validator->addRule('cadastrado_por')->empty()->int()->size(4);
			$validator->addRule('cadastrado_em')->empty()->string()->size(4);
			$validator->addRule('alterado_por')->empty()->int()->size(4);
			$validator->addRule('alterado_em')->empty()->string()->size(4);
			$validator->addRule('conc')->empty()->string()->size(1);
			$validator->addRule('num_carteira')->empty()->string()->size(6);
			$validator->addRule('desc_carteira')->empty()->string()->size(28);
			$validator->addRule('num_conta')->empty()->string()->size(11);
			$validator->addRule('digito_conta')->empty()->int()->size(4);
			$validator->addRule('num_agencia')->empty()->string()->size(4);
			$validator->addRule('digito_agencia')->empty()->int()->size(4);
			$validator->addRule('tpjuros')->empty()->string()->size(1);
			$validator->addRule('tpmulta')->empty()->string()->size(1);
			$validator->addRule('inscob01')->empty()->string()->size(150);
			$validator->addRule('inscob02')->empty()->string()->size(150);
			$validator->addRule('multacob')->empty()->float()->size(8);
			$validator->addRule('juroscob')->empty()->float()->size(8);
			$validator->addRule('localpagamento')->empty()->string()->size(200);
			$validator->addRule('instrucao_cobranca')->empty()->string()->size(60);
			$validator->addRule('cedente_dv')->empty()->int()->size(4);

			return $validator;
		}
	}