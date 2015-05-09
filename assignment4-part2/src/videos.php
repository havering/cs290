<!DOCTYPE html>
<html>
<head>
	<title>Video Store</title>
</head>
<body>
	<?php
		$host = 'oniddb.cws.oregonstate.edu';
		$db = 'ohaverd-db';
		$user = 'ohaverd-db';
		$pw = 'deleted for github push';

		$mysqli = new mysqli($host, $user, $pw, $db);
		if ($mysqli->connect_errno) {
			echo 'Failed to connect to MySQLi: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
		}
		else {
			echo 'Connection successful';
		}
	?>

<div style="font-family: sans serif">
	<h3>Welcome to the Video Store</h3>
	<form name="addVid">
		<p>Name: <input type="text" name="vidName">
		<p>Category: <input type="text" name="vidCat">
		<p>Length: <input type="number" min="0" name="vidLen">
		<p><input type="submit" value="Add movie">

</body>
</html>