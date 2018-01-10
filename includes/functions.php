<?php
	function dot_product($vec1, $vec2)
	{
		$n = min(count($vec1), count($vec2));
		$sum = 0;
		for ($i = 0; $i < $n; $i++)
			$sum += ($vec1[$i] * $vec2[$i]);
		return $sum; 
	}

	function magnitude($vec)
	{
		return sqrt(dot_product($vec, $vec));
	}

	function cosine_similarity($doc_vec, $query_vec)
	{
		return (dot_product($doc_vec, $query_vec) / (magnitude($doc_vec) * magnitude($query_vec)));
	}

	function string_to_vec($str)
	{
		$ret = preg_replace("/,[\s]+/",",",$str);
		$ret = preg_split("/[, ]/", $ret);
		return $ret;
	}

	/**** TEST ****
	$d1 = array(2, 3, 5);
	$d2 = array(3, 7, 1);
	$q = array(2, 0, 2);

	echo 'sim(d1, q) = ' . cosine_similarity($d1, $q) . '<br>';
	echo 'sim(d2, q) = ' . cosine_similarity($d2, $q) . '<br>';*/
?>