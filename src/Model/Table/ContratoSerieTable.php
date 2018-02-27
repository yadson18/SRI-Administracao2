<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class ContratoSerieTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH');

			$this->setTable('CONTRATO_SERIE');

			$this->setPrimaryKey('seq_contrato');

			$this->setBelongsTo('', []);
		}

		public function getLicenca(int $seq_contrato, string $serie_impressora)
		{
			return $this->find(['serie_impressora'])
				->where([
					'seq_contrato =' => $seq_contrato, 'and',
					'serie_impressora =' => $serie_impressora
				])
				->fetch('class');
		}

		public function listaLicensas(int $quantity = null, int $skipTo = null)
		{
			$licencas = $this->find([
					'cs.seq_contrato', 'c.razao_social', 'm.descricao as modalidade',  
					"case when(c.status = 8 and c.cancelado = 'T') 
        				then 'CANCELADO'
        				else s.descricao 
    				end as status", 
    				'cs.modelo_impressora', 'cs.dias', 'cs.atualizar', 
    				'cs.serie_impressora', 'cs.ultima_renovacao'
				])
				->from(['contrato c', 'contrato_serie cs', 'status s', 'modalidade m']);

			if (!empty($quantity)) {
				$licencas->limit($quantity);
			}
			if (!empty($skipTo)) {
				$licencas->skip($skipTo);
			}
				
			return $licencas->where([
					'c.seq = cs.seq_contrato', 'and',
					'c.status = s.seq', 'and',
					'c.modalidade = m.seq'
				])
				->orderBy(['razao_social'])
				->fetch('all');
		}

		public function buscaLicensas(int $filtro, $valor)
		{
			$filtroNome = null;

			switch ($filtro) {
				case 1: $filtroNome = 'c.status'; break;
				case 2: $filtroNome = 'cs.razao_social'; break;
			}
		}

		public function contarLicencas()
		{
			return $this->find([])
				->count('modelo_impressora')->as('quantidade')
				->fetch('class');
		}

		public function getEquipamentosContrato(int $seq_contrato)
		{
			return $this->find(['numero_ecf', 'serie_impressora', 'modelo_impressora'])
				->where(['seq_contrato =' => $seq_contrato])
				->fetch('all');
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('seq_contrato')->notEmpty()->int()->size(4);
			$validator->addRule('serie_impressora')->notEmpty()->string()->size(30);
			$validator->addRule('numero_ecf')->notEmpty()->int()->size(4);
			$validator->addRule('modelo_impressora')->empty()->string()->size(12);
			$validator->addRule('dias')->empty()->int()->size(4);
			$validator->addRule('ultima_renovacao')->empty()->string()->size(4);
			$validator->addRule('atualizar')->empty()->string()->size(1);
			$validator->addRule('online')->empty()->string()->size(1);

			return $validator;
		}
	}