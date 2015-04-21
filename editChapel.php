<?php
include_once('../../../wp-load.php');
include_once('data_layer/JofChapelsInterface.php');
include_once('./util.php');
		
if($_POST['Update'] == 'Modify')
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
	$chapel = new JofChapel($address, $lat, $long, $long, $installation, $name, $cwocEmail, $phone, $parishEmail);
	$chapel->setChapelId($_POST['selected_chapel']);
	addChapelToDatabase($chapel);
}
else if($_POST['Update'] == 'Delete')
{
	$id = $_POST['selected_chapel'];
	removeChapelFromDatabase($id);
}

//echo "<meta http-equiv=\"refresh\" content=\"0;url=".$_SERVER['HTTP_REFERER']."\"/>";

?>
