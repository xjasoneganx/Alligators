<?php
  require 'db_credentials.php';
  require_once('initialize.php');
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="styles/main_style.css" type="text/css">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!-- jQuery library -->
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="styles/custom_nav.css" type="text/css">
        <title>SAFe@ICS325 Explorer</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/css/dataTables.bootstrap.min.css" rel="stylesheet"/>
        <link rel="stylesheet" href="./mainStyleSheet.css">
    </head>

<body class="body_background">
<div id="wrap">
    <div id="nav">
        <ul>
            <a href="index.php">
              <li class="horozontal-li-logo">
              <img src ="./images/main_logo.png">
              <br/>SAFe Explorer</li>
            </a>

            <a href="trains_list.php">
              <li <?php if($nav_selected == "TRAINS"){ echo 'class="current-page"'; } ?>>
              <img src="./images/trains_and_teams.png">
              <br/>Trains</li>
            </a>

            <a href="org_list.php">
              <li <?php if($nav_selected == "ORG"){ echo 'class="current-page"'; } ?>>
                <img src="./images/org_structure.png">
                <br/>Org</li>
            </a>

            <a href="piplanning_active_pi.php">
              <li <?php if($nav_selected == "PIPLANNING"){ echo 'class="current-page"'; } ?>>
              <img src="./images/pi_planning.png">
              <br/>PI & I </li>
            </a>

            <a href="training_summary.php">
              <li <?php if($nav_selected == "TRAINING"){ echo 'class="current-page"'; } ?>>
              <img src="./images/training.png">
              <br/>Training</li>
            </a>

            <a href="reports_summary.php">
              <li <?php if($nav_selected == "REPORTS"){ echo 'class="current-page"'; } ?>>
                <img src="./images/reports.png">
                <br/>Reports</li>
            </a>

      <?php
        if (is_admin()) {
          echo '<a href="admin_import.php"><li ';
          if ($nav_selected == "ADMIN") {
            echo 'class="current-page"';
          }
          echo '><img src="./images/admin.png"><br/>Admin</li></a>';
          echo '<a href="./login-system/logout.php"><li ';
          if ($nav_selected == "LOGIN") {
            echo 'class="current-page"';
          }
          echo '><img src="./images/logout.png"><br/>Logout</li></a>';
        }
        elseif (is_logged_in()) { // USER
          echo '<a href="./login-system/logout.php"><li ';
          if ($nav_selected == "LOGIN") {
            echo 'class="current-page"';
          }
          echo '><img src="./images/logout.png"><br/>Logout</li></a>';
        }
        else {    // Guest
          echo '<a href="./login-system/index.php"><li ';
          if ($nav_selected == "LOGIN") {
            echo 'class="current-page"';
          }
          echo '><img src="./images/login.png"><br/>Login</li></a>';
        }
        ?>



        <a href="help_faqs.php">
          <li <?php if($nav_selected == "HELP"){ echo 'class="current-page"'; } ?>>
            <img src="./images/help.png">
            <br/>Help</li>
        </a>



		  <li class="horozontal-li-search" <?php if($nav_selected == "SEARCH"){ echo 'class="current-page"'; } ?>>
			   <div>
				    <input type="text" id="search_term" placeholder=" " title="Type in a name">
			   </div><br/>
		  </li>

      </ul>
      <br />
    </div>


    <table style="width:1250px">
      <tr>
        <?php
            if ($left_buttons == "YES") {
        ?>

        <td style="width: 120px;" valign="top">
        <?php
            if ($nav_selected == "TRAINS") {
                include("./left_menu_trains.php");
            } elseif ($nav_selected == "ORG") {
                include("./left_menu_org.php");
            } elseif ($nav_selected == "PIPLANNING") {
                include("./left_menu_piplanning.php");
            } elseif ($nav_selected == "ADMIN") {
                include("./left_menu_admin.php");
            } elseif ($nav_selected == "TRAINING") {
                include("./left_menu_training.php");
            } elseif ($nav_selected == "REPORTS") {
                include("./left_menu_reports.php");
            } elseif ($nav_selected == "HELP") {
                include("./left_menu_help.php");
            } else {
                include("./left_menu.php");
            }
        ?>
        </td>
        <td style="width: 1100px;" valign="top">
        <?php
          } else {
        ?>
        <td style="width: 100%;" valign="top">
        <?php
          }
        ?>
