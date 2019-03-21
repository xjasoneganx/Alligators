<?php

  $nav_selected = "HELP"; 
  $left_buttons = "YES"; 
  $left_selected = "BUGS"; 

  include("./nav.php");
  global $db;

  ?>


<!DOCTYPE html>
<html>
<head>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
</head>

<body>


<img src="images/work_in_progress.jpg" height = "100" width = "100"/>/>
<h4> <b> Bugs</b> </h4>

  <br> TBD: Bugs: Users can report any bugs on the system.
  <br> Status of these bugs will be reflected here.
  <br>

</body>
</html>


<?php include("./footer.php"); ?>
