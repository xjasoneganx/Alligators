<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="description" content="Agile Release Train">
	<meta name="keywords" content="HTML,CSS,XML,JavaScript">
	<meta name="author" content="Aaron Kaase">
	<link rel="stylesheet" type="text/css" href="css/piplanning_status.css">
	<title>Program Increment (PI) Summary Table</title>
</head>
<body>
<h2>
	Program Increment (PI) Summary Table 
</h2>

<?php

session_start();

// define variables and constants
$piid = $art = $namesOfTeams = "";
$baseURL = $_SESSION['baseURL'];
$rowArray = array();
define("PITERATIONS", 6);

// Assign superglobals to local variables 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $piid = test_input($_POST["piid"]);
  $art = test_input($_POST["art"]);
  $namesOfTeams = explode(", ",test_input($_POST["namesOfTeams"]));
}

// Function that validates and formats data to be HTML-safe
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// Initialize header row of the rowArray 2D array
$rowArray[0] = array('No', 'Team Name');
for ( $i=1; $i <= PITERATIONS; $i++ ) {
	array_push($rowArray[0], $piid . '-' . $i);
}
array_push($rowArray[0], $piid . '-IP');

// Create display records (rows) for each teamNamesArray record
for ($i = 1; $i <= sizeof($namesOfTeams); $i++) {
		$rowArray[$i] = [$i, $namesOfTeams[$i - 1]];
		for ($j = 1; $j <= PITERATIONS; $j++) {
				array_push($rowArray[$i], $piid . '-' . $j);
		}
		array_push($rowArray[$i], $piid . '-IP');
}

// Format an HTML table from the gathered data
echo '<table id="output_table">';

// Header row
echo '<tr>';
for ($i = 0; $i <= sizeof($rowArray[0]) - 1; $i++) {
		echo '<th>' . $rowArray[0][$i] . '</th>';
}
echo '</tr>';

// Data rows
for ($i = 1; $i <= sizeof($rowArray)-1; $i++) {
		echo '<tr>';
		for ($j = 0; $j <= sizeof($rowArray[$i])-1; $j++) {
				echo '<td>';
				if ($j >= 2) {
						$htmlURL = $baseURL.'?='.$rowArray[$i][$j].'_'.$rowArray[$i][1];
						echo '<a data-tooltip="'.$htmlURL.'" href="'.$htmlURL.'" target="_blank">'.$rowArray[$i][$j].'</a>';
				} else {
						echo $rowArray[$i][$j];
				}
				echo '</td>';
		}
		echo '</tr>';	
}
echo '</table>';
?>

<form>
	<button id="startover" type="button">Start Over</button> 
</form>
<script>
	document.getElementById("startover").addEventListener("click", startover);
	
	function startover() {
	  window.location = "piplanning_status.php";
	}
</script>

</body>
</html>