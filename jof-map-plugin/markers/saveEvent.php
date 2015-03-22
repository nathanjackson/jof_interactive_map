
	<?php
		include_once('data_layer/JofEvent.php');
		include_once('data_layer/JofEventsInterface.php');
		
		if ($_POST['edit'] == 'Add')
		{
			$name = $_POST["name"];
			$address = $_POST["address"];
			$bmonth = $_POST["bmonth"];
			$bday = $_POST["bday"];
			$byear = $_POST["byear"];
			$bhour = $_POST["bhour"];
			$bminute = $_POST["bminute"];
			$emonth = $_POST["emonth"];
			$eday = $_POST["eday"];
			$eyear = $_POST["eyear"];
			$ehour = $_POST["ehour"];
			$eminute = $_POST["eminute"];
			$begin = gmdate("M d Y H:i:s", mktime($bhour, $bminute, 0, $bmonth, $bday, $byear, -1));
			$end = gmdate("M d Y H:i:s", mktime($ehour, $eminute, 0, $emonth, $eday, $eyear, -1));
			$event = new JofEvent($name, $address, $begin, $end);
			addEventToDatabase($event);
		}
		else if ($_POST['edit'] == 'Edit') 
		{
			$change = $_POST['newValue'];
			$id = $_POST['editEvent'];
			$event = getEventFromDatabase($id) 
			switch ($_POST['fields']) 
			{
			case "name":
				$event->setName($change);
				break;
			case "address":
				$event->setAddress($change);
				break;
			default:
				echo "You somehow selected something different";
			}
			addEventToDatabase($event) 
			echo "Event updated";
		} 
		else if ($_POST['edit'] == 'Delete') 
		{
			$id = $_POST['deleteEvent'];
			removeEventFromDatabase($id);
		}		 
		else 
		{
			echo "You somehow selected something different";
		}

	?>
