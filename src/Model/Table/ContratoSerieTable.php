<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class ContratoSerieTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH');

			$this->setTable('CONTRATO_SERIE');

			$this->setPrimaryKey('serie_impressora');

			$this->setBelongsTo('', []);
		}

		public function getEquipamentosContrato(int $seq_contrato)
		{
			return $this->find(['numero_ecf', 'serie_impressora', 'modelo_impressora'])
				->where(['seq_contrato =' => $seq_contrato])
				->fetch('all');
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('seq_contrato')->notEmpty()->int()->size(4);
			$validator->addRule('serie_impressora')->notEmpty()->string()->size(30);
			$validator->addRule('numero_ecf')->notEmpty()->int()->size(4);
			$validator->addRule('modelo_impressora')->empty()->string()->size(12);
			$validator->addRule('dias')->empty()->int()->size(4);
			$validator->addRule('ultima_renovacao')->empty()->string()->size(4);
			$validator->addRule('atualizar')->empty()->string()->size(1);
			$validator->addRule('online')->empty()->string()->size(1);

			return $validator;
		}
	}