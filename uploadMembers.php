<?php

include_once('../../../wp-load.php');
include 'PHPExcel/Classes/PHPExcel.php';
include 'PHPExcel/Classes/PHPExcel/IOFactory.php';
include 'util.php';
include 'data_layer/JofMembersInterface.php';

/// Move the spreadsheet to somewhere that can be read.
move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/members_spreadsheet.xlsx');

$workbook = PHPExcel_IOFactory::load('uploads/members_spreadsheet.xlsx');

if(!$workbook->sheetNameExists('Journey of Faith Team Members'))
{
	echo '\'Journey of Faith Team Members\' sheet does not exist!';
}

if(!$workbook->sheetNameExists('MCCW-Worldwide, Inc. Board Memb'))
{
	echo '\'MCCW-Worldwide, Inc. Board Memb\' sheet does not exist!';
}

// parse the journey of faith members

$jofmembers_sheet = $workbook->getSheetByName('Journey of Faith Team Members');

$highestRow = $jofmembers_sheet->getHighestRow();
$highestCol = $jofmembers_sheet->getHighestColumn();

// skip header
for($row=2; $row<=$highestRow; ++$row) {
	$rowdata = $jofmembers_sheet->rangeToArray('A' . $row . ':' . $highestCol . $row,
		NULL, TRUE, FALSE);

	$loc_city = $rowdata[0][0];
	$loc_state= $rowdata[0][1];

	$skills = $rowdata[0][3];
	$addr = "$loc_city, $loc_state";
	$coord =  get_lat_long($addr);

	$member = new JofMember('Journey of Faith Team Member', $addr, $coord[0],
		$coord[1], 'default@example.com', $skills );

	addMemberToDatabase($member);
}

// parse the board members

$boardmembers_sheet = $workbook->getSheetByName('MCCW-Worldwide, Inc. Board Memb');

$highestRow = $boardmembers_sheet->getHighestRow();
$highestCol = $boardmembers_sheet->getHighestColumn();

for($row=2; $row<=$highestRow; ++$row) {
	$rowdata = $boardmembers_sheet->rangeToArray('A' . $row . ':' . $highestCol . $row,
                NULL, TRUE, FALSE);

	$loc_city = $rowdata[0][0];
	$loc_state = $rowdata[0][1];
	$loc_country = $rowdata[0][2];
	$addr = "$loc_city $loc_state $loc_country";
	$coord = get_lat_long($addr);
	$title = $rowdata[0][3];
	$email = ($rowdata[0][4] == null) ? '' : $rowdata[0][4];

	$member = new JofMember($title, $addr, $coord[0], $coord[1], $email, '');

	addMemberToDatabase($member);
}

echo 'success';
