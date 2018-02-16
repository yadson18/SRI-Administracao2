<?php 
	namespace App\Controller;

	class CodigopaisController extends AppController
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