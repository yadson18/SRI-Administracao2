<?php 
	namespace App\Controller;

	use Simple\ORM\TableRegistry;

	class ContratoController extends AppController
	{
		public function isAuthorized()
		{
			return $this->allow([]);
		}

		public function add($cnpj = null)
		{
			$cadastro = TableRegistry::get('Cadastro');
			$usuario = $this->Auth->getUser();
			$cadastroEncontrado = null;

			if ($this->request->is('GET')) {
				if (is_numeric($cnpj)) {
					$cadastroEncontrado = $cadastro->find(['*'])
						->where([
							'cnpj =' => unmask($cnpj)
						])
						->fetch('class');
				}
			}

			$this->setViewVars([
				'usuarioNome' => $usuario->nome,
				'cadastro' => $cadastroEncontrado
			]);
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['add']);
		}
	}