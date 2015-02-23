<?php
/**
* Plugin Name: Journey of Faith Map
* Description: Plugin to add an interactive map for the JoF organization
* Version: 1.0
* Author: Nathan Jackson, Scott Bollinger, Dominic Desimio, Jordan Cordova, Jacob Slezak
* License: MIT
*/

/**
* Adds map data tables to the Wordpress database.
*/
function install() {
	global $wpdb;

	$charset_collate = $wpdb->get_charset_collate();

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	// Add JofMembers table.
	$tbl = $wpdb->prefix . "jofmembers";
	$sql = "CREATE TABLE `" . $tbl . "` (
		`memberid` int(11) NOT NULL AUTO_INCREMENT,
		`title` varchar(1024) NOT NULL,
		`address` varchar(1024) NOT NULL,
		`email` varchar(1024) NOT NULL,
		`skills` text NOT NULL,
		PRIMARY KEY  (`memberid`)
	) " . $charset_collate . ";";
	dbDelta($sql);

	// Add JofRegions table.
	$tbl = $wpdb->prefix . "jofregions";
	$sql = "CREATE TABLE `" . $tbl . "` (
		`regionid` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(1024) NOT NULL,
		`geojsonstr` text NOT NULL,
		PRIMARY KEY  (`regionid`)
	) " . $charset_collate . ";";
	dbDelta($sql);
}

register_activation_hook(__FILE__, 'install');
