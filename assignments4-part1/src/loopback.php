<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
header('Content-type: text/plain');



if ($_SERVER['REQUEST_METHOD'] == $_POST) {
	if (empty($_POST)) {
		$_POST['parameters'] = null;
	}
	$_POST['Type'] = 'POST';
	//$poster = json_encode($_POST);
	echo json_encode($_POST);
}
else if ($_SERVER['REQUEST_METHOD'] == $_GET) {
	if (empty($_GET)) {
		$_GET['parameters'] = null;
	}
	$_GET['Type'] = 'GET';
	//$getter = json_encode($_GET);
	echo json_encode($_GET);
}
echo json_encode($_GET);
echo json_encode($_POST);

?>