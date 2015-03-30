<?php
include_once('../../../../wp-load.php');
include_once('../data_layer/JofMembersInterface.php');
		
if ($_POST['edit'] == 'Add')
{
	error_log( "here\n" );
	$title = $_POST["title"];
	$address = $_POST["address"];
	$email = $_POST["contact"];
	$skills = $_POST["specialty"];
	$LatLng = get_lat_long($address);
	$lat = $LatLng[0];
	$long = $LatLng[1];
	$member = new JofMember($title, $address, $email, $skills, $lat, $long);
	addMemberToDatabase($member);
}
else if ($_POST['edit'] == 'Edit') 
{
	$change = $_POST['newValue'];
	$id = $_POST['editMember'];
	$member = getMemberFromDatabase($id);
	switch ($_POST['fields']) 
	{
	case "title":
		$member->setTitle($change);
		break;
	case "address":
		$member->setAddress($change);
		break;
	case "email":
		$member->setEmail($change);
		break;
	case "skills":
		$member->setSkills($change);
		break;
	default:
		echo "You somehow selected something different";
		break;
	}
	addMemberToDatabase($member);
	echo "Member updated";
}
else if ($_POST['edit'] == 'Delete') 
{
	$id = $_POST['deleteMember'];
	removeMemberFromDatabase($id);
} 
else 
{
	echo "You somehow selected something different";
}

// function to get  the address
function get_lat_long($address){

    $address = str_replace(" ", "+", $address);

    $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=$region");
    $json = json_decode($json);

    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
	$LatLng = array($lat, $long);
    return $LatLng;
}

header('Location: members_menu.php');

?>
