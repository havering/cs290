<?php

	$host = 'oniddb.cws.oregonstate.edu';
	$db = 'ohaverd-db';
	$user = 'ohaverd-db';
	$pw = 'delete for git push';

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
	echo "<tr><td><b>Name</b></td>"; 
	echo "<td><b>Category</b></td>";
	echo "<td><b>Length</b></td>";
	echo "<td><b>Rented?</b></td>";
	echo "<td><b>Delete</b></td>";
	echo "<td><b>Check In/Out</b></td>";

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
		// delete button
		$rowId = $row["id"];
		echo '<td><form action="delete.php" method="POST">';
		echo '<input type="hidden" name="id" value="' . $rowId . '">';
		echo '<input type="submit" value="Delete"></form>';
		// check in or out button
		$status = $row["rented"];
		echo '<td align=center><form action="update.php" method="POST">';
		echo '<input type="hidden" name="id" value="' . $rowId . '">';
		echo '<input type="hidden" name="rented" value="' . $status . '">';
		echo '<input type="submit" value="Update"></form>';
		echo "</tr>";
	}
	echo "</table>";

	$newstmt->close();


?>
<form action="delete_all.php" method="POST">
	<p><input type="submit" value="Delete All Movies">
</form>
</div>
</body>
</html>