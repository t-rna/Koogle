<?php
	require_once('includes/creatematrix.php'); 
	session_start();

	if (!isset($_SESSION['timeout']))
		$_SESSION['timeout'] = time();
	else if(time() - $_SESSION['timeout'] > 300) {
		unset($_SESSION['timeout']);
	    unset($_SESSION['tdmatrix']);
	    //make a new matrix every 5 minutes
	}
	
	if (!isset($_SESSION['tdmatrix']))
		$_SESSION['tdmatrix'] = makeMatrix();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Koogle</title>
	<link rel="stylesheet" type="text/css" href="css/koogle_style.css">
	<link rel="icon" href="images/k3.png">
</head>
<body>
	<div id="search_div">
		<img id="logo" src="images/koogle.png" />
		<form action="search.php" method="GET">	
		  	<input id="search_box" name="q" type="search" placeholder="Search" />
		  	<p></p>
		  	<div id="buttons">
				<input type="submit" value="Koogle Search" />&nbsp;
				<input type="button" onclick="location.href='workings.php';" value="How It Works" />
			</div>
		</form>
	</div>
</body>
</html>