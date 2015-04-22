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
		`theme` varchar(1024) NOT NULL,
		`address` varchar(1024) NOT NULL,
		`latdeg` real NOT NULL,
		`londeg` real NOT NULL,
		`startDate` datetime(6) NOT NULL,
		`endDate` datetime(6) NOT NULL,
		PRIMARY KEY (`eventid`)
	) " . $charset_collate . ";";
	dbDelta($sql);

	// Add JofChapels table.
	$tbl = $wpdb->prefix . "jofchapels";
	$sql = "CREATE TABLE `" . $tbl . "` (
		`chapelid` int(11) NOT NULL AUTO_INCREMENT,
		`address` varchar(1024) NOT NULL,
		`latdeg` real NOT NULL,
		`londeg` real NOT NULL,
		`installation` varchar(1024) NOT NULL,
		`name` varchar(1024) NOT NULL,
		`cwocEmail` varchar(1024),
		`phoneNumber` varchar(12),
		`parishCoordEmail` varchar(1024),
		PRIMARY KEY  (`chapelid`)
	) " . $charset_collate . ";";
	dbDelta($sql);

}

function membersManagementPage() {
	if(!current_user_can( 'manage_options' ) ) {
		wp_die(__('You do not have sufficient permissions to access this page.'));
	}

	include_once(ABSPATH . "wp-content/plugins/jof_interactive_map/data_layer/JofMembersInterface.php");
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
	include_once(ABSPATH . "wp-content/plugins/jof_interactive_map/data_layer/JofEventsInterface.php");
	$events = getAllEventsFromDatabase();
	?>
		<h2>Interactive Map Events Management</h2><br>
	<form action=<?php echo plugins_url() . '/jof_interactive_map/addEvent.php'; ?> method="post">
		<fieldset>
			<h4>Add Event</h4>
			Name: <input type="text" name="name"><br>
			Theme: <input type="text" name="theme"><br>
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
							$id = $event->getEventId();
							$name = $event->getName();
							echo "<option value=\"$id\">$name</option>";
						}
					?>
				</select><br>
				Name: <input id='name' type="text" name="name"><br>
				Theme: <input id='theme' type="text" name='theme'><br>
				Address: <input id='address' type="text" name="address"><br />
				Start Date: <input id='sdate' type="datetime" name="sdate"><br>
				End Date: <input id='edate' type="datetime" name="edate"><br>
				<input type='submit' name='Update' value='Modify'>
				<input type='submit' name='Update' value='Delete'>
			<script>
				var events = JSON.parse('<?php echo json_encode($events); ?>');
				function fillUpdateForm(idx) {
					document.getElementById('eventUpdateForm').name.value = events[idx].name;
					document.getElementById('eventUpdateForm').theme.value = events[idx].theme;
					document.getElementById('eventUpdateForm').address.value = events[idx].address;
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
	include_once(ABSPATH . "wp-content/plugins/jof_interactive_map/data_layer/JofRegionsInterface.php");
	$regions = getAllRegionsFromDatabase();
	?>
	<h2>Interactive Map Regions Management</h2>
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
							$id = $region->getRegionId();
							$name = $region->getName();
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
					document.getElementById('regionUpdateForm').name.value = regions[idx].name;
					document.getElementById('regionUpdateForm').geojson.value = regions[idx].geojson;
				}
			</script>
		</fieldset>
	</form><br>
	<?php
}

function chapelsManagementPage()
{
	if(!current_user_can( 'manage_options' ) ) {
		wp_die(__('You do not have sufficient permissions to access this page.'));
	}
	include_once(ABSPATH . "wp-content/plugins/jof_interactive_map/data_layer/JofChapelsInterface.php");
	$chapels = getAllChapelsFromDatabase();
	?>
		<h2>Interactive Map Chapels Management</h2><br>
		<form action=<?php echo plugins_url() . '/jof_interactive_map/uploadChapels.php'; ?> method='post' enctype="multipart/form-data">
		<h4>Data Import</h4>
		<fieldset>
			File: <input type='file' title='spreadsheet' name='file'><br>
			<input type='submit' name='Import' value='Import'>
		</fieldset>
	</form><br>
	<form action=<?php echo plugins_url() . '/jof_interactive_map/addChapel.php'; ?> method="post">
		<fieldset>
			<h4>Add Chapel</h4>
			Name: <input type="text" name="name"><br>
			Address: <input type="text" name="address"><br />
			Installation: <input type="text" name="installation"><br>
			CWOC E-Mail: <input type="text" name="cwocEmail"><br>
			Phone #: <input type="text" name="phone"><br>
			Parish E-Mail: <input type="text" name="parishEmail"><br>
		<input type="submit" name="Add" value="Add">
		</fieldset>
		</form><br />
		<form id='chapelUpdateForm' action=<?php echo plugins_url() . '/jof_interactive_map/editChapel.php'; ?> method='post'>
			<h4>Edit or Remove Chapel</h4>
			<fieldset>
				<select multiple id='selected_chapel' name='selected_chapel' width='300' style='width: 300px' onChange='fillUpdateForm(this.selectedIndex)'>
					<?php
						foreach($chapels as $chapel) {
							$id = $chapel->getChapelId();
							$installation = $chapel->getInstallation();
							$name = $chapel->getName();
							echo "<option value=\"$id\">$installation - $name</option>";
						}
					?>
				</select><br>
				Name: <input id="name" type="text" name="name"><br>
				Address: <input id="address" type="text" name="address"><br />
				Installation: <input id="installation" type="text" name="installation"><br>
				CWOC E-Mail: <input id="cwocEmail" type="text" name="cwocEmail"><br>
				Phone #: <input id="phone" type="text" name="phone"><br>
				Parish E-Mail: <input id="parishEmail" type="text" name="parishEmail"><br>
				<input type='submit' name='Update' value='Modify'>
				<input type='submit' name='Update' value='Delete'>
			<script>
				var chapels = <?php echo json_encode($chapels) ?>;
				function fillUpdateForm(idx) {
					document.getElementById('chapelUpdateForm').name.value = chapels[idx].name;
					document.getElementById('chapelUpdateForm').address.value = chapels[idx].address;
					document.getElementById('chapelUpdateForm').installation.value = chapels[idx].installation;
					document.getElementById('chapelUpdateForm').cwocEmail.value = chapels[idx].cwocEmail;
					document.getElementById('chapelUpdateForm').phone.value = chapels[idx].phoneNumber;
					document.getElementById('chapelUpdateForm').parishEmail.value = chapels[idx].parishCoordEmail;
				}
			</script>
		</fieldset>
	</form><br>

	<?php
}

function map_management_hook() {
	add_management_page('Interactive Map Members Manager',
		'Interactive Map Members Manager', 'manage_options', 'members-manager',
		'membersManagementPage');
	add_management_page('Interactive Map Chapel Manager',
		'Interactive Map Chapel Manager', 'manage_options', 'chapels-manager',
		'chapelsManagementPage');
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
	include_once(ABSPATH . "wp-content/plugins/jof_interactive_map/data_layer/JofEventsInterface.php");

	$events = getAllEventsFromDatabase();

	foreach($events as $evt) {
		$endTimestamp = new DateTime($evt->getEndDate());
		if($endTimestamp->getTimestamp() < time())
			removeEventFromDatabase($evt->getEventId());
	}
}

class Map_Widget extends WP_Widget {
        public function __construct() {
                parent::__construct('map_widget', __('Map Widget', 'text_domain'),
                        array( 'description' => __('Interactive Map Widget', 'text_domain')));
        }

        public function widget($args, $instance) {
		include_once(ABSPATH . "wp-content/plugins/jof_interactive_map/data_layer/JofMembersInterface.php");
		include_once(ABSPATH . "wp-content/plugins/jof_interactive_map/data_layer/JofChapelsInterface.php");

		$members = getAllMembersFromDatabase();
		$chapels = getAllChapelsFromDatabase();
                ?>
		<script src="http://maps.google.com/maps/api/js?sensor=false"
			type="text/javascript"></script>
		<div id="map" style="width: 800px; height: 600px;"></div>
		<script>

		function createChapelDiv(str) {
			var content = '<div id="content"><h1>' + str + '</h1></div>';
			return content;
		}

		function createContent(title, address, email, skills) {
			var infoContent = '<div id ="content">' +
                        '<p>\nTitle: ' + title + '\n</p>' +
                        '<p>\nLocation: ' + address + '\n</p>' +
                        '<p>\nSpecialty: ' + email + '\n</p>' +
                        '<p>\nContact: ' + skills + '\n</p>' +
                        '</div>';
                	return infoContent;
            	}

		var infowindow = new google.maps.InfoWindow();

		var members = JSON.parse('<?php echo json_encode($members); ?>');
		var chapels = <?php echo json_encode($chapels) ?>;

		var map = new google.maps.Map(document.getElementById('map'), {
      			zoom: 10,
      			center: new google.maps.LatLng(39.949649, -75.736879),
      			mapTypeId: google.maps.MapTypeId.ROADMAP
    		});

		if(navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
				var pos = new google.maps.LatLng(position.coords.latitude,
					position.coords.longitude);
				map.setCenter(pos);
			}, function() {
				handleNoGeolocation(true);
			});
		}
		else {
			handleNoGeolocation(false);
		}

		for(member of members) {
			var coord = new google.maps.LatLng(member.latdeg, member.londeg);
			var marker = new google.maps.Marker({
				position: coord,
				map: map,
				title: member.title
			});

			google.maps.event.addListener(marker,'click', (function(marker, member) {
				return function() {
					infowindow.setContent("<h3>" + member.title + "</h3>"
					+ "<p>" + member.address
					+ (member.skills != "" ? "<br>Specialty: " + member.skills: "")
					+ "<br>E-Mail: " + member.email
					+ "</p>");
					infowindow.open(map, marker);
				}
			})(marker, member));

		}

		for(chapel of chapels) {
			var coord = new google.maps.LatLng(chapel.latdeg, chapel.londeg);
			var marker = new google.maps.Marker({
				position: coord,
				map: map,
				title: chapel.name
			});

			google.maps.event.addListener(marker,'click', (function(marker, chapel) {
				return function() {
					infowindow.setContent("<h3>Chapel: " + chapel.name + "</h3>"
					+ "<p>" + chapel.installation
					+ "<br>" + chapel.address
					+ (chapel.cwocEmail != "" ? "<br>CWOC E-mail: " + chapel.cwocEmail : "")
					+ (chapel.phoneNumber != "" ? "<br>Phone: " + chapel.phoneNumber : "")
					+ (chapel.parishCoordEmail != "" ? "<br>Parish Coordinator E-mail: " + chapel.parishCoordEmail : "")
					+ "</p>");
					infowindow.open(map, marker);
				}
			})(marker, chapel));

/*			google.maps.event.addListener(marker, 'click', (function(marker, content, infoWindow) {
				return function() {
					infoWindow.setContent(content);
					infoWindow.open(map, marker);
				};
			})(marker, chapel.name, infoWindows[marker]); */
		}
		</script>
                <?php
        }
}

register_activation_hook(__FILE__, 'install');
add_action('plugins_loaded', 'checkDates');
add_action( 'admin_menu', 'map_management_hook' );
add_action( 'widgets_init', function() {
	register_widget('Map_Widget');
});

?>
