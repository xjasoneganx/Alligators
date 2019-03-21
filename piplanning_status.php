<?php




$nav_selected = "PIPLANNING";
$left_buttons = "YES";
$left_selected = "STATUS";

include("./nav.php");
global $db;

date_default_timezone_set('America/Chicago');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ics325safedb";


// Create connection	
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$piidDefault = $conn->query("SELECT PI_id,MIN(end_date) FROM cadence WHERE end_date >= CURDATE() GROUP BY PI_id LIMIT 1");
$piidResult = $conn->query("SELECT DISTINCT PI_id FROM cadence WHERE PI_id != ''");

if ($piidDefault->num_rows > 0) {
  while($row = $piidDefault->fetch_assoc()) {
    $DefaultPiid = $row["PI_id"];
  }
} else {
  $DefaultPiid = "0 results";
}

$query3 = $conn->query("SELECT * FROM preferences");
$preferences = array();
while($line = mysqli_fetch_assoc($query3)){
    $preferences[] = $line;
}

// Associative arrays in PHP! Major learning curve... Use 'keys' in single quotes for element addressing...

$baseURL = $preferences[27]['value'];     // The 28th DB record corresponds to 27 in the array

$_SESSION['baseURL'] = $baseURL;	// A kludge so it can be passed to the PHP form generator

// Check for the existence of the cookie 'art', and if it exists, populate
// the $defaultArtID var with its contents. If it doesn't exist, use the field from
// the 'preferences' database.

$cookie_name = 'art';
if(isset($_COOKIE[$cookie_name])) {
    $defaultArtID = $_COOKIE[$cookie_name];
} else { 
    $defaultArtID = $preferences[28]['value'];  // The 29th DB record corresponds to 28 in the array
}

?>

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

<script src="scripts/script.js" defer></script>

<body>
<h2>
	Program Increment (PI) Summary Table 
</h2>

<div id="form_content">
<form action="piplanning_status_php_table.php" method="post">
	<table id="input_table">
		<tr>
			<td>Program Increment ID:</td>
			<td>

<?php
echo '<select id="piid" name="piid" value="' . $DefaultPiid . '">' . "\n";
if ($piidResult->num_rows > 0) {
  while($row = $piidResult->fetch_assoc()) {
    echo '<option value="'. $row["PI_id"] . '"';
      if ($row["PI_id"] == $DefaultPiid) {
        echo ' selected="selected">';
        	} else {
        echo '>';}
    echo $row["PI_id"] . '</option>' . "\n";
  }
} else {
    echo "0 results";
}
echo '</select>';
?>

			</td>
		</tr>
		<tr>
			<td>Agile Release Train (ART):</td>
			<td>
			<div id="divArtSelector"></div>

<?php
$query0 = $conn->query("SELECT * FROM trains_and_teams WHERE trim(type)='ART'");
$query1 = $conn->query("SELECT * FROM trains_and_teams WHERE trim(type)='AT'");
$query2 = $conn->query("SELECT PI_id,iteration_id FROM cadence WHERE PI_id != ''");

// if ($DefaultArtID !== false) { 
// $query4 = $query2 = $conn->query("SELECT PI_id,iteration_id FROM cadence WHERE PI_id != ''");
// }

$ARTresults = array();
$ATresults = array();
$PIterations = array();

while($line = mysqli_fetch_assoc($query0)){
    $ARTresults[] = $line;
}

while($line = mysqli_fetch_assoc($query1)){
    $ATresults[] = $line;
}

while($line = mysqli_fetch_assoc($query2)){
    $PIterations[] = $line;
}
?>

<script>
// This is all the PHP passing of vars to JS for client-side stuff.
	var ART = JSON.parse('<?php echo json_encode($ARTresults,JSON_HEX_TAG|JSON_HEX_APOS); ?>');
	var AT = JSON.parse('<?php echo json_encode($ATresults,JSON_HEX_TAG|JSON_HEX_APOS); ?>');
	var PIterations = JSON.parse('<?php echo json_encode($PIterations,JSON_HEX_TAG|JSON_HEX_APOS); ?>')
	var Preferences = JSON.parse('<?php echo json_encode($PIterations,JSON_HEX_TAG|JSON_HEX_APOS); ?>')
	var baseURL = '<?php echo $baseURL; ?>';
	var defaultArtID = '<?php echo $defaultArtID; ?>';
</script>

			</td>
		</tr>
		<tr>
			<td>Names of the Teams:</td>
			<td>			
			<input type="text" id="namesOfTeams" name="namesOfTeams" readonly>
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				<button id="generate" type="button">Generate (JS)</button>
				<button type="submit">Generate (PHP)</button>
			</td>
		</tr>
	</table>
</form>
</div>

<div id="table_content">
</div>

</body>

</html>

<?php
$conn->close();
?>