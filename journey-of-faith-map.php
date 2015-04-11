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

function membersManagementPage() {
	if(!current_user_can( 'manage_options' ) ) {
		wp_die(__('You do not have sufficient permissions to access this page.'));
	}

	include(ABSPATH . "wp-content/plugins/jof_interactive_map/data_layer/JofMembersInterface.php");
	$members = getAllMembersFromDatabase();

	?>
	<h2>Interactive Map Members Management</h2><br>
	<form action=<?php echo plugins_url() . '/jof_interactive_map/uploadMembers.php'; ?> method='post' enctype="multipart/form-data">
		<h4>Data Import</h4>
		<fieldset>
			File: <input type='file' title='spreadsheet' name='file'><br>
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

function eventsManagementPage()
{
	if(!current_user_can( 'manage_options' ) ) {
		wp_die(__('You do not have sufficient permissions to access this page.'));
	}
	include(ABSPATH . "wp-content/plugins/jof_interactive_map/data_layer/JofEventsInterface.php");
	$events = getAllEventsFromDatabase();
	?>
		<h2>Interactive Map Events Management</h2><br>
		<form action=<?php echo plugins_url() . '/jof_interactive_map/uploadEvents.php'; ?> method='post' enctype="multipart/form-data">
		<h4>Data Import</h4>
		<fieldset>
			File: <input type='file' title='spreadsheet' name='file'><br>
			<input type='submit' name='Import' value='Import'>
		</fieldset>
	</form><br>
	<form action=<?php echo plugins_url() . '/jof_interactive_map/addEvent.php'; ?> method="post">
		<fieldset>
			<h4>Add Event</h4>
			Name: <input type="text" name="name"><br>
			Address: <input type="text" name="address"><br /><br />
			Only Use Numbers <br />
			Begin Month: <input type="text" name="bmonth"><br>
			Begin Day: <input type="text" name="bday"><br>
			Begin Year: <input type="text" name="byear"><br>
			Begin Hour: <input type="text" name="bhour"><br>
			Begin Minute: <input type="text" name="bminute"><br>
			End Month: <input type="text" name="emonth"><br>
			End Day: <input type="text" name="eday"><br>
			End Year: <input type="text" name="eyear"><br>
			End Hour: <input type="text" name="ehour"><br>
			End Minute: <input type="text" name="eminute"><br>
		<input type="submit" name="add" value="Add">
		</fieldset>
		</form><br />
		<form id='eventUpdateForm' action=<?php echo plugins_url() . '/jof_interactive_map/saveEvent.php'; ?> method='post'>
			<h4>Edit or Remove Events</h4>
			<fieldset>
				<select multiple id='selected_event' name='selected_event' width='300' style='width: 300px' onChange='fillUpdateForm(this.selectedIndex)'>
					<?php
						foreach($events as $event) {
							$id = $event->getMemberId();
							$name = $event->getName();
							echo "<option value=\"$id\">$name</option>";
						}
					?>
				</select><br>
				Name: <input id='name' type="text" name="name"><br>
				Address: <input id='address' type="text" name="address"><br />
				Start Date: <input id='sdate' type="text" name="sdate"><br>
				End Date: <input id='edate' type="text" name="edate"><br>
				<input type='submit' name='Update' value='Modify'>
				<input type='submit' name='Update' value='Delete'>
			<script>
				var events = JSON.parse('<?php echo json_encode($events); ?>');
				function fillUpdateForm(idx) {
					document.getElementById('eventUpdateForm').name.value = events[idx].name;
					document.getElementById('eventUpdateForm').address.value = event[idx].address;
					document.getElementById('eventUpdateForm').sdate.value = events[idx].startdate;
					document.getElementById('eventUpdateForm').edate.value = events[idx].enddate;
				}
			</script>
		</fieldset>
	</form><br>

	<?php
}

function regionsManagementPage()
{
	if(!current_user_can( 'manage_options' ) ) {
		wp_die(__('You do not have sufficient permissions to access this page.'));
	}
	include(ABSPATH . "wp-content/plugins/jof_interactive_map/data_layer/JofRegionsInterface.php");
	$regions = getAllRegionsFromDatabase();
	?>
	<h2>Interactive Map Regions Management</h2><br>
	<form action=<?php echo plugins_url() . '/jof_interactive_map/uploadRegions.php'; ?> method='post' enctype="multipart/form-data">
		<h4>Data Import</h4>
		<fieldset>
			File: <input type='file' title='geojson' name='file'><br>
			<input type='submit' name='Import' value='Import'>
		</fieldset>
	</form><br>
	<form action=<?php echo plugins_url() . '/jof_interactive_map/addRegion.php'; ?> method="post" id="addRegion">
		<fieldset>
			<h4>Add Region</h4>
			Name: <input type="text" name="name"><br>
			GeoJSON: copy and paste the GeoJSON code generated here:
			<a href="http://geojson.io" target="_blank"><button type="button">Draw Region</button></a><br />
			<textArea rows="10" cols="75" wrap="soft" form="addRegion" name="geojson"></textArea><br />
		<input type="submit" name="add" value="Add">
		</fieldset>
		</form><br />
		<form id='regionUpdateForm' action=<?php echo plugins_url() . '/jof_interactive_map/regionsHandler.php'; ?> method='post'>
			<h4>Edit or Remove Regions</h4>
			<fieldset>
				<select multiple id='selected_region' name='selected_region' width='300' style='width: 300px' onChange='fillUpdateForm(this.selectedIndex)'>
					<?php
						foreach($regions as $region) {
							$id = $event->getRegionId();
							$name = $event->getName();
							echo "<option value=\"$id\">$name</option>";
						}
					?>
				</select><br>
				Name: <input id='name' type="text" name="name"><br>
				Coordinates: <input id='geojson' type="text" name="geojson"><br />
				<input type='submit' name='Update' value='Modify'>
				<input type='submit' name='Update' value='Delete'>
			<script>
				var regions = JSON.parse('<?php echo json_encode($regions); ?>');
				function fillUpdateForm(idx) {
					document.getElementById('regionUpdateForm').name.value = events[idx].name;
					document.getElementById('regionUpdateForm').geojson.value = event[idx].geojson;
				}
			</script>
		</fieldset>
	</form><br>
	<?php
}

function map_management_hook() {
	add_management_page('Interactive Map Members Manager',
		'Interactive Map Members Manager', 'manage_options', 'members-manager',
		'memebersManagementPage');
	add_management_page('Interactive Map Events Manager',
		'Interactive Map Events Manager', 'manage_options', 'events-manager',
		'eventsManagementPage');
	add_management_page('Interactive Map Regions Manager',
		'Interactive Map Regions Manager', 'manage_options', 'regions-manager',
		'regionsManagementPage');
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

