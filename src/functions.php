<?php 
	function dinheiroParaFloat($number)
	{
		return preg_replace(['/[.]/', '/[,]/'], ['', '.'], $number);
	}

	function floatParaDinheiro($number)
	{
		if (is_numeric($number)) {
			return number_format($number, 2, ',', '.');
		}
		return $number;
	}

	function numeroFormatoBR($number)
	{
		if (is_numeric($number)) {
			return number_format($number, 0, '', '.');
		}
		return $number;
	}