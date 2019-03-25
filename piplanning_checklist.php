<?php

  $nav_selected = "PIPLANNING";
  $left_buttons = "YES"; 
  $left_selected = "CHECKLIST";


  include("./nav.php");
  global $db;

  ?>

  <img src="images/work_in_progress.jpg" height = "100" width = "100"/>
  <h3> Checklists </h3>
  [1] Create a Checklist
  [2] Edit an existing Checklist
  [3] Instantiate / Start a Checklist
  [4] Gather the status of a checklist
  
  <br>
  Process for the checklist.
  [1] Scrum Masters chose the ART
  [2] They access the checklist (eg: pi planning checklist)
  [3] They fill-in the status for their tempnam
  [4] While doing so, they can view the satus of other teams.

<?php include("./footer.php"); ?>
