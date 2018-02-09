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

		public function listaContratosPorCod()
		{
			if ($this->request->is('POST')) {
				$dados = array_map('removeSpecialChars', $this->request->getData());

				if (isset($dados['contratante']) && is_numeric($dados['contratante'])) {
					$contratos = $this->Contrato->listaContratosPorCod($dados['contratante']);

					if ($contratos) {
						$this->Ajax->response('contratos', [
							'status' => 'success',
							'data' => $contratos
						]);
					}
					else {
						$this->Ajax->response('contratos', [
							'status' => 'error',
							'message' => 'Desculpe, nenhum contrato foi encontrado.'
						]);
					}
				}
				else {
					$this->Ajax->response('contratos', [
						'status' => 'success',
						'message' => 'Por favor, verifique se o código do contratante é válido.'
					]);
				}
			}
			else {
				return $this->redirect('default');
			}
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['add', 'listaContratosPorCod']);
		}
	}