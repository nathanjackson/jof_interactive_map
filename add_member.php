<?php
include_once('../../../wp-load.php');
include_once('./data_layer/JofMembersInterface.php');
		
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

// function to get  the address
function get_lat_long($address){

    $encoded_address = urlencode($address);

    $json = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=$encoded_address&sensor=false");
    echo $json;
    $json = json_decode($json);

    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
    $LatLng = array($lat, $long);
    return $LatLng;
}

echo "<meta http-equiv=\"refresh\" content=\"0;url=".$_SERVER['HTTP_REFERER']."\"/>";
