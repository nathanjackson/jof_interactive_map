<?php

include_once('JofEvent.php');

/**
* Adds the specified event to the Wordpress database.  If the event already
* exists, it is updated.
*/
function addEventToDatabase($event) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'jofevents';

	$data = array('eventid' => $event->getEventId(),
		'name' => $event->getName(),
		'address' => $event->getAddress(),
		'latdeg' => $event->getLatDeg(),
		'londeg' => $event->getLonDeg(),
		'startDate' => $event->getStartDate(),
		'endDate' => $event->getEndDate());

	if($event->getEventId() == null) {
		$wpdb->insert($table_name, $data);
	}
	else {
		$wpdb->update($table_name, $data,
			array('eventid' => $event->getEventId()));
	}
}

/**
* Removes the event specified by an id from the Wordpress database.
*/
function removeEventFromDatabase($id) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'jofevents';
	$wpdb->query(
		$wpdb->prepare("DELETE FROM $table_name WHERE eventid = %d;",
			$id));
}

/**
* Gets the event specified by an id from the Wordpress database.
*/
function getEventFromDatabase($id) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'jofevents';
	$res = $wpdb->get_row(
		"SELECT eventid,
			name,
			address,
			latdeg,
			londeg,
			startDate,
			endDate FROM $table_name WHERE eventid = $id;");
	$tmp = new JofEvent($res->name, $res->address, $row->latdeg, $row->londeg,
		$res->startDate, $res->endDate);
	$tmp->setEventId($res->eventid);
	return $tmp;
}

/**
* Returns all events from the database.
*/
function getAllEventsFromDatabase() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'jofevents';
	$rows = $wpdb->get_results(
		"SELECT eventid,
			name,
			address,
			latdeg,
			londeg,
			startDate,
			endDate FROM $table_name;");
	$result = array();
	foreach($rows as &$row) {
		$tmp = new JofEvent($row->name, $row->address, $row->latdeg,
			$row->londeg, $row->startDate, $row->endDate);
		$tmp->setEventId($row->eventid);
		array_push($result, $tmp);
	}
	return $result;
}
