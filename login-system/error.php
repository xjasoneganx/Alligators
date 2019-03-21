<?php
/* Displays all error messages */
require_once('../initialize.php');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Error</title>
  <?php include 'css/css.html'; ?>
</head>
<body>
<div class="form">
    <h1>Error</h1>
    <p>
    <?php 
	// echo $_SESSION['message'] . '<br/>';
	// echo isset($_SESSION['message']) . '<br/>';
	// echo !empty($_SESSION['message']) . '<br/>';

    if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ): 
        echo $_SESSION['message'];    
    else:
        header( "location: ../../index/php");
    endif;
    ?>
    </p>     
    <a href="../index.php"><button class="button button-block"/>Home</button></a>
	
</div>
</body>
</html>
