<?php
	include_once('../../../../wp-load.php');
	include_once('../data_layer/JofRegionsInterface.php');
	
	if ($_POST['add'] == 'Add')
	{
		$name = $_POST['name'];
		$geojson = $_POST['geojson'];
		$geojson = trim(preg_replace('/\s+/', '', $geojson));
		$region = new JofRegion($name, $geojson);
		addRegionToDatabase($region);
	}
	
	echo "<meta http-equiv=\"refresh\" content=\"0;url=".$_SERVER['HTTP_REFERER']."\"/>";
?>