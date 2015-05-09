<?php
	$host = 'oniddb.cws.oregonstate.edu';
	$db = 'ohaverd-db';
	$user = 'ohaverd-db';
	$pw = 'qC27C4IKTHJTJEli';

	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_errno) {
		echo 'Failed to connect to MySQLi: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}

	$stmt = $mysqli->prepare("DELETE FROM videos WHERE id=?");
	$stmt->bind_param('i', $id);

	$id = $_POST['id'];

	$stmt->execute();
	$stmt->close();

	header('LOCATION: videos.php');
?>