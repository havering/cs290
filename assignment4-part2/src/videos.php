<?php

	$host = 'oniddb.cws.oregonstate.edu';
	$db = 'ohaverd-db';
	$user = 'ohaverd-db';
	$pw = 'IiY5XQx8Rg2jSG2G';

	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_errno) {
		echo 'Failed to connect to MySQLi: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}

	if(isset($_GET['vidName'])) {
		$reachEnd = true;

		// error handling from form
		// need to make this more plain english at some point
		if (!($_GET['vidName'])) {
			echo '<p>Video name is a required field. Please enter the name of the video.';
			$reachEnd = false;
		}

		if ($_GET['vidLen'] < 0) {
			echo '<p>Video length must be greater than 0.';
			$reachEnd = false;
		}

		if ($_GET['vidLen'] != "" && !(is_numeric($_GET['vidLen']) && $_GET['vidLen'] != 0)) {
			echo '<p>Video length must be numeric input.';
			$reachEnd = false;
		}

		// if it passes all input validation
		if ($reachEnd) {
			
			$stmt = $mysqli->prepare("INSERT INTO videos (name, category, length, rented) VALUES (?, ?, ?, ?)");
			$stmt->bind_param('ssii', $vid, $cat, $len, $rented);

			$vid = $_GET['vidName'];

			if ($_GET['vidCat'] == "" || $_GET['vidCat'] == null) {
				$cat = "Other";
			}
			else {
				$cat = $_GET['vidCat'];
			}

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
</head>
<body>
	
<div id="addVid">
	<h3>Welcome to the Video Store</h3>
	<form name="form" method="GET" action="videos.php">
		<p>Name: <input type="text" name="vidName">
		<p>Category: <input type="text" name="vidCat">
		<p>Length: <input type="text" name="vidLen">
		<p><input type="submit" value="Add movie">
		</form>

		<?php
			
			$filterquery = "SELECT DISTINCT category FROM videos";

			$dropdown = "<form id='filter' name='filter' method='POST' action='videos.php'>
			<p><label><b>Filter Table</b></label></p>
			<select name='filter' id='filter'>";
			// add in all movie option
			$dropdown .= "<option value='all'>All Movies</option>";

			$filter = $mysqli->query($filterquery);

			while ($row = $filter->fetch_array(MYSQLI_ASSOC)) {
				$filName = $row['category'];

				$dropdown .= "<option value='" . $filName . "'>" . $filName . "</option>";
			}

			$dropdown .= "</select>
			<input type='submit' value='Filter Results'></form>";
			
			echo $dropdown;

			 $filter->close();
		?>
		
<br>
<!--table display-->
<?php

	if ($_POST['filter'] == "all" || !($_POST['filter'])) {
		$query = "SELECT * FROM videos";
	}
	else {
		$query = "SELECT * FROM videos WHERE category='" . $_POST['filter'] . "'";
	}

	$newstmt = $mysqli->query($query);

	echo "<table style='border-collapse: separate; border-spacing: 10px; border: 1px solid black'>";
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
		echo "<td>" . $row["length"] . " minutes </td>";
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