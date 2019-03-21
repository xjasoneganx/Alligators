<?php

  $nav_selected = "TRAINS";
  $left_buttons = "YES";
  $left_selected = "GRID";

  include("./nav.php");
  global $db;

  if(($_GET)){
      $ART = urldecode($_GET["art"]);
  } else {
    $ART = 'none';
  }

  ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title id="Description">Agile Release Trains & Teams: Size </title>

   <link rel="stylesheet" href="styles/main_style.css" type="text/css">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" href="styles/custom_nav.css" type="text/css">
</head>


<?php

 // get the count of Teams for each train
  $qry = 'select parent_name, type, count(*) from trains_and_teams where type="AT" group by parent_name';
  $result = $db->query($qry);

  $rows = array();
  $table = array();
  $table['cols'] = array(

    // Labels for your chart, these represent the column titles.
    /*
        note that one column is in "string" format and another one is in "number" format
        as pie chart only required "numbers" for calculating percentage
        and string will be used for Slice title
    */

    array('label' => 'ART Name', 'type' => 'string'),
    array('label' => 'Size of ART', 'type' => 'number')

);

    $array = array();

  while ($row = mysqli_fetch_row($result)) {
    $array[$row[0]] = $row[2];
  }


    /* Extract the information from $result */
    foreach($array as $key => $value) {

      $temp = array();

      // The following line will be used to slice the Pie chart

      $temp[] = array('v' => (string) $key);

      // Values of the each slice

      $temp[] = array('v' => (int) $value);
      $rows[] = array('c' => $temp);
    }

$table['rows'] = $rows;

// convert data into JSON format
$jsonTable = json_encode($table);


?>
<body>
  <h3 style = "color: #01B0F1;">Trains -> Grid:</h3>

  <div align="center">
   <input type ="submit" name ="change_charts" value ="Bar Chart" id = "change_charts">
 </div>

    <!--this is the div that will hold the pie chart-->
    <div id="chart_div" align="center"></div>
  </body>

    <!--Load the Ajax API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">


  // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);

    function drawChart() {

      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(<?=$jsonTable?>);
      var options = {
          title: 'ART Size by The Number of Teams',
          is3D: 'true',
          width: 800,
          height: 600,
          pieSliceText: 'value'
        };
      // Instantiate and draw our chart, passing in some options.
      // Do not forget to check your div ID

    $('#change_charts').click(function(){

    if ($(this).val() == "Pie Chart") {
      var piechart = new google.visualization.PieChart(document.getElementById('chart_div'));
            piechart.draw(data, options);
      $("#change_charts").prop('value', 'Bar Chart');
    } else {
      var barchart = new google.visualization.BarChart(document.getElementById('chart_div'));
            barchart.draw(data, options);
      $("#change_charts").prop('value', 'Pie Chart');
    }

      });

      var piechart = new google.visualization.PieChart(document.getElementById('chart_div'));
      piechart.draw(data, options);

    }

    </script>



</html>

<?php include("./footer.php"); ?>
