<?php
include_once('../../../wp-load.php');
include_once('data_layer/JofMembersInterface.php');
include_once('./util.php');
		
if($_POST['Update'] == 'Modify')
{
	$LatLng = get_lat_long($_POST['address']);
	$lat = $LatLng[0];
	$long = $LatLng[1];
	$member = new JofMember($_POST['title'], $_POST['address'], $lat, $long,
		$_POST['email'], $_POST['specialty']);
	$member->setMemberId($_POST['selected_member']);
	addMemberToDatabase($member);
}
else if($_POST['Update'] == 'Delete')
{
	$id = $_POST['selected_member'];
	removeMemberFromDatabase($id);
}

echo "<meta http-equiv=\"refresh\" content=\"0;url=".$_SERVER['HTTP_REFERER']."\"/>";

?>
