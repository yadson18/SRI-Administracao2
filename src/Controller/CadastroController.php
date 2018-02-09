<?php 
	namespace App\Controller;

	use Simple\ORM\TableRegistry;

	class CadastroController extends AppController
	{
		public function isAuthorized()
		{
			return $this->allow([]);
		}

		public function index($identificador = null, $pagina = 1)
		{	
			$pagina = (is_numeric($pagina) && $pagina > 0) ? $pagina : 1;
			$usuario = $this->Auth->getUser();
			$cadastros = null;

			$this->Paginator->showPage($pagina)
				->buttonsLink('/Cadastro/index/pagina/')
				->itensTotalQuantity(
					$this->Cadastro->contarAtivos()->quantidade
				)
				->limit(100);

			if ($identificador === 'pagina') {
				$cadastros = $this->Cadastro->listarAtivos(
					$this->Paginator->getListQuantity(), 
					$this->Paginator->getStartPosition()
				);
			}
			else {
				$cadastros = $this->Cadastro->listarAtivos(
					$this->Paginator->getListQuantity()
				);
			}
			
			$this->setTitle('Clientes Cadastrados');
			$this->setViewVars([
				'usuarioNome' => $usuario->nome,
				'cadastros' => $cadastros
			]);
		}

		public function add()
		{
			$cadastro = $this->Cadastro->newEntity();
			$ibge = TableRegistry::get('Ibge');
			$usuario = $this->Auth->getUser();

			if ($this->request->is('POST')) {
				$dados = $this->Cadastro->normalizarDados($this->request->getData());
				$cadastro = $this->Cadastro->patchEntity($cadastro, $dados);
 				$cadastro->cadastrado_por = $usuario->cod_colaborador;
 				$cadastro->cadastrado_em = date('d.m.Y');
				$cadastro->ativo = 'T';

				if ($this->Cadastro->cadastroExistente($cadastro->cnpj)) {
					$tipoCadastro = (strlen($cadastro->cnpj) === 14) ? 'CNPJ' : 'CPF';

					$this->Flash->error(
						'Desculpe, o ' . $tipoCadastro . ' (' . $cadastro->cnpj . ') já está em uso.'
					);
				}
				else if ($this->Cadastro->save($cadastro)) {
					if (strlen($cadastro->cnpj) === 14) {
						if ($this->Cadastro->criaBaseDados($cadastro->cnpj)) {
							$this->Flash->success(
								'A adição do cliente (' . $cadastro->razao . ') e a criação da base de dados, foram concluídos com sucesso.
									<a href="/Contrato/add/' . $cadastro->cnpj . '" class="text-success">
			    						<h5>
			        						<strong>
			        							Clique aqui, caso deseje cadastrar o contrato 
			        							<i class="fas fa-angle-double-right"></i>
			        						</strong>
			    						</h5>
									</a>
								'
							);
						}
						else {
							$this->Flash->warning(
								'O cliente (' . $cadastro->razao . ') foi adicionado com sucesso, mas não foi possível criar a base de dados.'
							);
						}
					}
					else {
						$this->Flash->success(
								'O cliente (' . $cadastro->razao . ') foi adicionado com sucesso.
									<a href="/Contrato/add/' . $cadastro->cnpj . '" class="text-success">
			    						<h5>
			        						<strong>
			        							Clique aqui, caso deseje cadastrar o contrato 
			        							<i class="fas fa-angle-double-right"></i>
			        						</strong>
			    						</h5>
									</a>
								'
							);
					}
				}
				else {
					$this->Flash->error(
						'Não foi possível adicionar o cliente (' . $cadastro->razao . ').'
					);
				}
			}

			$this->setTitle('Adicionar Cliente');
			$this->setViewVars([
				'municipios' => $ibge->municipiosUF('AC'),
				'estados' => $ibge->siglaEstados(),
				'usuarioNome' => $usuario->nome
			]);
		}

		public function edit($cod_cadastro = null)
		{
			$cadastro = $this->Cadastro->newEntity();
			$ibge = TableRegistry::get('Ibge');
			$usuario = $this->Auth->getUser();

			if (is_numeric($cod_cadastro)) {
				if ($this->request->is('GET')) {
					$cadastro = $this->Cadastro->get($cod_cadastro);
				}
				else if ($this->request->is('POST')) {
					$dados = $this->Cadastro->normalizarDados($this->request->getData());
					$cadastro = $this->Cadastro->patchEntity($cadastro, $dados);
					$cadastro->alterado_por = $usuario->cod_colaborador;
 					$cadastro->alterado_em = date('d.m.Y');
					$cadastro->cod_cadastro = $cod_cadastro;
					
					if ($this->Cadastro->save($cadastro)) {
						$this->Flash->success(
							'Os dados do cliente (' . $cadastro->razao . ') foram modificados com sucesso.'
						);
					}
					else {
						$this->Flash->error(
							'Não foi possível modificar os dados do cliente (' . $cadastro->razao . ').'
						);
					}
				}
			}

			if (isset($cadastro->cnpj)) {
				$this->setViewVars([
					'cadastroTipo' => (strlen($cadastro->cnpj) === 14) ? 'cnpj' : 'cpf',
					'municipios' => $ibge->municipiosUF($cadastro->estado),
					'estados' => $ibge->siglaEstados(),
					'usuarioNome' => $usuario->nome,
					'cadastro' => $cadastro
				]);
			}
			else {
				$this->setViewVars([
					'usuarioNome' => $usuario->nome,
					'cadastro' => null
				]);
			}
			$this->setTitle('Modificar Cliente');
		}

		public function delete()
		{
			$cadastro = $this->Cadastro->newEntity();

			if ($this->request->is('POST')) {
				$dados = $this->Cadastro->normalizarDados($this->request->getData());

				if (isset($dados['cod_cadastro']) && is_numeric($dados['cod_cadastro'])) {
					$cadastroRazao = $this->Cadastro->getRazao($dados['cod_cadastro']);

					if ($cadastroRazao) {
						$cadastro = $this->Cadastro->patchEntity($cadastro, $dados);
						$cadastro->ativo = 'F';

						if ($this->Cadastro->save($cadastro)) {
							$this->Ajax->response('cadastroDeletado', [
								'status' => 'success',
								'message' => 'O cliente (' . $cadastroRazao . ') foi removido com sucesso.'
							]);
						}
						else {
							$this->Ajax->response('cadastroDeletado', [
								'status' => 'error',
								'message' => 'Não foi possível remover o cliente (' . $cadastroRazao . ').'
							]);
						}
					}
					else {
						$this->Ajax->response('cadastroDeletado', [
							'status' => 'error',
							'message' => 'Não foi possível remover, o cliente não existe.'
						]);
					}
				}
				else {
					$this->Ajax->response('cadastroDeletado', [
						'status' => 'warning',
						'message' => 'Não foi possível remover, verifique se o código do cadastro é válido.'
					]);
				}
			}
			else {
				return $this->redirect('default');
			}
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['index', 'edit', 'add', 'delete']);
		}
	}