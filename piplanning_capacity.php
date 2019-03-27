<?php

$nav_selected = "PIPLANNING";
$left_buttons = "YES"; 
$left_selected = "CAPACITY";

include("./nav.php");
global $db;

date_default_timezone_set('America/Chicago');

?>

<link rel="stylesheet" type="text/css" href="css/piplanning_capacity.css">

<h2>Capacity Calculator</h2>

<table id="table_header1">
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

function getFormVars() {
  var formVars = getCookie("formVars");
  if (formVars != '') {
    return formVars;
	} else {
		return '';
	}
}

function selectART() {
	if ( getFormVars() != '' ) {
		var defaults = JSON.parse( getFormVars() );
		var defaultArtID = defaults.chosenART;
	} else {
	  var defaultArtID = JSON.parse('<?php echo json_encode($defaultArtID,JSON_HEX_TAG|JSON_HEX_APOS); ?>');
	}
	
	
	
  var ARTresults = JSON.parse('<?php echo json_encode($ARTresults,JSON_HEX_TAG|JSON_HEX_APOS); ?>');
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
	if ( getFormVars() != '' ) {
		var defaults = JSON.parse( getFormVars() );
		var defaultAtID = defaults.chosenAT;
		}
  var ATresults = JSON.parse('<?php echo json_encode($ATresults,JSON_HEX_TAG|JSON_HEX_APOS); ?>');
  var atSelectorHTML = '';
  var artTeamID = document.getElementById("artList").value;
  var childrenATs = [];
  atSelectorHTML += '<select id="atList" name="atList">\n';
  ATresults.forEach(function(element) {
    if (element.parent_name == artTeamID) {
    	if (element.team_id.trim() == defaultAtID) {
    	  atSelectorHTML += '<option value="' + element.team_id.trim() + '" selected="selected">' + element.team_name.trim() + '</option>\n';
    	} else { 
      	atSelectorHTML += '<option value="' + element.team_id.trim() + '">' + element.team_name.trim() + '</option>\n';
      }
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
	setCookie('formVars', jsonStr, 365);
}

// COOKIES.............

function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  var expires = "expires="+d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
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

$cookie_name = 'formVars';
if(isset($_COOKIE[$cookie_name])) {
	$formVars = $_COOKIE[$cookie_name];
  $selection = json_decode($formVars, true);
  $DefaultPiid = $selection['chosenPID'];
  } else {
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
	<tr><td></td><td><input type="submit" name="submit" value="Generate"></td></tr>
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

$sql = "SELECT iteration_id
			FROM `cadence`
			WHERE PI_id = '" . $selection['chosenPID'] . "';";

$result = $db->query($sql);

if ($result->num_rows > 0) {	
	while ($row = $result->fetch_assoc()) {
		 $ATiterations[] = $row['iteration_id'];
	}
}

foreach ($ATiterations as $element) {

echo <<< EOT
<table border="1">
	<tr>
		<td>Iteration: $element</td>
		<td>Iteration Capacity</td>
		<td><div id="iteration_capacity"></div></td>
	</tr>
</table>
<table border="1">
			<tr><td>Last Name</td><td>First Name</td><td>Role</td><td>% Velocity Available</td><td>Days Off</td><td>Story Points</td></tr>
			<tr><td>Last Name</td><td>First Name</td><td>Role</td><td>% Velocity Available</td><td>Days Off</td><td>Story Points</td></tr>
			<tr><td>Last Name</td><td>First Name</td><td>Role</td><td>% Velocity Available</td><td>Days Off</td><td>Story Points</td></tr>
			<tr><td>Last Name</td><td>First Name</td><td>Role</td><td>% Velocity Available</td><td>Days Off</td><td>Story Points</td></tr>
			<tr><td>Last Name</td><td>First Name</td><td>Role</td><td>% Velocity Available</td><td>Days Off</td><td>Story Points</td></tr>
			<tr><td>Last Name</td><td>First Name</td><td>Role</td><td>% Velocity Available</td><td>Days Off</td><td>Story Points</td></tr>
			<tr><td>Last Name</td><td>First Name</td><td>Role</td><td>% Velocity Available</td><td>Days Off</td><td>Story Points</td></tr>
</table>
EOT;

}









 		
// *************************************************************************************
// WHERE ALL THE TABLE DATA GETS GENERATED
// *************************************************************************************	
		
  } else {
    // Display the Form and the Submit Button AND NOTHING ELSE (Leave this area alone)
}  





?>




<script>
document.addEventListener("DOMContentLoaded", selectART);
document.addEventListener("DOMContentLoaded", selectAT);
/* 
window.onbeforeunload = function() {
  document.cookie = "formVars=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
};
 */
</script>

<?php
$db->close();
?>
