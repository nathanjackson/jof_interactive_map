<?php
/**
*
*@package jof_interactive_map
*/
/*
Plugin Name: Journey of Faith Map
Description: Plugin to add an interactive map for the JoF organization
Version: 1.0
Author: Nathan Jackson, Scott Bollinger, Dominic Desimio, Jordan Cordova, Jacob Slezak
License: MIT
*/

define( 'PLUGIN_DIR', plugin_dir_path(_FILE_) );

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

	// Add JofEvents table.
	$tbl = $wpdb->prefix . "jofevents";
	$sql = "CREATE TABLE `" . $tbl . "` (
		`eventid` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(1024) NOT NULL,
		`address` varchar(1024) NOT NULL,
		`startDate` datetime(6) NOT NULL,
		`endDate` datetime(6) NOT NULL,
		PRIMARY KEY (`eventid`)
	) " . $charset_collate . ";";
	dbDelta($sql);
}

/**
* Checks all the dates in the database for past events.  If a past event is
* found then it is deleted.
*/
function checkDates() {
	include(ABSPATH . "wp-content/plugins/jof_interactive_map/data_layer/JofEventsInterface.php");

	$events = getAllEventsFromDatabase();

	foreach($events as $evt) {
		$endTimestamp = new DateTime($evt->getEndDate());
		if($endTimestamp->getTimestamp() < time())
			removeEventFromDatabase($evt->getEventId());
	}
}

function mainMenu()
{
	echo "
	<a href=\"http://172.27.100.10/~sbollinger/wordpress/wp-content/jof_interactive_map/jof-map-plugin/markers/members_menu.html\"<button type=\"button\">JoF Members</button></a><br />
	<a href=\"http://172.27.100.10/~sbollinger/wordpress/wp-content/jof_interactive_map/jof-map-plugin/markers/regions.html\"<button type=\"button\">Regions</button></a><br />
	<a href=\"http://172.27.100.10/~sbollinger/wordpress/wp-content/jof_interactive_map/jof-map-plugin/markers/event_menu.html\"<button type=\"button\">Events</button></a><br />
	<a href=\"http://172.27.100.10/~sbollinger/wordpress/wp-content/jof_interactive_map/jof-map-plugin/markers/map.js\"<button type=\"button\">Preview Map</button></a><br />
	";
}

register_activation_hook(__FILE__, 'install');
add_action('plugins_loaded', 'checkDates');
//add_action('plugins_loaded', 'mainMenu');
add_action('admin_menu', 'plugin_menu');

function plugin_menu(){
	$page_title = 'JoF Plugin';
	$menu_title = 'JoF Plugin';
	$capability = 'manage_options';
	$menu_slug = 'jof-plugin';
	$function = 'jof';
	add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function);
}

function jof(){
	if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }
	mainMenu();
}

?>

