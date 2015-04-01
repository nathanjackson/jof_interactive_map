<?php
	include_once('../../../../wp-load.php');
	include_once('../data_layer/JofEventsInterface.php');

	if ($_POST['Update'] == 'Modify') 
	{
		$event = new Jof($_POST['name'], $_POST['address'],
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
	
	
 echo "<meta http-equiv=\"refresh\" content=\"0;url=".$_SERVER['HTTP_REFERER']."\"/>";
?>
