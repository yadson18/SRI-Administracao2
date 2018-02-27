<?php 
	namespace App\Controller;

	class ContratoSerieController extends AppController
	{
		public function isAuthorized()
		{
			return $this->allow([]);
		}

		public function index($identificador = null, $valor = 1, $busca = null)
		{
			$valor = (is_numeric($valor) && $valor > 0) ? $valor : 1;
			$usuario = $this->Auth->getUser();
			$licencas = null;
			$paginator = $this->Paginator->showPage($valor)
				->buttonsLink('/ContratoSerie/index/pagina/')
				->limit(100);
			$quantidadeListada = $paginator->getListQuantity();
			$inicioDaLista = $paginator->getStartPosition();
			$total = $this->ContratoSerie->contarLicencas()->quantidade;

			if ($identificador === 'pagina') {
				$licencas = $this->ContratoSerie->listaLicensas($quantidadeListada, $inicioDaLista);
				$paginator->itensTotalQuantity($total);
			}
			else if ($identificador === 'busca') {
				$valor = removeSpecialChars($valor);
				$busca = removeSpecialChars(urldecode(base64_decode($busca)));

				if (!empty($valor) && is_numeric($valor) && 
					$busca >= 0 || !empty($busca)
				) {
					$licencas = $this->ContratoSerie->buscaLicensas($valor, $busca);
					$paginator->itensTotalQuantity(sizeof($licencas));
				}
			}
			else {
				$licencas = $this->ContratoSerie->listaLicensas($quantidadeListada);
				$paginator->itensTotalQuantity($total);
			}

			$this->setTitle('Licenças');
			$this->setViewVars([
				'usuarioNome' => $usuario->nome,
				'licencas' => $licencas
			]);
		}

		public function edit()
		{
			$licenca = $this->ContratoSerie->newEntity();

			if ($this->request->is('POST')) {
				$dados = array_map('removeSpecialChars', $this->request->getData());

				if (isset($dados['seq_contrato']) && is_numeric($dados['seq_contrato']) &&
					isset($dados['serie_impressora'])
				) {
					if ($this->ContratoSerie->getLicenca($dados['seq_contrato'], $dados['serie_impressora'])) {
						$licenca = $this->ContratoSerie->patchEntity($licenca, $dados);

						if ($this->ContratoSerie->save($licenca)) {
							$this->Ajax->response('licencaAtualizada', [
								'status' => 'success',
								'message' => 'A licença foi atualizada com sucesso.'
							]);
						}
						else {
							$this->Ajax->response('licencaAtualizada', [
								'status' => 'error',
								'message' => 'Não foi possível atualizar a licença.'
							]);
						}
					}
					else {
						$this->Ajax->response('licencaAtualizada', [
							'status' => 'error',
							'message' => 'Não foi possível atualizar, esta licença não existe.'
						]);
					}
				}
				else {
					$this->Ajax->response('licencaAtualizada', [
						'status' => 'warning',
						'message' => 'Não foi possível atualizar, verifique se o contrato é válido.'
					]);
				}
			}
			else {
				return $this->redirect('default');
			}
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['index', 'edit']);
		}
	}