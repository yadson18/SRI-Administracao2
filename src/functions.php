<?php 
	function dinheiroParaFloat($number)
	{
		return preg_replace(['/[.]/', '/[,]/'], ['', '.'], $number);
	}