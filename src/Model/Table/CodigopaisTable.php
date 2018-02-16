<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class CodigopaisTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH');

			$this->setTable('CODIGOPAIS');

			$this->setPrimaryKey('cpais');

			$this->setBelongsTo('', []);
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('cpais')->notEmpty()->string()->size(4);
			$validator->addRule('xpais')->empty()->string()->size(60);

			return $validator;
		}
	}