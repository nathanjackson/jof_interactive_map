<?php
	include_once('../../../../wp-load.php');
	include_once('../data_layer/JofEventsInterface.php');
	include_once('./util.php');
	
	if ($_POST['add'] == 'Add')
	{
		$name = $_POST["name"];
		$address = $_POST["address"];
		$LatLng = get_lat_long($address);
		$lat = $LatLng[0];
		$long = $LatLng[1];
		$bmonth = $_POST["bmonth"];
		$bday = $_POST["bday"];
		$byear = $_POST["byear"];
		$bhour = $_POST["bhour"];
		$bminute = $_POST["bminute"];
		$emonth = $_POST["emonth"];
		$eday = $_POST["eday"];
		$eyear = $_POST["eyear"];
		$ehour = $_POST["ehour"];
		$eminute = $_POST["eminute"];
		$begin = gmdate("M d Y H:i:s", mktime($bhour, $bminute, 0, $bmonth, $bday, $byear, -1));
		$end = gmdate("M d Y H:i:s", mktime($ehour, $eminute, 0, $emonth, $eday, $eyear, -1));
		$event = new JofEvent($name, $address, $lat, $long, $begin, $end);
		addEventToDatabase($event);
	}
	
	echo "<meta http-equiv=\"refresh\" content=\"0;url=".$_SERVER['HTTP_REFERER']."\"/>";
?>
