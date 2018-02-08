<?php 
	namespace App\Controller;

	use Simple\ORM\TableRegistry;

	class PageController extends AppController
	{
		public function isAuthorized()
		{
			return $this->allow([]);
		}

		public function home()
		{
			$cadastro = TableRegistry::get('Cadastro');
			$contrato = TableRegistry::get('Contrato');
			$usuario = $this->Auth->getUser();

			$this->setViewVars([
				'cadastros' => $cadastro->quantidadeCadastrados(),
				'contratos' => $contrato->quantidadeCadastrados(),
				'usuarioNome' => $usuario->nome
			]);	
			$this->setTitle('Home');
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['home']);
		}
	}