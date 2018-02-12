<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class ModalidadeTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH');

			$this->setTable('MODALIDADE');

			$this->setPrimaryKey('seq');

			$this->setBelongsTo('', []);
		}

		public function getModalidades()
		{
			return $this->find(['seq', 'descricao'])
				->orderBy(['descricao'])
				->fetch('all');
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('seq')->notEmpty()->int()->size(4);
			$validator->addRule('descricao')->empty()->string()->size(40);
			$validator->addRule('documento')->empty()->string()->size(20);
			$validator->addRule('anexo')->empty()->string()->size(20);
			$validator->addRule('tipo_modalidade')->empty()->string()->size(1);

			return $validator;
		}
	}