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
			$equipamentos = null;

			if ($this->request->is('GET')) {
				if (is_numeric($cnpj)) {
					$cadastroEntity = $cadastro->getCadastro($cnpj);
				}
			}
			else if ($this->request->is('POST')) {
				$dados = $this->Contrato->normalizarDados($this->request->getData());
				if (isset($dados['equipamento'])) {
					$equipamentos = $dados['equipamento'];
					unset($dados['equipamento']);
				}
				$contrato = $this->Contrato->patchEntity($contrato, $dados);
				$contrato->cancelado = 'F';
				
				if ($this->Contrato->save($contrato)) {
					$seqContrato = $this->Contrato->getSequencia($contrato->contratante);
					$equipamentosSalvos = 0;

					if (isset($seqContrato->seq) && is_numeric($seqContrato->seq)) {
						foreach ($equipamentos as $equipamentoDados) {
							$equipamento = $contratoSerie->patchEntity($contratoSerie->newEntity(), $equipamentoDados);
							$equipamento->seq_contrato = $seqContrato->seq;
							$equipamento->atualizar = 'T';
							$equipamento->dias = 60;

							if ($contratoSerie->save($equipamento)) {
								$equipamentosSalvos++;
							}
						}
					}

					if (sizeof($equipamentos) === $equipamentosSalvos) {
						$this->Flash->success('O contrato do cliente (' . $contrato->razao_social . ') foi salvo com sucesso.');
					}
					else {
						$this->Flash->warning('O contrato do cliente (' . $contrato->razao_social . ') foi salvo com sucesso, mas não foi possível cadastrar todos os equipamentos.');
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
				'usuarioNome' => $usuario->nome,
				'bancos' => $banco->getBancos(),
				'cadastro' => $cadastroEntity
			]);
			$this->setTitle('Adicionar Contrato');
		}

		public function edit($seq = null)
		{
			$contratoSerie = TableRegistry::get('ContratoSerie');
			$modalidade = TableRegistry::get('Modalidade');
			$planoConta = TableRegistry::get('PlanoConta');
			$vendedor = TableRegistry::get('Vendedor');
			$contrato = $this->Contrato->newEntity();
			$status = TableRegistry::get('Status');
			$banco = TableRegistry::get('Banco');
			$usuario = $this->Auth->getUser();

			if (is_numeric($seq)) {
				if ($this->request->is('GET')) {
					$contrato = $this->Contrato->getContratoPorCod($seq);
				}
				else if ($this->request->is('POST')) {
					$dados = $this->Contrato->normalizarDados($this->request->getData());
					if (isset($dados['equipamento'])) {
						$equipamentos = $dados['equipamento'];
						unset($dados['equipamento']);
					}
					$contrato = $this->Contrato->patchEntity($contrato, $dados);
					$contrato->seq = $seq;
					
					if ($this->Contrato->save($contrato)) {
						$equipamentosSalvos = 0;

						foreach ($equipamentos as $equipamentoDados) {
							$equipamento = $contratoSerie->patchEntity(
								$contratoSerie->newEntity(), $equipamentoDados
							);

							if ($contratoSerie->save($equipamento)) {
								$equipamentosSalvos++;
							}
						}

						if (sizeof($equipamentos) === $equipamentosSalvos) {
							$this->Flash->success('O contrato do cliente (' . $contrato->razao_social . ') foi modificado com sucesso.');
						}
						else {
							$this->Flash->warning('O contrato do cliente (' . $contrato->razao_social . ') foi modificado com sucesso, mas não foi possível alterar os dados de alguns equipamentos.');
						}
					}
					else {
						$this->Flash->error('Não foi possível modificar o contrato do cliente (' . $contrato->razao_social . ').');
					}

				}
			}

			if (isset($contrato->contratante)) {
				$this->setViewVars([
					'equipamentos' => $contratoSerie->getEquipamentosContrato($seq),
					'analiticos' => $planoConta->getAnaliticosPorCod($contrato->sintetico),
					'modalidades' => $modalidade->getModalidades(),
					'sinteticos' => $planoConta->getSinteticos(),
					'vendedores' => $vendedor->listaVendedores(),
					'status' => $status->getStatus(),
					'usuarioNome' => $usuario->nome,
					'bancos' => $banco->getBancos(),
					'contrato' => $contrato
				]);
			}
			else {
				$this->setViewVars([
					'usuarioNome' => $usuario->nome,
					'contrato' => null
				]);
			}
			$this->setTitle('Modificar Contrato');
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
			$this->Auth->isAuthorized(['add', 'edit', 'listaContratosPorCod']);
		}
	}