<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class StatusTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH');

			$this->setTable('STATUS');

			$this->setPrimaryKey('seq');

			$this->setBelongsTo('', []);
		}

		public function getStatus() 
		{
			return $this->find(['seq', 'descricao'])
				->orderBy(['descricao'])
				->fetch('all');
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('seq')->notEmpty()->int()->size(4);
			$validator->addRule('descricao')->empty()->string()->size(30);
			$validator->addRule('aplicacao')->notEmpty()->string()->size(10);

			return $validator;
		}
	}