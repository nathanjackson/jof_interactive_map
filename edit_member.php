<?php
include_once('../../../wp-load.php');
include_once('data_layer/JofMembersInterface.php');
		
if($_POST['Update'] == 'Modify')
{
	$LatLng = get_lat_long($address);
	$lat = $LatLng[0];
	$long = $LatLng[1];
	$member = new JofMember($title, $address, $email, $skills, $lat, $long);
	$member = new JofMember($_POST['title'], $_POST['address'],
		$_POST['specialty'], $_POST['email'], $lat, $long);
	$member->setMemberId($_POST['selected_member']);
	addMemberToDatabase($member);
}
else if($_POST['Update'] == 'Delete')
{
	$id = $_POST['selected_member'];
	removeMemberFromDatabase($id);
}

// function to get  the address
function get_lat_long($address){

    $address = str_replace(" ", "+", $address);

    $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=$region");
    $json = json_decode($json);

    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
	$LatLng = array($lat, $long);
	echo $LatLng;
    return $LatLng;
}

echo "<meta http-equiv=\"refresh\" content=\"0;url=".$_SERVER['HTTP_REFERER']."\"/>";

?>
