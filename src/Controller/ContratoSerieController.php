<?php 
	namespace App\Controller;

	class ContratoSerieController extends AppController
	{
		public function isAuthorized()
		{
			return $this->allow([]);
		}

		public function beforeFilter()
		{
			$this->Auth->isAuthorized([]);
		}
	}