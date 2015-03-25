
	<?php
		include_once('data_layer/JofMember.php');
		include_once('data_layer/JofMembersInterface.php');
		
		if ($_POST['edit'] == 'Add')
		{
			$name = $_POST["name"];
			$title = $_POST["title"];
			$address = $_POST["address"];
			$email = $_POST["contact"];
			$skills = $_POST["specialty"];
			$member = new JofMember($name, $title, $address, $email, $skills);
			addMemberToDatabase($member);
		}
		else if ($_POST['edit'] == 'Edit') 
		{
			$change = $_POST['newValue'];
			$id = $_POST['editMember'];
			$member = getMemberFromDatabase($id) 
			switch ($_POST['fields']) 
			{
			case "name":
				$member->setName($change);
				break;
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
			}
			addMemberToDatabase($member) 
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

	?>
