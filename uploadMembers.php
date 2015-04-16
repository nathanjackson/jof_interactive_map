<?php
	if (isset($_FILES["file"])) 
	{
		//if there was an error uploading the file
		if ($_FILES["file"]["error"] > 0) 
		{
			echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
		}
		else 
		{	
			//Store file in directory "upload" with the name of "members.csv"
			$storagename = "members.csv";
			move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $storagename);
			echo "Stored in: " . "upload/" . $_FILES["file"]["name"] . "<br />";
		}
     } 
	 else 
	 {
		echo "No file selected <br />";
     }
	 echo "<meta http-equiv=\"refresh\" content=\"0;url=".$_SERVER['HTTP_REFERER']."\"/>";
?>