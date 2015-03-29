<!DOCTYPE html>
<html>
<head>
  <title>Regions Menu</title>
  <link rel="stylesheet" href=location_menu.css">
</head>
<body>
	<form action="regionsHandler.php" method="post" id="addRegion">
		<fieldset>
			<legend>Add Region</legend>
			Name: <input type="text" name="name"><br>
			GeoJSON: copy and paste the GeoJSON code generated here:
			<a href="http://geojson.io" target="_blank"><button type="button">Draw Region</button></a><br />
			<textArea rows="10" cols="75" wrap="soft" form="addRegion" name="geojson"></textArea><br />
		<input type="submit" name="edit" value="Add">
		</fieldset>
		<fieldset>
			<legend>Edit Region</legend>
			Change the <select name="fields">
				<option value="name">Name</option>
				<option value="geojson">GeoJSON</option>
			</select>
			RegionID: <input type="text" name="editRegion">
			New Value: <input type="text" name="newValue">
			<input type="submit" name="edit" value="Edit">
		</fieldset>
		<fieldset>
			<legend>Delete Region</legend>
			Region ID: <input type="text" name="deleteRegion">
			<input type="submit" name="edit" value="Delete"><br />
		</fieldset>
	</form>
	<?php
		include_once('../../../../wp-load.php');
                include_once('../data_layer/JofRegionsInterface.php');
		$regions = getAllRegionsFromDatabase();
		echo "<ul>";
		foreach($regions as $r)
		{
			$name = $r->getName();
			$geo = $r->getGeoJsonStr();
			$id = $r->getRegionId();
			echo "<li>ID: $id Name: $name</li>";
		}
		echo "</ul>";
	?>
</body>
</html>