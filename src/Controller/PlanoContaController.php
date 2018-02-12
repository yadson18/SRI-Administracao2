<?php 
	namespace App\Controller;

	class PlanoContaController extends AppController
	{
		public function isAuthorized()
		{
			return $this->allow([]);
		}

		public function getAnaliticosPorCod()
		{
			if ($this->request->is('POST')) {
				$dados = array_map('removeSpecialChars', $this->request->getData());

				if (isset($dados['sintetico']) && is_numeric($dados['sintetico'])) {
					$analiticos = $this->PlanoConta->getAnaliticosPorCod($dados['sintetico']);

					if (!empty($analiticos)) {
						$this->Ajax->response('analiticos', [
							'status' => 'success',
							'data' => $analiticos
						]);
					}
				}
			}
			else {
				return $this->redirect('default');
			}
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized(['getAnaliticosPorCod']);
		}
	}