<?php

	$host = 'oniddb.cws.oregonstate.edu';
	$db = 'ohaverd-db';
	$user = 'ohaverd-db';
	$pw = 'removed for git push';

	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_errno) {
		echo 'Failed to connect to MySQLi: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}

	if(isset($_GET)) {
		$reachEnd = true;

		// error handling from form
		foreach($_GET as $key => $value) {
			if (empty($value)) {
				echo '<p>Missing parameter ' . $key . ".";
				$reachEnd = false;
			}
		}

		if ($reachEnd) {
			$vid = $_GET['vidName'];
			$cat = $_GET['vidCat'];
			$len = $_GET['vidLen'];

			if (!($statement = $mysqli->prepare("INSERT INTO videos (name, category, length) VALUES ('$vid', '$cat', '$len')"))) {
				echo 'Prepare statement failed.';
			}

		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Video Store</title>
</head>
<body>
	
<div name="form" method="GET" action="videos.php">
	<h3>Welcome to the Video Store</h3>
	<form name="addVid">
		<p>Name: <input type="text" name="vidName">
		<p>Category: <input type="text" name="vidCat">
		<p>Length: <input type="number" min="0" name="vidLen">
		<p><input type="submit" value="Add movie">
		</form>

<!--table display-->
<?php

?>
</body>
</html>