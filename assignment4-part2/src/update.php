<?php
	$host = 'oniddb.cws.oregonstate.edu';
	$db = 'ohaverd-db';
	$user = 'ohaverd-db';
	$pw = 'IiY5XQx8Rg2jSG2G';

	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_errno) {
		echo 'Failed to connect to MySQLi: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}

	$id = $_POST['id'];
	$status = $_POST['rented'];

	// need an if else statement here to toggle between one and the other
	// if it isn't checked out
	if ($status == 0) {
		if (!($stmt = $mysqli->prepare("UPDATE videos SET rented=1 WHERE id=?"))) {
			echo 'Prepare statement failed';
		}
	
		$stmt->bind_param('i', $id);

		if (!($stmt->execute())) {
			echo 'Execute statement failed';
		}
	
		$stmt->close();
	}
	// if it is checked out
	if ($status == 1) {
		if (!($stmt = $mysqli->prepare("UPDATE videos SET rented=0 WHERE id=?"))) {
			echo 'Prepare statement failed';
		}
	
		$stmt->bind_param('i', $id);

		if (!($stmt->execute())) {
			echo 'Execute statement failed';
		}
	
		$stmt->close();
	}
	

	header('LOCATION: videos.php');
?>