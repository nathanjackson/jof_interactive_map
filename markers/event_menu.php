<!DOCTYPE html>
<html>
<head>
  <title>Event Menu</title>
  <link rel="stylesheet" href="location_menu.css">
</head>
<body>
	<form action="saveEvent.php" method="post" enctype="multipart/form-data">
		<fieldset>
			<legend>Add Event</legend>
			Name: <input type="text" name="name"><br>
			Address: <input type="text" name="address"><br /><br />
			Only Use Numbers <br />
			Begin Month: <input type="text" name="bmonth"><br>
			Begin Day: <input type="text" name="bday"><br>
			Begin Year: <input type="text" name="byear"><br>
			Begin Hour: <input type="text" name="bhour"><br>
			Begin Minute: <input type="text" name="bminute"><br>
			End Month: <input type="text" name="emonth"><br>
			End Day: <input type="text" name="eday"><br>
			End Year: <input type="text" name="eyear"><br>
			End Hour: <input type="text" name="ehour"><br>
			End Minute: <input type="text" name="eminute"><br>
		<input type="submit" name="edit" value="Add">
		</fieldset>
		<fieldset>
			<legend>Upload CSV Spreadsheet</legend>
			<input type="file" name="file" id="file"><br />
			<input type="submit" name="edit" value="Upload">
		</fieldset>
		<fieldset>
			<legend>Edit Event</legend>
			Change the <select name="fields">
				<option value="name">Name</option>
				<option value="address">Address</option>
			</select>
			Event ID: <input type="text" name="editEvent">
			New Value: <input type="text" name="newValue">
			<input type="submit" name="edit" value="Edit">
		</fieldset>
		<fieldset>
			<legend>Delete Event</legend>
			Event ID: <input type="text" name="deleteEvent">
			<input type="submit" name="edit" value="Delete"><br />
		</fieldset>
	</form>

	<?php
		include_once('data_layer/JofEventsInterface.php');
		include_once('data_layer/JofEvent.php');
		$events = getAllEventsFromDatabase();
		echo "<table><tr><th>ID</th><th>Name</th><th>Address</th><th>Begin Date</th><th>End Date</th></tr>";
		foreach($events as $event)
		{
			$name = $event->getName();
			$addr = $event->getAddress();
			$begin = $event->getBeginDate();
			$end = $event->getEndDate();
			$id = $event->getMemberId();
			echo "<tr><td>$id</td><td>$name</td><td>$addr</td><td>$begin</td><td>$end</td></tr>";
		}
		echo "</table>";
	?>
</body>
</html>