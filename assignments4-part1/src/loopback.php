<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
header('Content-type: text/plain');

if ($_SERVER['REQUEST_METHOD'] == $_POST) {
	$_POST['Type'] = 'POST';
	if (empty($_POST['parameters'])) {
		$_POST['parameters'] = 'null';
	}
	$poster = json_encode($_POST);
	echo $poster;
}
else if ($_SERVER['REQUEST_METHOD'] == $_GET) {
	$_GET['Type'] = 'GET';
	if (empty($_GET['parameters'])) {
		$_GET['parameters'] = 'null';
	}
	$getter = json_encode($_GET);
	echo $getter;
}


?>