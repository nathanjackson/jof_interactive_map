<?php
include_once('../../../wp-load.php');
include_once('./data_layer/JofMembersInterface.php');
include_once('./util.php');
		
if($_POST['Add'] == 'Add')
{
	$title = $_POST['title'];
	$address = $_POST['address'];
	$email = $_POST['email'];
	$skills = $_POST['specialty'];
	$LatLng = get_lat_long($address);
	$lat = $LatLng[0];
	$long = $LatLng[1];
	$member = new JofMember($title, $address, $lat, $long, $email, $skills);
	addMemberToDatabase($member);
}

echo "<meta http-equiv=\"refresh\" content=\"0;url=".$_SERVER['HTTP_REFERER']."\"/>";
