<?php
	$host = 'oniddb.cws.oregonstate.edu';
	$db = 'ohaverd-db';
	$user = 'ohaverd-db';
	$pw = 'IiY5XQx8Rg2jSG2G';

	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_errno) {
		echo 'Failed to connect to MySQLi: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}

	if (!($stmt = $mysqli->prepare("DELETE FROM videos"))) {
		echo 'Prepare statement failed';
	}
	
	if (!($stmt->execute())) {
		echo 'Execute statement failed';
	}
	
	$stmt->close();

	header('LOCATION: videos.php');
?>