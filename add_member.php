<?php
include_once('../../../wp-load.php');
include_once('./data_layer/JofMembersInterface.php');
		
if($_POST['Add'] == 'Add')
{
	$title = $_POST['title'];
	$address = $_POST['address'];
	$email = $_POST['email'];
	$skills = $_POST['specialty'];
	$member = new JofMember($title, $address, $email, $skills);
	addMemberToDatabase($member);
}

echo "<meta http-equiv=\"refresh\" content=\"0;url=".$_SERVER['HTTP_REFERER']."\"/>";
