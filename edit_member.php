<?php
include_once('../../../wp-load.php');
include_once('data_layer/JofMembersInterface.php');
		
if($_POST['Update'] == 'Modify')
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
else if($_POST['Update'] == 'Delete')
{
	$id = $_POST['selected_member'];
	removeMemberFromDatabase($id);
}

echo "<meta http-equiv=\"refresh\" content=\"0;url=".$_SERVER['HTTP_REFERER']."\"/>";

?>
