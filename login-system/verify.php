<?php
require_once('../initialize.php');
/* Verifies registered user email, the link to this page
   is included in the register.php email message
*/
global $db;

echo '<h1>verify.php</h1>';
	if (DEBUG_MODE == 'ONxx') {
		echo 'DEBUG MODE: ' . dirname(__FILE__).'<br/>';
		echo 'A ' . isset($_GET['email']) . '<br/>';
		echo 'B ' . !empty($_GET['email']) . '<br/>';
		echo 'C ' . isset($_GET['hash']) . '<br/>';
		echo 'D ' . !empty($_GET['hash']) . '<br/>';
		echo '<br/><br/><br/><br/>';
	}



// Make sure email and hash variables aren't empty
if(isset($_GET['email']) and !empty($_GET['email']) and isset($_GET['hash']) and !empty($_GET['hash']))
{
    $email = $db->escape_string($_GET['email']);
    $hash = $db->escape_string($_GET['hash']);

    // Select user with matching email and hash, who hasn't verified their account yet (active = 0)
	$result = user_exists($email, $hash);

	if (DEBUG_MODE == 'ONxx') {
		echo 'DEBUG MODE: ' . dirname(__FILE__).'<br/>';
		print_r($result);
		echo '<br/><br/><br/><br/>';
	}



    if ( $result->num_rows == 0 )
    {
        $_SESSION['message'] = "Account has already been activated or the URL is invalid!";

        header("location: error.php");
    }
    else {
        $_SESSION['message'] = "Your account has been activated!";

        // Set the user status to active (active = 1)
        if (!activate_user($email)) {
			die('ERROR ACTIVATING USER');
		}
        $_SESSION['active'] = 1;

        header("location: success.php");
    }
}
else {
    $_SESSION['message'] = "Invalid parameters provided for account verification!";
    header("location: error.php");
}
?>
