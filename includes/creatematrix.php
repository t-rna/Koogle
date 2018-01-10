<?php
	require_once('createvector.php');
	//session_start();
	//echo "Creating a matrix...<br>";

	function makeMatrix() {
		$tdmatrix = array();
		for ($i = 0; $i < 50; $i++)
			$tdmatrix[$i] = makeDefaultVector();
		return $tdmatrix;
	}

	/*$_SESSION['tdmatrix'] = $tdmatrix;

	sleep(1);
	header("Location: index.php");*/

	/* WAS INSIDE FOR LOOP
	$vec = array();
	for ($j = 0; $j < 10; $j++)
		$vec[$j] = rand(0, 10);*/
?>


