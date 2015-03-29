<?php
include_once('../../../../wp-load.php');
include_once('../data_layer/JofRegionsInterface.php');

if ($_POST['edit'] == 'Add')
{
	$name = $_POST["name"];
	$geojson = $_POST["geojson"];
	$region = new JofRegion($name, $geojson);
	addRegionToDatabase($region);
}
else if ($_POST['edit'] == 'Edit') 
{
	$change = $_POST['newValue'];
	$id = $_POST['editRegion'];
	$region = getRegionFromDatabase($id);
	switch ($_POST['fields']) 
	{
	case "name":
		$region->setName($change);
		break;
	case "geojson":
		$region->setGeoJsonStr($change);
		break;
	default:
		echo "You somehow selected something different";
		break;
	}
	addRegionToDatabase($region);
	echo "Region updated";
} 
else if ($_POST['edit'] == 'Delete') 
{
	$id = $_POST['deleteRegion'];
	removeRegionFromDatabase($id);
} 
else 
{
	echo "You somehow selected something different";
}

header('Location: regions.php');

?>
