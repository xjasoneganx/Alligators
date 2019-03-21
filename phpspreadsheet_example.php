<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;

$inputFileName = './csv/all_safe_tables.xlsx';

$badFile = false;

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$reader->setReadDataOnly(true);
$reader->setLoadSheetsOnly(["capacity", "cadence", "employees", "membership", "preferences", "trains_and_teams"]);
$spreadsheet = $reader->load($inputFileName);

/*
$worksheetData = $reader->listWorksheetInfo($inputFileName);
echo '<h3>Worksheet Information</h3>';
echo '<ol>';
foreach ($worksheetData as $worksheet) {
    echo '<li>', $worksheet['worksheetName'], '<br />';
    echo 'Rows: ', $worksheet['totalRows'],
         ' Columns: ', $worksheet['totalColumns'], '<br />';
    echo 'Cell Range: A1:',
    $worksheet['lastColumnLetter'], $worksheet['totalRows'];
    echo '</li>';
}
echo '</ol>';
*/
$sheetNames = [];
$columnsForCapacity = [];
$columnsForCadence = [];
$columnsForEmployees = [];
$columnsForMembership = [];
$columnsForPreferences = [];
$columnsForTrainsAndTeams = [];

//Check and save columns available in spreadsheet
$worksheetData = $reader->listWorksheetInfo($inputFileName);
foreach ($worksheetData as $worksheet) {
	if (!$badFile) {
		$spreadsheet->setActiveSheetIndexByName($worksheet['worksheetName']);
		array_push($sheetNames, $worksheet['worksheetName']);
		$totalColumns = $worksheet['totalColumns'];
		for ( $i = 1; $i <= $totalColumns; $i++ ) {
			if (!$badFile) {
				$columnName = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($i,1)->getValue();
				if ($worksheet['worksheetName'] == "capacity"){
					if ($columnName == "team_id" || $columnName == "team_name" || $columnName == "program_increment" || 
						$columnName == "iteration_1" || $columnName == "iteration_2" || $columnName == "iteration_3" ||
						$columnName == "iteration_4" || $columnName == "iteration_5" || $columnName == "iteration_6" || $columnName == "total") {
						
						array_push($columnsForCapacity, $columnName);
					} else {
						echo "unrecognized column";
						$badFile = true;
					}
				} else if ($worksheet['worksheetName'] == "cadence"){
					if ($columnName == "sequence" || $columnName == "program_increment" || $columnName == "iteration" || 
						$columnName == "start_date" || $columnName == "end_date" || $columnName == "duration" || $columnName == "notes") {
						
						array_push($columnsForCadence, $columnName);
					} else {
						echo "unrecognized column";
						$badFile = true;
					}
				} else if ($worksheet['worksheetName'] == "employees"){
					if ($columnName == "employee_nbr" || $columnName == "last_name" || $columnName == "first_name" || 
						$columnName == "city" || $columnName == "country" || $columnName == "manager_nbr" ||
						$columnName == "email_address" || $columnName == "cost_center" || $columnName == "status" || $columnName == "primary_team") {
						
						array_push($columnsForEmployees, $columnName);
					} else {
						echo "unrecognized column";
						$badFile = true;
					}
				} else if ($worksheet['worksheetName'] == "membership"){
					if ($columnName == "employee_nbr" || $columnName == "last_name" || $columnName == "first_name" || 
						$columnName == "team_id" || $columnName == "team_name" || $columnName == "role") {
						
						array_push($columnsForMembership, $columnName);
					} else {
						echo "unrecognized column";
						$badFile = true;
					}
				} else if ($worksheet['worksheetName'] == "preferences"){
					if ($columnName == "id" || $columnName == "name" || $columnName == "value") {
						
						array_push($columnsForPreferences, $columnName);
					} else {
						echo "unrecognized column";
						$badFile = true;
					}
				} else if ($worksheet['worksheetName'] == "trains_and_teams"){
					if ($columnName == "type" || $columnName == "team_id" || $columnName == "name" || $columnName == "parent") {
						
						array_push($columnsForTrainsAndTeams, $columnName);
					} else {
						echo "unrecognized column";
						$badFile = true;
					}
				} else {
					echo "unrecognized sheet name";
					$badFile = true;
				}
			}
		}
	}
}

if (!$badFile) {
	$loadedSheetNames = $spreadsheet->getSheetNames();
	foreach($loadedSheetNames as $sheetIndex => $loadedSheetName) {
		
		//This section prevents the removed column names from falling into the next cells in the csvs that are created.
		$spreadsheet->setActiveSheetIndexByName($loadedSheetName);
		foreach ($spreadsheet->getActiveSheet()->getRowIterator() as $row) {
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
															   // even if a cell value is not set.
															   // By default, only cells that have a value
															   // set will be iterated.
			foreach ($cellIterator as $cell) {}
		}
		$spreadsheet->setActiveSheetIndexByName($loadedSheetName);
		$spreadsheet->getActiveSheet()->removeRow(1, 1);
	}

	//Create csvs to import.
	$loadedSheetNames = $spreadsheet->getSheetNames();
	$writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
	foreach($loadedSheetNames as $sheetIndex => $loadedSheetName) {
		$writer->setSheetIndex($sheetIndex);
		$writer->save("./csv/" . $loadedSheetName.'.csv');
	}
	//Delete temp csvs when done.
	sleep(10);
	foreach($loadedSheetNames as $sheetIndex => $loadedSheetName) {
		//unlink("./csv/" . $loadedSheetName.'.csv');
	}
}

?>