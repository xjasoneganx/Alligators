<?php

  $nav_selected = "PIPLANNING";
  $left_buttons = "YES"; 
  $left_selected = "TREND";


  include("./nav.php");
  global $db;

  ?>

  <img src="images/work_in_progress.jpg" height = "100" width = "100"/>
  <h3> Capacity Summary </h3>
  <br> * What is the capacity of each ART in the past Program Increment (PI)?
  <br> * How is the trend looking?
  <br> * What is the total capacity of all ARTs at each PI?
  <br> * We will show a comparison / trend and summary on this page.
  


<?php include("./footer.php"); ?>
