<?php

include_once('../../../wp-load.php');
include 'PHPExcel/Classes/PHPExcel.php';
include 'PHPExcel/Classes/PHPExcel/IOFactory.php';
include 'util.php';
include 'data_layer/JofChapelsInterface.php';

/// Move the spreadsheet to somewhere that can be read.
move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/chapels_spreadsheet.xlsx');

$workbook = PHPExcel_IOFactory::load('uploads/chapels_spreadsheet.xlsx');

if(!$workbook->sheetNameExists('CWOC Chapel Group Locations'))
{
	echo '\'CWOC Chapel Group Locations\' sheet does not exist!';
}

// parse the journey of faith members

$chapels_sheet = $workbook->getSheetByName('CWOC Chapel Group Locations');

$highestRow = $chapels_sheet->getHighestRow();
$highestCol = $chapels_sheet->getHighestColumn();

$count = 0;
$failed = 0;

// skip header
for($row=2; $row<=$highestRow; ++$row) {
	$rowdata = $chapels_sheet->rangeToArray('A' . $row . ':' . $highestCol . $row,
		NULL, TRUE, FALSE);

	$state = $rowdata[0][1];
	$installation =  $rowdata[0][2];
	$name = $rowdata[0][3];
	$street_addr = $rowdata[0][4];
	$city = $rowdata[0][5];
	$zip = $rowdata[0][7];
	$chaplain_email = $rowdata[0][8];
	$cwoc_email = $rowdata[0][9];
	$phone = $rowdata[0][10];
	$parish_coord_email = $rowdata[0][11];

	$formatted_addr = "$installation $street_addr $city $state $zip";
	$coord = null;
	try {
		$coord = get_lat_long($formatted_addr);
	} catch(Exception $e) {
		$failed++;
		echo "Could not get coordinates for row $row: $formatted_addr<br>";
		continue;
	}

	$chapel = new JofChapel($formatted_addr, $coord[0], $coord[1],
		$installation, $name, $cwoc_email, $phone, $parish_coord_email);

	addChapelToDatabase($chapel);
	$count++;
}

echo "Import complete.<br>";
echo "$count records imported successfully.<br>";
echo "$failed failed to import.<br>";

?>
<button onclick="goBack()">Return to Chapels Management</button>

<script>
function goBack() {
	window.location.href = document.referrer;
}
</script>
