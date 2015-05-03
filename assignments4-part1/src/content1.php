<!DOCTYPE html>
<html>
<head>
	<title>Content 1</title>
</head>
<body>
<?php
session_start();

	if ($_POST['username'] == "" || $_POST['username'] == null) {
		echo '<p>A username must be entered. Click <a href="login.php">here</a> to return to the login screen.';
	}
	else {
		if (!(isset($_SESSION['visits']))) {
			$_SESSION['visits'] = 0;
		}

		$_SESSION['visits']++;

		echo 'Hello ' . $_POST['username'] . '. You have visited this page ' . $_SESSION['visits'] . ' times. Click <a href="login.php?action=logout">here</a> to log out.';
	}

?>