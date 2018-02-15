<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class VendedorTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH');

			$this->setTable('VENDEDOR');

			$this->setPrimaryKey('cpf');

			$this->setBelongsTo('', []);
		}

		public function listaVendedores()
		{
			return $this->find(['id', 'cpf', 'nome'])
				->orderBy(['nome'])
				->fetch('all');
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('nome')->notEmpty()->string()->size(50);
			$validator->addRule('email')->empty()->string()->size(50);
			$validator->addRule('senha')->notEmpty()->string()->size(6);
			$validator->addRule('fornecedor')->empty()->string()->size(14);
			$validator->addRule('cpf')->notEmpty()->string()->size(11);
			$validator->addRule('obs')->empty()->string()->size(250);
			$validator->addRule('fone1')->notEmpty()->int()->size(4);
			$validator->addRule('fone2')->empty()->int()->size(4);
			$validator->addRule('fone3')->empty()->int()->size(4);
			$validator->addRule('id')->notEmpty()->int()->size(4);

			return $validator;
		}
	}