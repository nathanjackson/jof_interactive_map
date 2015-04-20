<?php
include_once('../../../wp-load.php');
include_once('./data_layer/JofChapelsInterface.php');
include_once('./util.php');

		
if($_POST['Add'] == 'Add')
{
	$address = $_POST['address'];
	$installation = $_POST['installation'];
	$name = $_POST['name'];
	$cwocEmail = $_POST['cwocEmail'];
	$phone = $_POST['phone'];
	$parishEmail = $_POST['parishEmail'];
	$LatLng = get_lat_long($address);
	$lat = $LatLng[0];
	$long = $LatLng[1];
	$chapel = new JofChapel($address, $lat, $long, $installation, $name, $cwocEmail, $phone, $parishEmail);
	addChapelToDatabase($chapel);
}

echo "<meta http-equiv=\"refresh\" content=\"0;url=".$_SERVER['HTTP_REFERER']."\"/>";
