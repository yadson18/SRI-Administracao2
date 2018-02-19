<?php 
	function dinheiroParaFloat($number)
	{
		return preg_replace(['/[.]/', '/[,]/'], ['', '.'], $number);
	}

	function floatParaDinheiro($number)
	{
		return (!empty($number)) ? number_format($number, 2, ',', '.') : $number;
	}