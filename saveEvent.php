<?php
include_once('../../../wp-load.php');
include_once('./data_layer/JofEventsInterface.php');
include_once('./util.php');

if ($_POST['Update'] == 'Modify') 
{
	//$LatLng = get_lat_long($_POST['address']);
	$lat = 0;//$LatLng[0];
	$long = 0;//$LatLng[1];
	$event = new JofEvent($_POST['name'], $_POST['address'], $lat, $long,
		$_POST['sdate'], $_POST['edate']);
	$event->setEventId($_POST['selected_event']);
	addEventToDatabase($event);
} 
else if ($_POST['Update'] == 'Delete') 
{
	$id = $_POST['selected_event'];
	removeEventFromDatabase($id);
}		 
	
echo "<meta http-equiv=\"refresh\" content=\"0;url=".$_SERVER['HTTP_REFERER']."\"/>";
