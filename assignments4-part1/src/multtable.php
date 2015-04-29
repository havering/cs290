<?php
echo '<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Results</title>
</head>
<body>';

error_reporting(E_ALL);
ini_set('display_errors',1);

$reachEnd = true;

// input validation
if ($_GET['minCand'] > $_GET['maxCand']) {
	echo '<p>Minimum multiplicand larger than maximum.';
	$reachEnd = false;
}
if ($_GET['minPlier'] > $_GET['maxPlier']) {
	echo '<p>Minimum multiplier larger than maximum.';
	$reachEnd = false;
}

foreach($_GET as $key => $value) {
	if (!(is_numeric($value))) {
		echo '<p>' . $key . ' must be an integer';
		$reachEnd = false;
	}
}

foreach($_GET as $key => $value) {
	if (empty($value)) {
		echo '<p>Missing parameter ' . $key . ".";
		$reachEnd = false;
	}
}

$tall = $_GET['maxCand'] - $_GET['minCand'] + 2;

$wide = $_GET['maxPlier'] - $_GET['minPlier'] + 2;

$min = $_GET['minPlier'];

$can = $_GET['minCand'];

if ($reachEnd == true) {
	// table creation
	echo '<p>Multiplication table
	<table style="text-align: center; border: 1px solid">';
		// start from 1 instead of 0 so you don't have to do more math in the cells
		for ($i = 1; $i <= $tall; $i++) {  
			echo '<tr>';
			
			for ( $j = 1 ; $j <= $wide ; $j++) { 
				// blank space in top lefthand side
				if (($i == 1) && ($j == 1)){
					echo '<td></td>'; }
				// top row/table header
				else if (($i == 1) && ($j > 1)){
					echo '<th>' . ($min + ($j-2)); 
				}
				// lefthand column
				else if (($j == 1) && ($i > 1)){
					echo '<th>' . ($can + ($i-2)). '</th>'; 
				}
				// the remainder of the cells
  			else if (($j > 1) && ($i > 1)){
  					echo '<td>' . ( ($min + ($j-2)) * ($can + ($i-2)) ) . '</td>'; 
  				}
 			}  
  			echo '</tr>';  
 	 	} 
	
		echo '</table>';
	}
	echo '</body>
</html>';
?>