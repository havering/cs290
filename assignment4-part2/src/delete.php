<?php
	$host = 'oniddb.cws.oregonstate.edu';
	$db = 'ohaverd-db';
	$user = 'ohaverd-db';
	$pw = 'qC27C4IKTHJTJEli';

	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_errno) {
		echo 'Failed to connect to MySQLi: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}

	$id = $_POST['id'];

	if (!($stmt = $mysqli->prepare("DELETE FROM videos WHERE id=?"))) {
		echo 'Prepare statement failed';
	}
	
	$stmt->bind_param('i', $id);

	if (!($stmt->execute())) {
		echo 'Execute statement failed';
	}
	
	$stmt->close();

	header('LOCATION: videos.php');
?>