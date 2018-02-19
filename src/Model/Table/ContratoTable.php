<?php  
	namespace App\Model\Table;

	use Simple\ORM\Components\Validator;
	use Simple\ORM\Table;

	class ContratoTable extends Table
	{
		public function initialize()
		{
			$this->setDatabase('SRICASH');

			$this->setTable('CONTRATO');

			$this->setPrimaryKey('seq');

			$this->setBelongsTo('', []);
		}

		public function quantidadeCadastrados()
		{
			$dataDeHoje = date("'". 'd.m.Y' ."'");
			
			return $this->find([])
				->sum('case when data_inclusao = '. $dataDeHoje .' then 1 else 0 end')->as('hoje')
				->count('contratante')->as('total')
				->where(['status !=' => 8])
				->fetch('class');
		}

		public function getContratoPorCod(int $seq)
		{
			return $this->find(['c.*', 'v.nome as vendedor'])
				->from(['contrato c', 'vendedor v'])
				->where(['c.seq =' => $seq, 'and', 'c.cod_vendedor = v.id'])
				->fetch('class');
		}

		public function listaContratosPorCod(int $contratante)
		{
			return $this->find([
					'c.seq', 'c.data_vencimento as vencimento', 'c.data_ativacao ativacao', 
					'c.valor_contrato as valor', 'c.data_ultima_cobranca as ultima_cobranca', 
					'm.descricao as modalidade', 'c.nota_fiscal_eletronica as nfe', 
					'c.num_termi_adm as termi_adm', 
					"case when(c.status = 8 and c.cancelado = 'T') 
        				then 'CANCELADO'
        				else s.descricao 
    				end as status"
				])
				->from(['contrato c', 'modalidade m', 'status s'])
				->where([
					'c.contratante =' => $contratante, 'and', 
					'c.modalidade = m.seq', 'and', 
					'c.status = s.seq'
				])
				->fetch('all');
		}

		public function getSequencia(int $contratante)
		{
			return $this->find(['seq'])
				->where(['contratante =' => $contratante])
				->orderBy(['seq desc'])
				->fetch('class');
		}

		public function normalizarDados(array $dadosContrato)
		{
			foreach ($dadosContrato as $coluna => $valor) {
				if ($coluna === 'data_inclusao' || $coluna === 'data_ativacao' ||
					$coluna === 'data_vencimento' || $coluna === 'data_ultima_cobranca'
				) {
					$dadosContrato[$coluna] = str_replace('/', '.', $valor);
				}
				else if ($coluna === 'valor_comissao' || $coluna === 'valor_contrato') {
					$dadosContrato[$coluna] = dinheiroParaFloat($valor);
				}
			}

			return array_map('removeSpecialChars', $dadosContrato);
		}

		protected function defaultValidator(Validator $validator)
		{
			$validator->addRule('seq')->notEmpty()->int()->size(4);
			$validator->addRule('data_vencimento')->empty()->string()->size(10);
			$validator->addRule('contratante')->empty()->int()->size(5);
			$validator->addRule('data_inclusao')->empty()->string()->size(10);
			$validator->addRule('data_ativacao')->empty()->string()->size(10);
			$validator->addRule('valor_contrato')->empty()->float()->size(6);
			$validator->addRule('data_ultima_cobranca')->empty()->string()->size(10);
			$validator->addRule('data_ultima_renovacao')->empty()->string()->size(10);
			$validator->addRule('obs')->empty()->string()->size(100);
			$validator->addRule('modalidade')->empty()->int()->size(4);
			$validator->addRule('razao_social')->empty()->string()->size(60);
			$validator->addRule('fantasia')->empty()->string()->size(60);
			$validator->addRule('dia_vencimento')->empty()->string()->size(2);
			$validator->addRule('status')->empty()->int()->size(2);
			$validator->addRule('seq_banco')->notEmpty()->int()->size(4);
			$validator->addRule('master')->empty()->int()->size(4);
			$validator->addRule('analitico')->notEmpty()->int()->size(4);
			$validator->addRule('sintetico')->notEmpty()->int()->size(4);
			$validator->addRule('cod_resp_financeiro')->notEmpty()->int()->size(5);
			$validator->addRule('valor_comissao')->empty()->float()->size(5);
			$validator->addRule('sintegra')->empty()->string()->size(1);
			$validator->addRule('efd')->empty()->string()->size(1);
			$validator->addRule('nota_fiscal_eletronica')->empty()->string()->size(1);
			$validator->addRule('num_termi_adm')->empty()->int()->size(4);
			$validator->addRule('hardware')->empty()->string()->size(1);
			$validator->addRule('cod_vendedor')->empty()->int()->size(5);
			$validator->addRule('data_cancelamento')->empty()->string()->size(10);
			$validator->addRule('cancelado')->empty()->string()->size(1);
			$validator->addRule('tipo_envio')->empty()->int()->size(2);

			return $validator;
		}
	}