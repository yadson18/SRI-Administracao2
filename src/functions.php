<?php 
	function dinheiroParaFloat($numero)
	{
		return preg_replace(['/[.]/', '/[,]/'], ['', '.'], $numero);
	}

	function floatParaDinheiro($numero)
	{
		if (is_numeric($numero)) {
			return number_format($numero, 2, ',', '.');
		}
		return $numero;
	}

	function dataFormatoBR($data)
	{
		if (is_string($data) && !empty($data)) {
			return date('d/m/Y', strtotime($data));
		}
		return $data;
	}

	function numeroFormatoBR($numero)
	{
		if (is_numeric($numero)) {
			return number_format($numero, 0, '', '.');
		}
		return $numero;
	}