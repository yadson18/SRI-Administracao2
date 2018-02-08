<?php 
	namespace App\Controller;

	class IbgeController extends AppController
	{
		public function isAuthorized()
		{
			return $this->allow([]);
		}

		public function municipiosUF()
		{
			if ($this->request->is('POST')) {
				$dados = array_map('removeSpecialChars', $this->request->getData());

				if (isset($dados['sigla'])) {
					$this->Ajax->response('municipios', [
						'municipios' => $this->Ibge->municipiosUF($dados['sigla'])
					]);
				}
			}
			else {
				return $this->redirect('default');
			}
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['municipiosUF']);
		}
	}