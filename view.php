<?php
  $nav_selected = "HOME";
  $left_buttons = "NO";
  $left_selected = "";

  include("view_functions.php");
  include("nav.php");
  global $db;

  $id = $_GET["id"];
 ?>

<html>

	<body>
		<?php
			 $id = $_GET["id"];

		    $type = get_type_based_on_id($id);

			switch($type){
				case 'emp':
					emp_query($id);
					break;
				case 'at':
					at_query($id);
					break;
				case 'art':
					art_query($id);
					break;
				case 'st':
					st_query($id);
					break;
				default:
					// Stuff
					break;
			}

		?>
	</body>
</html>
