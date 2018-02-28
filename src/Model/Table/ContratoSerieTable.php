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

		protected function preparaBuscaLicenca()
		{
			return $this->find([
					'cs.seq_contrato', 'cd.razao', 'm.descricao as modalidade',  
					"case when(c.status = 8 and c.cancelado = 'T') 
        				then 'CANCELADO'
        				else s.descricao 
    				end as status", 
    				'cs.modelo_impressora', 'cs.dias', 'cs.atualizar', 
    				'cs.serie_impressora', 'cs.ultima_renovacao'
				])
				->from([
					'cadastro cd', 'contrato c', 'contrato_serie cs', 
					'status s', 'modalidade m'
				]);
		}

		public function listaLicensas(int $quantity = null, int $skipTo = null)
		{
			$licencas = $this->preparaBuscaLicenca();

			if (!empty($quantity)) {
				$licencas->limit($quantity);
			}
			if (!empty($skipTo)) {
				$licencas->skip($skipTo);
			}
				
			return $licencas->where([
					'cd.cod_cadastro = c.contratante', 'and',
					'c.seq = cs.seq_contrato', 'and',
					'c.status = s.seq', 'and',
					'c.modalidade = m.seq'
				])
				->orderBy(['cd.razao'])
				->fetch('all');
		}

		public function buscaLicensas(int $filtro, $valor)
		{
			$filtroNome = null;

			switch ($filtro) {
				case 1: $filtroNome = 'cd.cnpj'; break;
				case 2: $filtroNome = 'cd.razao'; break;
				case 3: $filtroNome = 'cs.atualizar'; break;
			}

			if (!empty($filtroNome)) {
				$condicao = [
					'cd.cod_cadastro = c.contratante', 'and',
					'c.seq = cs.seq_contrato', 'and',
					'c.status = s.seq', 'and',
					'c.modalidade = m.seq', 'and'
				];
				$busca = $this->preparaBuscaLicenca()
					->orderBy([$filtroNome])
					->limit(100);

				if ($filtro === 3) {
					$condicao[$filtroNome.' ='] = $valor;
				}
				else {
					$condicao[$filtroNome.' like '] = $valor.'%';
				}
				
				return $busca->where($condicao)->fetch('all');
			}
			return false;
		}

		public function contarLicencas()
		{
			return $this->find([])
				->count('modelo_impressora')->as('quantidade')
				->from(['cadastro cd', 'contrato c', 'contrato_serie cs'])
				->where([
					'cd.cod_cadastro = c.contratante', 'and',
					'c.seq = cs.seq_contrato'
				])
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