<?php
/* Password reset process, updates database with new user password */
require_once('../../../private/initialize.php');
global $db;

// Make sure the form is being submitted with method="post"
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

    // Make sure the two passwords match
    if ( $_POST['newpassword'] == $_POST['confirmpassword'] ) { 

        //$new_password = password_hash($_POST['newpassword'], PASSWORD_BCRYPT);
		$new_password = $_POST['newpassword'];
        
        // We get $_POST['email'] and $_POST['hash'] from the hidden input field of reset.php form
        $email = $db->escape_string($_POST['email']);
        $hash = $db->escape_string($_POST['hash']);
        
		$sql = "UPDATE users SET password='$new_password', hash='$hash' WHERE email='$email'";

        if ( $db->query($sql) ) {
			$_SESSION['message'] = "Your password has been reset successfully!";
			header("location: success.php");    
        }
    }
    else {
        $_SESSION['message'] = "Two passwords you entered don't match, try again!";
        header("location: error.php");    
    }

}
?>