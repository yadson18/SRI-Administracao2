<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class PlanoContaTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH');

			$this->setTable('PLANO_CONTA');

			$this->setPrimaryKey('sintetico');

			$this->setBelongsTo('', []);
		}

		public function getSinteticos()
		{
			return $this->find(['sintetico', 'descricao']) 
				->where(['tipo =' => 'R', 'and', 'analitico =' => 0]) 
				->orderBy(['sintetico'])
				->fetch('all');
		}

		public function getAnaliticosPorCod(int $sintetico)
		{
			$analiticos = $this->find(['analitico', 'descricao']) 
				->where([
					'analitico <>' => 0, 'and', 
					'tipo =' => 'R', 'and', 
					'sintetico =' => $sintetico
				])
				->orderBy(['analitico'])
				->fetch('all');

			return array_merge([[
				'analitico' => 0, 'descricao' => '-- SELECIONE --'
			]], $analiticos);
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('sintetico')->notEmpty()->int()->size(4);
			$validator->addRule('analitico')->notEmpty()->int()->size(4);
			$validator->addRule('descricao')->empty()->string()->size(30);
			$validator->addRule('tipo')->empty()->string()->size(1);
			$validator->addRule('cod_pcmaster')->empty()->int()->size(4);

			return $validator;
		}
	}