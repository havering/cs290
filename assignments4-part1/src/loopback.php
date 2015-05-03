<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
header('Content-type: text/html');

//$output = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
	if (empty($_POST)) {
		$_POST["parameters"] = null;
	}
	$_POST["Type"] = "POST";
	$output = json_encode($_POST);
} 
else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	if (empty($_GET)) {
		$_GET["parameters"] = null;
	}
	$_GET["Type"] = "GET";
	$output = json_encode($_GET);
}

echo $output;


?>