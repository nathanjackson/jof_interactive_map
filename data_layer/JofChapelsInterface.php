<?php

include_once('JofChapel.php');

/**
* Adds the specified chapel to the Wordpress database.  If the chapel already
* exists, it is updated.
*/
function addChapelToDatabase($chapel) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'jofchapels';

	$data = array('chapelid' => $chapel->getChapelId(),
		'address' => $chapel->getAddress(),
		'latdeg' => $chapel->getLatDeg(),
		'londeg' => $chapel->getLonDeg(),
		'installation' => $chapel->getInstallation(),
		'name' => $chapel->getName(),
		'cwocEmail' => $chapel->getCwocEmail(),
		'phoneNumber' => $chapel->getPhoneNumber(),
		'parishCoordEmail' => $chapel->getParishCoordEmail());		

	if($chapel->getChapelId() == null) {
		$wpdb->insert($table_name, $data);
	}
	else {
		$wpdb->update($table_name, $data,
			array('chapelid' => $chapel->getChapelId()));
	}
}

/**
* Removes the chapel specified by an id from the Wordpress database.
*/
function removeChapelFromDatabase($id) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'jofchapels';
	$wpdb->query(
		$wpdb->prepare("DELETE FROM $table_name WHERE chapelid = %d;",
			$id));
}

/**
* Gets the chapel specified by an id from the Wordpress database.
*/
function getChapelFromDatabase($id) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'jofchapels';
	$res = $wpdb->get_row(
		"SELECT chapelid,
			address,
			latdeg,
			londeg,
			installation,
			name,
			cwocEmail,
			phoneNumber,
			parishCoordEmail FROM $table_name WHERE chapelid = $id;");
	$tmp = new JofChapel($res->address, $res->latdeg, $res->londeg,
		$res->installation, $res->name, $res->cwocEmail,
		$res->phoneNumber, $res->parishCoordEmail);
	$tmp->setChapelId($res->chapelid);
	return $tmp;
}

/**
* Returns all chapels from the database.
*/
function getAllChapelsFromDatabase() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'jofchapels';
	$rows = $wpdb->get_results(
		"SELECT chapelid,
			address,
			latdeg,
			londeg,
			installation,
			name,
			cwocEmail,
			phoneNumber,
			parishCoordEmail FROM $table_name;");
	$result = array();
	foreach($rows as &$row) {
		$tmp = new JofChapel($row->address, $row->latdeg, $row->londeg,
			$row->installation, $row->name, $row->cwocEmail,
			$row->phoneNumber, $row->parishCoordEmail);
		$tmp->setChapelId($row->chapelid);
		array_push($result, $tmp);
	}
	return $result;
}
