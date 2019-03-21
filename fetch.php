  <?php

  $connect = mysqli_connect("localhost", "root", "", "safedb");
  $sql  = "SELECT team_id, team_name, parent_id FROM trains_and_teams";
  echo $sql;
  
  $result = mysqli_query($connect, $sql);
   echo $result;

	while ($row = mysqli_fetch_array($result)) {
	    $sub_data["id"]        = $row["team_id"];
	    $sub_data["name"]      = $row["team_name"];
	    $sub_data["parent_id"] = $row["parent_id"];
	    $sub_data["text"]      = $row["team_name"];
	    $data[]                = $sub_data;
	}

	foreach ($data as $key => &$value) {
	    $output[$value["id"]] =& $value;
	}

	foreach ($data as $key => &$value) {
	    if ($value["parent_id"] && isset($output[$value["parent_id"]])) {
	        $output[$value["parent_id"]]["nodes"][] =& $value;
	    }
	}

	foreach ($data as $key => &$value) {
	    if ($value["parent_id"] && isset($output[$value["parent_id"]])) {
	        unset($data[$key]);
	    }
	}
	echo json_encode($data);
	$result->close();

	echo '<pre>';
	print_r($data);
	echo '</pre>';

?>