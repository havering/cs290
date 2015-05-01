<!DOCTYPE html>
<html>
<head>
	<title>Content 1</title>
</head>
<body>
<?php
	$n = 0;
	if (!(isset($_POST['username']))) {
		echo '<p>A username must be entered. Click <a href="login.php">here</a> to return to the login screen.';
	}
	else {
		echo "Hello " . $_POST['username'] . ". You have visited this page " . $n . " times.";
	}

?>