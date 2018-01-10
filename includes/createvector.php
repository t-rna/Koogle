<?php
	function makeDefaultVector()
	{
		$vec = array();
		for ($i = 0; $i < 10; $i++)
			$vec[$i] = rand(0, 10);
		return $vec;
	}

	function makeCustomVector($n)
	{
		$vec = array();
		for ($i = 0; $i < $n; $i++)
			$vec[$i] = rand(0, 10);
		return $vec;
	}
?>