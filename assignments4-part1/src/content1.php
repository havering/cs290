<?php
	session_start();

	echo '<!DOCTYPE html>
			<html>
			<head>
				<title>Content 1</title>
			</head>
			<body>';

	if (($_POST['username'] == "" || $_POST['username'] == null) && $_SESSION['active'] == false) {
		echo '<p>A username must be entered. Click <a href="login.php">here</a> to return to the login screen.';
	}	
	else {
		$_SESSION['active'] = true;
	}

	if ($_SESSION['active'] == true) {
		if (isset($_SESSION['visits'])) {
			$_SESSION['visits'] = $_SESSION['visits'] + 1;
		}
		else {
			$_SESSION['visits'] = 0;
		}
		// if not already set, otherwise it rewrites when coming back from content2
		if (!(isset(	$_SESSION['username']))) {
				$_SESSION['username'] = $_POST['username'];	// for use by content2
		}
		
		echo 'Hello ' . $_SESSION['username'] . '. You have visited this page ' . $_SESSION['visits'];
		echo ' times. Click <a href="login.php?action=logout">here</a> to log out.';
		echo '<p><a href="content2.php">Click here</a> to go to content 2.';

	}

	echo '</body>
			</html>';
	

?>
