<?php
include_once('../../../../wp-load.php');
include_once('./data_layer/JofRegionsInterface.php');

if ($_POST['Update'] == 'Modify') 
{
	$geojson = $_POST['geojson']
	$geojson = trim(preg_replace('/\s+/', ' ', $geojson));
	$region = new JofRegion($_POST['name', $geojson])
	addRegionToDatabase($region);
	echo "Region updated";
} 
else if ($_POST['Update'] == 'Delete') 
{
	$id = $_POST['selected_region'];
	removeRegionFromDatabase($id);
} 
else 
{
	echo "You somehow selected something different";
}

//header('Location: regions.php');
echo "<meta http-equiv=\"refresh\" content=\"0;url=".$_SERVER['HTTP_REFERER']."\"/>";
?>
