<?php
  $nav_selected = "SEARCH"; 
  $left_buttons = "NO"; 
  $left_selected = ""; 

  require('view_functions.php');
  include("./nav.php");
  global $db;
?>

<!DOCTYPE html>
<html>
	<head> 
	    <title>SAFe Explorer: Search</title>
	</head>
	
	<body>
	
		<!-- Primary content goes here -->
		<?php
			$name = '';
		
			if (isset($_POST["search_term"])) {
				$name = strtolower($_POST["search_term"]);
			} 
			
			search_query($name);
			//echo '<div class="row"><pre>'.var_dump($name).'</pre></div>';
		?>		
		
	</body>
</html>