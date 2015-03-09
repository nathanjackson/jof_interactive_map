<html>
<body>
	<h1>Not Implemented Yet</h1>
	<!--Use google geolocation api to turn address into lat,long
	save info to database-->
	<?php
		include_once('data_layer/JofMember.php');
		include_once('data_layer/JofMembersInterface.php');
		
		$memberId = $_POST["name"];
		$title = $_POST["title"];
		$address = $_POST["address"];
		$email = $_POST["contact"];
		$skills = $_POST["specialty"];
		
		$member = new JofMember($title, $address, $email, $skills);
		addMemberToDatabase($member);
	?>
</body>
</html>