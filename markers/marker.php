<html>
<body>
	<h1>Not Implemented Yet</h1>
	<!--Use google geolocation api to turn address into lat,long
	save info to database-->
	<?php
		$servername = "";
		$username = "";
		$password = "";
		
		$connection = new mysqli($servername, $username, $password);
		if ($conn->connect_error) 
		{
			die("Connection failed: " . $conn->connect_error);
		} 
		
		$sql = $connection->prepare("INSERT INTO Markers (address, latitude, longitude, title, icon, name, specialty, contact)
		VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		$sql->bind_param("ssssssss", $_POST["address"], $latitude, $longitude, $_POST["title"], $_POST["icon"], $_POST["name"], $_POST["specialty"], $_POST["contact"]);
		$sql->execute();
		
		if ($conn->query($sql) === TRUE) 
		{
			echo "New record created successfully";
		}	
		else 
		{
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		$sql->close();
		$conn->close();
	?>
</body>
</html>