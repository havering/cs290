<!DOCTYPE html>
<html>
<head>
<title>Login</title>
</head>
<?php
	session_start();
	// need to check for logout action in case user is directed here via content1 logout request
	if(isset($_GET['action']) && $_GET['action'] == 'logout') {
		session_unset();
		session_destroy();
	}
?>
<body>
	<form action="content1.php" method="POST">
		<p>Enter a username: <input type="text" name="username">
		<p><input type="submit" value="Submit">
	</form>