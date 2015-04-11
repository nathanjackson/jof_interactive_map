<?php
	include_once('../../../../wp-load.php');
	include_once('../data_layer/JofEventsInterface.php');

	if ($_POST['Update'] == 'Modify') 
	{
		$LatLng = get_lat_long($_POST['address']);
		$lat = $LatLng[0];
		$long = $LatLng[1];
		$event = new JofEvent($_POST['name'], $_POST['address'], $lat, $long,
		$_POST['sdate'], $_POST['edate']);
		$event->setEventId($_POST['selected_event']);
		addEventToDatabase($event) 
		echo "Event updated";
	} 
	else if ($_POST['Update'] == 'Delete') 
	{
		$id = $_POST['deleteEvent'];
		removeEventFromDatabase($id);
	}		 
	else 
	{
		echo "You somehow selected something different";
	}
	
// function to get  the address
function get_lat_long($address){

    $address = str_replace(" ", "+", $address);

    $json = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=$address&sensor=false");
    $json = json_decode($json);

    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
	$LatLng = array($lat, $long);
	echo $LatLng;
    return $LatLng;
}
 echo "<meta http-equiv=\"refresh\" content=\"0;url=".$_SERVER['HTTP_REFERER']."\"/>";
?>
