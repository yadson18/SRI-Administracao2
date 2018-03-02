<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class ColaboradorTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH2');

			$this->setTable('COLABORADOR');

			$this->setPrimaryKey('cod_colaborador');

			$this->setBelongsTo('', []);
		}

		public function validaAcesso(string $login, string $senha)
		{
			$colaborador = $this->find(['cod_colaborador', 'nome', 'funcao'])
				->where([
					'nome =' => $login, 'and',
					'senha =' => $senha
				])
				->fetch('class');

			if ($colaborador) {
				return $colaborador;
			}
			return false;
		}

		public function listaVendedores()
		{
			return $this->find(['cod_colaborador', 'nome'])
				->orderBy(['nome'])
				->fetch('all');
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('empresa')->notEmpty()->int()->size(4);
			$validator->addRule('cod_colaborador')->notEmpty()->int()->size(4);
			$validator->addRule('nome')->empty()->string()->size(30);
			$validator->addRule('funcao')->empty()->int()->size(4);
			$validator->addRule('comissao')->empty()->float()->size(8);
			$validator->addRule('telefone')->empty()->string()->size(30);
			$validator->addRule('cpf')->empty()->string()->size(13);
			$validator->addRule('rg')->empty()->string()->size(15);
			$validator->addRule('endereco')->empty()->string()->size(40);
			$validator->addRule('bairro')->empty()->string()->size(30);
			$validator->addRule('cidade')->empty()->string()->size(30);
			$validator->addRule('uf')->empty()->string()->size(2);
			$validator->addRule('acesso')->notEmpty()->string()->size(100);
			$validator->addRule('login')->empty()->string()->size(20);
			$validator->addRule('senha')->notEmpty()->string()->size(12);
			$validator->addRule('ativo')->empty()->string()->size(1);
			$validator->addRule('cod_cadastro')->notEmpty()->int()->size(4);
			$validator->addRule('conectado')->empty()->string()->size(1);
			$validator->addRule('local')->empty()->string()->size(50);
			$validator->addRule('acesso2')->empty()->string()->size(100);
			$validator->addRule('email')->empty()->string()->size(100);

			return $validator;
		}
	}