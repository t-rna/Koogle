<?php
	require_once('includes/functions.php');
	session_start();

	if (isset($_GET['q']) && $_GET['q'] != ""
		&& isset($_SESSION['tdmatrix']))
	{
		//$qvec = explode(",", $_GET['q']);
		$orig_q = $_GET['q'];
		$qvec = string_to_vec($orig_q);
		$tdmatrix = $_SESSION['tdmatrix'];
		$doc_sims = array();

		for ($i = 0; $i < count($tdmatrix); $i++)
		{
			$doc_i = $tdmatrix[$i];
			$sim = cosine_similarity($doc_i, $qvec);
			$doc_sims[$i] = $sim;
		}

		arsort($doc_sims);
	}
	else
	{
		header('Location: index.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Search results - Koogle</title>
	<link rel="stylesheet" type="text/css" href="css/search_style.css">
	<link rel="icon" href="images/k3.png">
	<script type="text/javascript">
		var displaying = 5;

  		function showMore() {
  			if (displaying < 50) {
			    for (var i = 0; i < 5; i++) {
			    	var rank = "r"+displaying;
			    	var x = document.getElementById(rank);
			    	x.style.display = 'block';
			    	displaying++;
			    }
			    document.querySelector('.content .value').innerHTML = displaying;
			}
		}
		function showLess() {
			if (displaying > 5) {
			    /*var i = displaying;
			    var j = displaying-5;
			    //var str = "i: " + i + ", j: " + j;
			    //alert(str);
			    while (i >= j) {
			    	var rank = "r"+i;
			    	alert(rank);
			    	var x = document.getElementById(rank);
			    	x.style.display = 'none';
			    	i--;
			    }*/
			    for (var i = displaying; i >= displaying-5; i--)
			    {
			    	var rank = "r"+i;	// note to self, difference here*
			    	var x = document.getElementById(rank);
			    	x.style.display = 'none';
			    }
			    displaying-=5;	// correction to displaying
			    document.querySelector('.content .value').innerHTML = displaying;
			}
		}
		function showTop() {
			while (displaying > 5)
				showLess();
		}

		function changeSelect(id) {
			var el = document.getElementById(id);
			if (el.className == "unselected")
			{
				var opts = document.querySelectorAll('input[type=button]');

				for(var i = 0; i < opts.length; i++)
				{
				    if(opts[i].className == "selected")
				        opts[i].className = "unselected";
				}
        		el.className = "selected";
			}
		}
	</script>
</head>
<body>
	<a href="index.php"><img id="logo" src="images/koogle.png" /></a>
	<div id="search_div">
		<form action="search.php" method="GET">	
		  	<input id="search_box" name="q" type="search" value="<?php echo $orig_q?>" /><input id="search_button" type="submit" value="" />
		</form>
		<input class="selected" id="o1" type="button" value="Top" onclick="showTop();changeSelect(this.id);">&nbsp;
		<input class="unselected" id="o2" type="button" value="More Results" onclick="showMore();changeSelect(this.id);">&nbsp;
		<input class="unselected" id="o3" type="button" value="Less Results" onclick="showLess();changeSelect(this.id);">
	</div>
	
  	<div id="results_container">
  		<div class="content">Showing <span class='value'>5</span> out of 50 results</div>
		<?php
			$rsp1 = "This document is very relevant to your query!...";
			$rsp2 = "This document is moderately relevant to your query...";
			$rsp3 = "This document slightly relevant to your query...";
			$rsp4 = "This document is not relevant to your query...";

			$i = 0;
			foreach ($doc_sims as $key => $val)
			{
				$str = "";
				if ($val >= 0.75)
					$str .= "The cosine similarity is <b>".$val."</b>. ".$rsp1;
				else if ($val >= 0.5)
					$str .= "The cosine similarity is <b>".$val."</b>. ".$rsp2;
				else if ($val >= 0.25)
					$str .= "The cosine similarity is <b>".$val."</b>. ".$rsp3;
				else
					$str .= "The cosine similarity is <b>".$val."</b>. ".$rsp4;

				if ($i < 5)
					echo '<div class="result" id=r'.$i.' style="display:block;"><p><span>Document '.$key.'</span><br>'.$str.'</p></div>'; 
				else
					echo '<div class="result" id=r'.$i.' style="display:none;"><p><span>Document '.$key.'</span><br>'.$str.'</p></div>'; 
				$i++; 
			}

			//unset($_SESSION['tdmatrix']); // change later
		?>
	</div>
	<footer>Koogle by Kevin Ng</footer>
</body>
</html>


<!-- goes at end		
//unset($_SESSION['tdmatrix']);

//$_GET['response'] = $doc_sims;
//header('Location: results.php'); -->
		



		
