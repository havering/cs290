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
		$pw = 'password removed for github push'

		$mysqli = new mysqli($host, $user, $pw, $db);
		if ($mysqli->connect_errno) {
			echo 'Failed to connect to MySQLi: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
		}
		else {
			echo 'Connection successful';
		}
	?>


</body>
</html>