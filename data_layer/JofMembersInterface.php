<?php

include_once('JofMember.php');

/**
* Adds the specified member to the Wordpress database.  If the member already
* exists, it is updated.
*/
function addMemberToDatabase($member) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'jofmembers';

	$data = array('memberid' => $member->getMemberId(),
		'title' => $member->getTitle(),
		'address' => $member->getAddress(),
		'email' => $member->getEmail(),
		'skills' => $member->getSkills());

	if($member->getMemberId() == null) {
		$wpdb->insert($table_name, $data);
	}
	else {
		$wpdb->update($table_name, $data,
			array('memberid' => $member->getMemberId()));
	}
}

/**
* Removes the member specified by an id from the Wordpress database.
*/
function removeMemberFromDatabase($id) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'jofmembers';
	$wpdb->query(
		$wpdb->prepare("DELETE FROM $table_name WHERE memberid = %d;",
			$id));
}

/**
* Gets the member specified by an id from the Wordpress database.
*/
function getMemberFromDatabase($id) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'jofmembers';
	$res = $wpdb->get_row(
		"SELECT memberid,
			title,
			address,
			email,
			skills FROM $table_name WHERE memberid = $id;");
	$tmp = new JofMember($res->title, $res->address,
		$res->email, $res->skills);
	$tmp->setMemberId($res->memberid);
	return $tmp;
}

/**
* Returns all members from the database.
*/
function getAllMembersFromDatabase() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'jofmembers';
	$rows = $wpdb->get_results(
		"SELECT memberid,
			title,
			address,
			email,
			skills FROM $table_name;");
	$result = array();
	foreach($rows as &$row) {
		$tmp = new JofMember($row->title, $row->address, $row->email,
			$row->skills);
		$tmp->setMemberId($row->memberid);
		array_push($result, $tmp);
	}
	return $result;
}
