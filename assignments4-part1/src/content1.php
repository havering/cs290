<?php
	session_start();

	if ($_POST['username'] == "" || $_POST['username'] == null) {
		echo '<p>A username must be entered. Click <a href="login.php">here</a> to return to the login screen.';
	}
	else {
		if (isset($_SESSION['visits'])) {
			$_SESSION['visits'] = $_SESSION['visits'] + 1;
		}
		else {
			$_SESSION['visits'] = 0;
		}
		
		$_SESSION['username'] = $_POST['username'];	// for use by content2
?>
<!DOCTYPE html>
<html>
<head>
	<title>Content 1</title>
</head>
<body>
	<?php
		echo 'Hello ' . $_POST['username'] . '. You have visited this page ' . $_SESSION['visits'];
		echo ' times. Click <a href="login.php?action=logout">here</a> to log out.';
		echo '<p><a href="content2.php">Click here</a> to go to content 2.';
	}

?>
</body>
</html>