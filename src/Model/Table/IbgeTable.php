<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class IbgeTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH');

			$this->setTable('IBGE');

			$this->setPrimaryKey('cod_mun');

			$this->setBelongsTo('', []);
		}

		public function siglaEstados()
		{
			return $this->find([])
				->distinct('sigla')
				->fetch('all');
		}

		public function municipiosUF(string $sigla)
		{
			return $this->find(['nome_municipio'])
				->where(['sigla =' => $sigla])
				->fetch('all');
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('cod_mun')->notEmpty()->int()->size(4);
			$validator->addRule('nome_municipio')->empty()->string()->size(35);
			$validator->addRule('estado')->empty()->string()->size(25);
			$validator->addRule('sigla')->empty()->string()->size(2);
			$validator->addRule('cod_uf')->empty()->int()->size(4);

			return $validator;
		}
	}