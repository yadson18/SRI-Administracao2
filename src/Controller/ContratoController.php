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
			$modalidade = TableRegistry::get('Modalidade');
			$planoConta = TableRegistry::get('PlanoConta');
			$cadastro = TableRegistry::get('Cadastro');
			$cadastroEntity = $cadastro->newEntity();
			$status = TableRegistry::get('Status');
			$banco = TableRegistry::get('Banco');
			$usuario = $this->Auth->getUser();

			if ($this->request->is('GET')) {
				if (is_numeric($cnpj)) {
					$cadastroEntity = $cadastro->getCadastro($cnpj);
				}
			}

			$this->setViewVars([
				'analiticos' => $planoConta->getAnaliticosPorCod(0),
				'modalidades' => $modalidade->getModalidades(),
				'sinteticos' => $planoConta->getSinteticos(),
				'status' => $status->getStatus(),
				'bancos' => $banco->getBancos(),
				'usuarioNome' => $usuario->nome,
				'cadastro' => $cadastroEntity
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