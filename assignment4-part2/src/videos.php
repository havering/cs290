<?php

	$host = 'oniddb.cws.oregonstate.edu';
	$db = 'ohaverd-db';
	$user = 'ohaverd-db';
	$pw = 'qC27C4IKTHJTJEli';

	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_errno) {
		echo 'Failed to connect to MySQLi: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}

	if(isset($_GET['vidName'])) {
		$reachEnd = true;

		// error handling from form
		foreach($_GET as $key => $value) {
			if (empty($value)) {
				echo '<p>Missing parameter ' . $key . ".";
				$reachEnd = false;
			}
		}

		if ($reachEnd) {
			
			$stmt = $mysqli->prepare("INSERT INTO videos (name, category, length, rented) VALUES (?, ?, ?, ?)");
			$stmt->bind_param('ssii', $vid, $cat, $len, $rented);

			$vid = $_GET['vidName'];
			$cat = $_GET['vidCat'];
			$len = $_GET['vidLen'];
			$rented = 0;	// rented is false as it is just being added

			$stmt->execute();
			
			$stmt->close();
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Video Store</title>
	<stylesheet rel="stylesheet" href="videos.css">
	<script src="videos.js"></script>
</head>
<body>
	
<div id="addVid">
	<h3>Welcome to the Video Store</h3>
	<form name="form" method="GET" action="videos.php">
		<p>Name: <input type="text" name="vidName">
		<p>Category: <input type="text" name="vidCat">
		<p>Length: <input type="number" min="1" name="vidLen">
		<p><input type="submit" value="Add movie">
		</form>

<!--table display-->
<?php
	$query = "SELECT * FROM videos";

	$newstmt = $mysqli->query($query);

	echo "<table cellpadding=2>";
	echo "<tr><td><b>Name</b></td><td><b>Category</b></td><td><b>Length</b></td><td><b>Rented?</b></td><td><b>Delete</b></td>";
	while ($row = $newstmt->fetch_assoc()) {
		echo "<tr>";
		echo "<td>" . $row["name"] . "</td>";
		echo "<td>" . $row["category"] . "</td>";
		echo "<td>" . $row["length"] . "</td>";
		if ($row["rented"] == 0) {
			$resultRent = "Available";
		}
		else {
			$resultRent = "Checked out";
		}
		echo "<td>" . $resultRent . "</td>";
		$rowId = $row["id"];
		echo '<td><button onclick="deleteRow()">Delete</button>';
		echo "</tr>";
	}
	echo "</table>";

	

	$newstmt->close();


?>
</div>
</body>
</html>