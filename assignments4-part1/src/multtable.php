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

// input validation
if ($_GET['minCand'] > $_GET['maxCand']) {
	echo '<p>Minimum multiplicand larger than maximum.';
}
if ($_GET['minPlier'] > $_GET['maxPlier']) {
	echo '<p>Minimum multiplier larger than maximum.';
}

foreach($_GET as $key => $value) {
	if (!(is_numeric($value))) {
		echo '<p>' . $key . ' must be an integer';
	}
}

foreach($_GET as $key => $value) {
	if (empty($value)) {
		echo '<p>Missing parameter ' . $key . ".";
	}
}

// table creation
echo '<p>Multiplication table
<table border="1">
<tr>
<td>Key
<td>Value';
foreach($_GET as $key => $value) {
	echo '<tr><td>' . $key . '<td>' . $value;
}
echo '</table>';
	echo '</body>
</html>';
?>