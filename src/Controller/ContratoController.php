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
			$contratoSerie = TableRegistry::get('ContratoSerie');
			$modalidade = TableRegistry::get('Modalidade');
			$planoConta = TableRegistry::get('PlanoConta');
			$cadastro = TableRegistry::get('Cadastro');
			$vendedor = TableRegistry::get('Vendedor');
			$contrato = $this->Contrato->newEntity();
			$cadastroEntity = $cadastro->newEntity();
			$status = TableRegistry::get('Status');
			$banco = TableRegistry::get('Banco');
			$usuario = $this->Auth->getUser();

			if ($this->request->is('GET')) {
				if (is_numeric($cnpj)) {
					$cadastroEntity = $cadastro->getCadastro($cnpj);
				}
			}
			else if ($this->request->is('POST')) {
				$dados = $this->request->getData();
				$equipamentos = $dados['equipamento'];
				unset($dados['equipamento']);
				$dados = $this->Contrato->normalizarDados($dados);
				$contrato = $this->Contrato->patchEntity($contrato, $dados);
				$contrato->cancelado = 'F';

				if ($this->Contrato->save($contrato)) {
					$seqContrato = $this->Contrato->getSequencia($contrato->contratante);
					$equipamentosSalvos = 0;

					if (is_numeric($seqContrato->seq)) {
						foreach ($equipamentos as $equipamento) {
							$equipamento = $contratoSerie->patchEntity($contratoSerie->newEntity(), $equipamento);
							$equipamento->seq_contrato = $seqContrato->seq;
							$equipamento->atualizar = 'T';
							$equipamento->dias = 60;

							if ($contratoSerie->save($equipamento)) {
								$equipamentosSalvos++;
							}
						}

						if (sizeof($equipamentos) === $equipamentosSalvos) {
							$this->Flash->success('O contrato do cliente (' . $contrato->razao_social . ') foi salvo com sucesso.');
						}
						else {
							$this->Flash->warning('O contrato do cliente (' . $contrato->razao_social . ') foi salvo com sucesso, mas não foi possível cadastrar todos os equipamentos.');
						}
					}
				}
				else {
					$this->Flash->error('Não foi possível cadastrar o contrato do cliente (' . $contrato->razao_social . ').');
				}
			}

			$this->setViewVars([
				'analiticos' => $planoConta->getAnaliticosPorCod(0),
				'modalidades' => $modalidade->getModalidades(),
				'sinteticos' => $planoConta->getSinteticos(),
				'vendedores' => $vendedor->listaVendedores(),
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