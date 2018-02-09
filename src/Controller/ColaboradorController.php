<?php 
	namespace App\Controller;

	use Simple\ORM\TableRegistry;

	class ColaboradorController extends AppController
	{
		public function isAuthorized()
		{
			return $this->allow(['login']);
		}
		
		public function login()
		{
			if (!empty($this->Auth->getUser('nome'))) {
				return $this->redirect(['controller' => 'Page', 'view' => 'home']);
			}
			else {
				if ($this->request->is('POST')) {
					$dados = array_map('removeSpecialChars', $this->request->getData());
					
					if (!empty($dados['login']) && !empty($dados['senha'])) {
						$colaborador = $this->Colaborador->validaAcesso($dados['login'], $dados['senha']);

						if ($colaborador) {
							$this->Auth->setUser($colaborador);
							return $this->redirect($this->Auth->loginRedirect());
						}
						else {
							$this->Flash->error('Usuário ou senha incorreto, tente novamente.');
						}
					}
					else {
						$this->Flash->error('Os campos usuário e senha são obrigatórios.');
					}
				}
				$this->setTitle('Início');
			}
		}

		public function mudarSenha()
		{
			$colaborador = $this->Colaborador->newEntity();
			$usuario = $this->Auth->getUser();

			if ($this->request->is('POST')) {
				$dados = array_map('removeSpecialChars', $this->request->getData());
				$colaborador = $this->Colaborador->patchEntity($colaborador, $dados);
				$colaborador->cod_colaborador = $usuario->cod_colaborador;

				if ($this->Colaborador->save($colaborador)) {
					$this->Flash->success(
						'A senha do colaborador (' . $usuario->nome . ') foi alterada com sucesso.'
					);
				}
				else {
					$this->Flash->error(
						'Não foi possível alterar a senha do colaborador (' . $usuario->nome . ').'
					);
				}
			}

			$this->setTitle('Modificar Senha');
			$this->setViewVars([
				'usuarioNome' => $usuario->nome
			]);
		}

		public function logout()
		{
			$this->Auth->destroy();

			return $this->redirect($this->Auth->logoutRedirect());
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['logout', 'mudarSenha']);
		}
	}