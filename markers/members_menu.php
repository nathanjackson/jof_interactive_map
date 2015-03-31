<!DOCTYPE html>
<html>
<head>
  <title>Members Menu</title>
  <link rel="stylesheet" href="location_menu.css">
</head>
<body>
	<form action="editMember.php" method="post" enctype="multipart/form-data">
		<fieldset>
			<legend>Add Member</legend>
			Title: <input type="text" name="title"><br>
			Address: <input type="text" name="address"><br>
			Specialty: <input type="text" name="specialty"><br>
			E-Mail: <input type="text" name="contact"><br>
		<input type="submit" name="edit" value="Add">
		</fieldset>
		<fieldset>
			<legend>Upload CSV Spreadsheet</legend>
			<input type="file" name="file" id="file"><br />
			<input type="submit" name="edit" value="Upload">
		</fieldset>
		<fieldset>
			<legend>Edit Member</legend>
			Change the <select name="fields">
				<option value="title">Title</option>
				<option value="address">Address</option>
				<option value="email">E-Mail</option>
				<option value="skills">Skills</option>
			</select>
			Member ID: <input type="text" name="editMember">
			New Value: <input type="text" name="newValue">
			<input type="submit" name="edit" value="Edit">
		</fieldset>
		<fieldset>
			<legend>Delete Member</legend>
			Member ID: <input type="text" name="deleteMember">
			<input type="submit" name="edit" value="Delete"><br />
		</fieldset>
	</form>

	<?php
		include_once('../../../../wp-load.php');
		include_once('../data_layer/JofMembersInterface.php');
		$members = getAllMembersFromDatabase();
		echo "<table><tr><th>ID</th><th>Title</th><th>Address</th><th>E-Mail</th><th>Skills</th></tr>";
		foreach($members as $member)
		{
			$title = $member->getTitle();
			$addr = $member->getAddress();
			$email = $member->getEmail();
			$specialty = $member->getSkills();
			$id = $member->getMemberId();
			echo "<tr><td>$id</td><td>$title</td><td>$addr</td><td>$email</td><td>$specialty</td></tr>";
		}
		echo "</table>";
	?>
</body>
</html>
