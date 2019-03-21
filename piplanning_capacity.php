<?php

$nav_selected = "PIPLANNING";
$left_buttons = "YES"; 
$left_selected = "CALCULATE";

include("./nav.php");
global $db;

date_default_timezone_set('America/Chicago');


?>

<link rel="stylesheet" type="text/css" href="css/piplanning_capacity.css">

<h2>Capacity Calculator</h2>

<table id="table_header">
	<tr>
		<td style="text-align:right"><label>Agile Release Train:</label></td><td><div id="artSelectorHTML"></div></td>
		<td rowspan="3"><div id="cap_total">Capacity Total Goes Here.</div></td>
	</tr>
	<tr>
		<td style="text-align:right"> <label>Agile Team:</label> </td><td><div id="atSelectorHTML"></div></td>
	</tr>
		
<?php
// Check for the existence of the cookie 'art', and if it exists, populate
// the $defaultArtID var with its contents. If it doesn't exist, use the field from
// the 'preferences' database.

$sql = "SELECT *
			FROM `preferences`;";
$result = $db->query($sql);

if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		 $preferences[] = $row;
	}
}

$cookie_name = 'art';
if(isset($_COOKIE[$cookie_name])) {
    $defaultArtID = $_COOKIE[$cookie_name];
} else { 
    $defaultArtID = $preferences[28]['value'];  // The 29th DB record corresponds to 28 in the array
}

// Fetch the rows in `teams_and_trains` table matching the Agile Release Train (ART) type,
// and place it as an array in the $ARTresults variable.

$sql = "SELECT *
			FROM `trains_and_teams`
			WHERE trim(type)='ART';";
$result = $db->query($sql);

if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		 $ARTresults[] = $row;
	}
}

// Fetch the rows in `teams_and_trains` table matching the Agile Tean (AT) type,
// and place it as an array in the $ATresults variable.

$sql = "SELECT *
			FROM `trains_and_teams`
			WHERE trim(type)='AT';";
$result = $db->query($sql);

if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		 $ATresults[] = $row;
	}
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return formVars()">

<script>
// Creates the drop-down for the ART selection

function selectART() {
  var ARTresults = JSON.parse('<?php echo json_encode($ARTresults,JSON_HEX_TAG|JSON_HEX_APOS); ?>');
  var defaultArtID = JSON.parse('<?php echo json_encode($defaultArtID,JSON_HEX_TAG|JSON_HEX_APOS); ?>');
  var artSelectorHTML = '';
  artSelectorHTML += '<select id="artList" name="artList" onchange="selectAT()">\n';
  ARTresults.forEach(function(element) {
    if (defaultArtID == element.team_id) {
      artSelectorHTML += '<option value="' + element.team_id.trim() + '" selected="selected">' + element.team_name.trim() + '</option>\n';
    } else {
      artSelectorHTML += '<option value="' + element.team_id.trim() + '">' + element.team_name.trim() + '</option>\n';
    }
  });
  artSelectorHTML += '</select>\n';
  document.getElementById("artSelectorHTML").innerHTML = artSelectorHTML;
}

// Creates the drop-down for the AT selection

function selectAT() {
  var ATresults = JSON.parse('<?php echo json_encode($ATresults,JSON_HEX_TAG|JSON_HEX_APOS); ?>');
  var atSelectorHTML = '';
  var artTeamID = document.getElementById("artList").value;
  var childrenATs = [];
  atSelectorHTML += '<select id="atList" name="atList">\n';
  ATresults.forEach(function(element) {
    if (element.parent_name == artTeamID) {
      atSelectorHTML += '<option value="' + element.team_id.trim() + '">' + element.team_name.trim() + '</option>\n';
    }
  });
  atSelectorHTML += '</select>\n';
  document.getElementById("atSelectorHTML").innerHTML = atSelectorHTML;
}

function formVars() {
  var obj = { chosenART: document.getElementById("artList").value,
  						chosenAT: document.getElementById("atList").value,
  						chosenPID: document.getElementById("pidList").value }; 
  var jsonStr = JSON.stringify(obj);
	document.cookie = "formVars=" + jsonStr;
}

</script> 
 
	</tr>
	<tr>
		<td style="text-align:right"><label>Program Increment ID:</label></td>
		<td> 
		<select id='pidList' name='pidList'>
<?php
// Grab the default Program Increment ID (PI ID) based on the current date
// determined by the system time of the SQL server. The PI_id chosen will
// have its end date equal to or greater than the current date.

$sql = "SELECT PI_id,MIN(end_date)
				FROM `cadence`
				WHERE end_date >= CURDATE()
				GROUP BY PI_id
				LIMIT 1;";

$result = $db->query($sql);

if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		$DefaultPiid = $row["PI_id"];
	}
}

// Grab the Program Increment IDs from the `cadence` table, and render
// an HTML drop-down for it.

$sql = "SELECT DISTINCT PI_id
				FROM `cadence`
				WHERE PI_id != '';";
				
$result = $db->query($sql);

if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
	
		echo '<option value="'. $row["PI_id"] . '"';
			if ($row["PI_id"] == $DefaultPiid) {
				echo ' selected="selected">';
				} else {
				echo '>';
			}
		echo $row["PI_id"] . '</option>' . "\n";
	}
}

?>
		</select>
		</td>
	</tr>
</table>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<input type="submit" name="submit" value="Generate">  
</form>

<div id="iterationTables"></div>

<?php
if(isset($_POST['submit'])) {
    // Enter the code you want to execute after the form has been submitted
    // Display Success or Failure message (if any) 
	$cookie_name = 'formVars';
	if(isset($_COOKIE[$cookie_name])) {
    $formVars = $_COOKIE[$cookie_name];
    }
		$selection = json_decode($formVars, true);

// *************************************************************************************
// WHERE ALL THE TABLE DATA GETS GENERATED
// *************************************************************************************	

echo '<br />';
echo 'This is where PHP will build tables... Here are the variables passed by cookie:<br />';
echo '<br />';
echo 'The chosen ART is ' . $selection['chosenART'] . '<br />';
echo 'The chosen AT is ' . $selection['chosenAT'] . '<br />';
echo 'The chosen PID is ' . $selection['chosenPID'] . '<br />';
echo '<br />';
echo 'Here you have it... The variables on the form above that is set by JavaScript
client-side is getting passed by cookie containing a JSON string to PHP, which
reloads this same page to display the new content here... but because the page now reloads,
the dang form above gets reset and will not necessarily (and most likely NOT) display the same
data as what was selected before the page reload. But this content here will reflect
the selections... So the solution is probably going to have JS read the same cookie values
as its building the form.';
 		
// *************************************************************************************
// WHERE ALL THE TABLE DATA GETS GENERATED
// *************************************************************************************	
		
  } else {
    // Display the Form and the Submit Button
}  
?>


<script>
document.addEventListener("DOMContentLoaded", selectART);
document.addEventListener("DOMContentLoaded", selectAT);
document.getElementById("generate").addEventListener("click", generate);
</script>

<?php
$db->close();
?>
