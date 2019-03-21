<?php

session_start();

$mysqli = new mysqli("", "root", "", "ics325safedb");
if($mysqli->connect_error) {
  exit('Could not connect');
}

// require 'db_credentials.php';
// global $db;


// define variables and constants
$piid = $_SESSION['piid'];

echo 'The chosen PIID is ' . $piid . '.';


$sql = "SELECT sequence,iteration_id
				FROM `cadence`
				WHERE PI_id = $piid";

$result = $mysqli->fetch_assoc($sql);

if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		echo $row['sequence'] . " " . $row['iteration_id'] . "<br />";
	}
}
$mysqli->close();
?>