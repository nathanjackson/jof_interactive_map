<?php
include_once('../../../wp-load.php');
include_once('data_layer/JofMembersInterface.php');
		
if($_POST['Update'] == 'Modify')
{
	$member = new JofMember($_POST['title'], $_POST['address'],
		$_POST['specialty'], $_POST['email']);
	$member->setMemberId($_POST['selected_member']);
	addMemberToDatabase($member);
}
else if($_POST['Update'] == 'Delete')
{
	$id = $_POST['selected_member'];
	removeMemberFromDatabase($id);
}

echo "<meta http-equiv=\"refresh\" content=\"0;url=".$_SERVER['HTTP_REFERER']."\"/>";

?>
