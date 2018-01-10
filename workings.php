<?php
	require_once('includes/functions.php');
	session_start();

	$orig_q = "";
	$orig_d = "";

	if (!isset($_SESSION['tdmatrix']))
		header('Location: index.php');
	$tdmatrix = $_SESSION['tdmatrix'];

	if (isset($_GET['q']) && isset($_GET['d'])
		&& $_GET['q'] != "" && $_GET['d'] != "")
	{
		$orig_q = $_GET['q'];
		$orig_d = $_GET['d'];
		/*$qvec = preg_replace("/,([\s])+/",",",$orig_q);
		$qvec = preg_split("/[, ]/", $qvec);*/
		$qvec = string_to_vec($orig_q);
		$dvec = string_to_vec($orig_d);
	}

	//print_r($qvec);
	//print_r($dvec);


	/*echo 'Your Term-Document Matrix<br><br>';
	$tdmatrix = $_SESSION['tdmatrix'];

	echo '<table>';
	for ($row = 0; $row < 5; $row++)
	{
		echo '<tr>';
		for ($col = 0; $col < count($tdmatrix[$row]); $col++)
		{
			echo '<td style="padding: 10px;">';
			echo $tdmatrix[$row][$col];
			echo '</td>';
		}
		echo "</tr>";
	}
	echo '</table>';
	echo '<br><br>';
	echo 'Your Query Vector: ';
	echo '(1, 2, 3, 4, 5, 6, 7, 8, 9, 10)';
	echo '<br><br>';
	echo 'Dot Product: ';
	$qvec = explode(",", "1,2,3,4,5,6,7,8,9,10");
	echo dot_product($tdmatrix[0], $qvec);
	echo '<br><br>';
	echo 'Cosine: ';
	echo cosine_similarity($tdmatrix[0], $qvec);*/

	function showNumer($q, $d) {
		echo '<span>(';
		for ($i = 0; $i < count($q)-1; $i++)
			echo $q[$i] . ', ';
		echo $q[count($q)-1] . ') &middot; (';
		for ($i = 0; $i < count($d)-1; $i++)
			echo $d[$i] . ', ';
		echo $d[count($d)-1] . ')</span>';
	}
	function showDenom($q, $d) {
		echo '<span>&radic;(';
		for ($i = 0; $i < count($q)-1; $i++)
			echo $q[$i] . '&sup2+';
		echo $q[count($q)-1] . '&sup2)&InvisibleTimes;&radic;(';
		for ($i = 0; $i < count($d)-1; $i++)
			echo $d[$i] . '&sup2+';
		echo $d[count($d)-1] . '&sup2)</span>';
	}
	function showForm1($q, $d) {
		echo '<div class="fmla1">';
		showNumer($q, $d);
		echo '<hr id="f1">';
		showDenom($q, $d);
		echo '</div>';
	}
	function showForm2($q, $d) {
		echo '<div class="fmla2"><span>' . dot_product($d, $q) . '</span>';
		echo '<hr id="f2">';
		echo '<span>' . magnitude($q) . ' &times ' . magnitude($d) . '</span></div>';
	}
	function showSim($q, $d) {
		echo '<div class="fmla2"><span class="fmla2">cos(&theta;) = ' . cosine_similarity($d, $q) . '</span></div>';
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>How It Works - Koogle</title>
	<link rel="stylesheet" type="text/css" href="css/search_style.css">
	<link rel="stylesheet" type="text/css" href="css/workings_style.css">
	<link rel="icon" href="images/k3.png">
	<!--<script type="text/javascript" async
  		src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-MML-AM_CHTML">
	</script>-->
</head>
<body>
	<a href="index.php"><img id="logo" src="images/koogle.png" /></a>
	<div id="search_div">
		<form action="?" method="GET">	
		  	<input class="entry_box" name="q" type="search" value="<?php echo $orig_q?>" placeholder="Query Vector" />
		  	<input class="entry_box" name="d" type="search" value="<?php echo $orig_d?>" placeholder="Document Vector" /><input id="search_button" type="submit" value="" />
		</form>
	</div>

	<div id="results_container">
		<h4>We're ranking your results using this formula</h4>
		<img src="images/cossim.svg">
		<?php
			if (isset($_GET['q']) && isset($_GET['d'])
				&& $_GET['q'] != "" && $_GET['d'] != "")
			{
				echo "<h4>Here's the similarity calculation for your query and document</h4><br>";
				showForm1($qvec, $dvec);
				echo '<br><br>';
				showForm2($qvec, $dvec);
				echo '<br><br>';
				showSim($qvec, $dvec);
				echo '<br><br>';
				echo "<h4>Here's the similarity of your query to the other documents</h4><br>";
				echo '<table>';
				echo '<tr><td></td>';
				for ($col = 0; $col < count($tdmatrix[0]); $col++)
				{
					echo '<th style="font-style: italic; text-align: center;">T'.$col.'</th>';
				}
				echo '<th style="font-style: italic; text-align: right;">cos(&theta;)</th>';
				echo '</tr>';
				for ($row = 0; $row < count($tdmatrix); $row++)
				{
					echo '<tr>';
					echo '<th style="font-style: italic; text-align: right;">D'.$row.'</th>';
					for ($col = 0; $col < count($tdmatrix[$row]); $col++)
					{
						echo '<td style="padding: 12px; text-align: center;">';
						echo $tdmatrix[$row][$col];
						echo '</td>';
					}
					echo '<td style="font-style: italic; text-align: right; background-color: #f5f5f5;">'.round(cosine_similarity($tdmatrix[$row], $qvec), 3, PHP_ROUND_HALF_UP).'</td>';
					echo "</tr>";
				}
				echo '</table>';
			}
			else
				echo "<p>You haven't entered a query or document vector</p>";
		?>
	</div>
	<footer>Koogle by Kevin Ng. Formula image: <a href="https://en.wikipedia.org/wiki/Cosine_similarity">Wikipedia</a></footer>
</body>
</html>