<?php
echo '<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title></title>
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
	<table border="1">
	<tr>
	<td>';

	for ($i = 0; $i < $wide - 1; $i++) {
		echo '<td>' . $min;
		$min++;
	}
	for ($j = 0; $j < $tall; $j++) {
			echo '<tr><td>' . $can;
			$can++;
		}
	
		echo '</table>';
	}
	echo '</body>
</html>';
?>