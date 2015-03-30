<!DOCTYPE html>
<html>
<head>
  <title>Members Menu</title>
  <link rel="stylesheet" href=location_menu.css">
</head>
<body>
	<form action="editMember.php" method="post">
		<fieldset>
			<legend>Add Member</legend>
			Title: <input type="text" name="title"><br>
			Address: <input type="text" name="address"><br>
			Specialty: <input type="text" name="specialty"><br>
			E-Mail: <input type="text" name="contact"><br>
		<input type="submit" name="edit" value="Add">
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
		echo "<ul>";
		foreach($members as $member)
		{
			$title = $member->getTitle();
			$addr = $member->getAddress();
			$email = $member->getEmail();
			$specialty = $member->getSkills();
			$id = $member->getMemberId();
			echo "<li>ID: $id\n\tTitle: $title\n\tAddress: $addr\n\tE-Mail: $email\n\tSkills: $specialty</li>";
		}
		echo "</ul>";
	?>
</body>
</html>
