<?php
	session_start();

	echo '<!DOCTYPE html>
	<html>
	<head>
	<title>Content 2</title>
	</head>
	<body>';

	if ((isset($_SESSION['username']))) {
		echo 'Hi again, ' . $_SESSION['username'] . ', welcome to content 2.';
		echo '<p>Return to <a href="content1.php">content 1 page</a> or <a href="login.php?action=logout">log out</a>.';
	}
	else {
		echo '<p>A username must be entered. Click <a href="login.php">here</a> to return to the login screen.';
	}

	echo '</body>
  			</html>';
?>
