<?php
include_once('../../../../wp-load.php');
include_once('../data_layer/JofMembersInterface.php');
		
if ($_POST['edit'] == 'Add')
{
	error_log( "here\n" );
	$title = $_POST["title"];
	$address = $_POST["address"];
	$email = $_POST["contact"];
	$skills = $_POST["specialty"];
	$member = new JofMember($title, $address, $email, $skills);
	addMemberToDatabase($member);
}
else if ($_POST['edit'] == 'Edit') 
{
	$change = $_POST['newValue'];
	$id = $_POST['editMember'];
	$member = getMemberFromDatabase($id);
	switch ($_POST['fields']) 
	{
	case "title":
		$member->setTitle($change);
		break;
	case "address":
		$member->setAddress($change);
		break;
	case "email":
		$member->setEmail($change);
		break;
	case "skills":
		$member->setSkills($change);
		break;
	default:
		echo "You somehow selected something different";
		break;
	}
	addMemberToDatabase($member);
	echo "Member updated";
}
else if ($_POST['edit'] == 'Delete') 
{
	$id = $_POST['deleteMember'];
	removeMemberFromDatabase($id);
} 
else 
{
	echo "You somehow selected something different";
}

header('Location: members_menu.php');

?>
