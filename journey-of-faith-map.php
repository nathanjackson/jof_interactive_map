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
		`latdeg` real NOT NULL,
		`londeg` real NOT NULL,
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
		`latdeg` real NOT NULL,
		`londeg` real NOT NULL,
		`startDate` datetime(6) NOT NULL,
		`endDate` datetime(6) NOT NULL,
		PRIMARY KEY (`eventid`)
	) " . $charset_collate . ";";
	dbDelta($sql);
}

function mapManagementPage() {
	if(!current_user_can( 'manage_options' ) ) {
		wp_die(__('You do not have sufficient permissions to access this page.'));
	}

	include(ABSPATH . "wp-content/plugins/jof_interactive_map/data_layer/JofMembersInterface.php");
	$members = getAllMembersFromDatabase();

	?>
	<h2>Interactive Map Management</h2><br>
	<form>
		<h4>Data Import</h4>
		<fieldset>
			File: <input type='file' title='spreadsheet'><br>
			<input type='submit' name='Import' value='Import'>
		</fieldset>
	</form><br>
	<form action=<?php echo plugins_url() . '/jof_interactive_map/add_member.php'; ?> method='post'>
		<h4>Add New Member</h4>
		<fieldset>
			Title: <input type='text' name='title'><br>
			Address: <input type='text' name='address'><br>
			Specialty: <input type='text' name='specialty'><br>
			E-Mail: <input type='text' name='email'><br>
			<input type='submit' name='Add' value='Add'>
		</fieldset>
	</form>
	<form id='memberUpdateForm' action=<?php echo plugins_url() . '/jof_interactive_map/edit_member.php'; ?> method='post'>
		<h4>Edit or Remove Members</h4>
		<fieldset>
			<select multiple id='selected_member' name='selected_member' width='300' style='width: 300px' onChange='fillUpdateForm(this.selectedIndex)'>
			<?php
				foreach($members as $member) {
					$id = $member->getMemberId();
					$title = $member->getTitle();
					echo "<option value=\"$id\">$title</option>";
				}
			?>
			</select><br>
			Title: <input id='title' type='text' name='title'><br>
			Address: <input id='address' type='text' name='address'><br>
			Specialty: <input id='specialty' type='text' name='specialty'><br>
			E-Mail: <input id='email' type='text' name='email'><br>
			<input type='submit' name='Update' value='Modify'>
			<input type='submit' name='Update' value='Delete'>
		<script>
			var members = JSON.parse('<?php echo json_encode($members); ?>');
			function fillUpdateForm(idx) {
				document.getElementById('memberUpdateForm').title.value = members[idx].title;
				document.getElementById('memberUpdateForm').address.value = members[idx].address;
				document.getElementById('memberUpdateForm').specialty.value = members[idx].skills;
				document.getElementById('memberUpdateForm').email.value = members[idx].email;
			}
		</script>

		</fieldset>
	</form><br>
	<?php
}

function map_management_hook() {
	add_management_page('Interactive Map Manager',
		'Interactive Map Manager', 'manage_options', 'map-manager',
		'mapManagementPage');
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

register_activation_hook(__FILE__, 'install');
add_action('plugins_loaded', 'checkDates');
add_action( 'admin_menu', 'map_management_hook' );

?>

