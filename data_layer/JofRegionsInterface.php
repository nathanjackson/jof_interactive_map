<?php

include_once('JofRegion.php');

/**
* Adds the specified region to the Wordpress database.  If the region already
* exists, it is updated.
*/
function addRegionToDatabase($region) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'jofregions';

	$data = array('regionid' => $region->getRegionId(),
		'name' => $region->getName(),
		'geojsonstr' => $region->getGeoJsonStr());

	if($region->getRegionId() == null) {
		$wpdb->insert($table_name, $data);
	}
	else {
		$wpdb->update($table_name, $data,
			array('regionid' => $region->getRegionId()));
	}
}

/**
* Removes the region specified by an id from the Wordpress database.
*/
function removeRegionFromDatabase($id) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'jofregions';
	$wpdb->query(
		$wpdb->prepare("DELETE FROM $table_name WHERE regionid = %d;",
			$id));
}

/**
* Gets the region specified by an id from the Wordpress database.
*/
function getRegionFromDatabase($id) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'jofregions';
	$res = $wpdb->get_row(
		"SELECT regionid,
			name,
			geojsonstr
			FROM $table_name WHERE regionid = $id;");
	$tmp = new JofRegion($res->name, $res->geojsonstr);
	$tmp->setRegionId($res->regionid);
	return $tmp;
}

/**
* Returns all regions from the database.
*/
function getAllRegionsFromDatabase() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'jofregions';
	$rows = $wpdb->get_results(
		"SELECT regionid,
			name,
			geojsonstr FROM $table_name;");
	$result = array();
	foreach($rows as &$row) {
		$tmp = new JofRegion($row->name, $row->geojsonstr);
		$tmp->setRegionId($row->regionid);
		array_push($result, $tmp);
	}
	return $result;
}
