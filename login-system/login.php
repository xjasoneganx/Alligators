<?php
require_once('../initialize.php');
/* User login process, checks if user exists and password is correct */

// Escape email to protect against SQL injections

global $db;

$email = $db->escape_string($_POST['email']);
$password = $db->escape_string($_POST['password']);

// Check if user with that email already exists
$result = login_exists($email, md5( $password ));

	if (DEBUG_MODE == 'ONxx') {
		echo 'DEBUG MODE: ' . dirname(__FILE__). '\login.php<br/>';
		echo $email . '<br/>';
		print_r($result);
		echo '<br/><br/><br/><br/>';

	}

if ( $result->num_rows == 0 ){ // User doesn't exist
    $_SESSION['message'] = "User with that email doesn't exist or password is incorrect!";
    header("location: error.php");
}
else { // User exists
    $user = $result->fetch_assoc();

    //$valid_user = validate_login();

	unset($_SESSION['message']);

    if ( isset($_POST['password']) ) {
        $_SESSION['logged_in'] = true;
        $_SESSION['email'] = $user['email'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['active'] = $user['active'];
		$_SESSION['role'] = $user['role'];

		redirect_to ('./../admin_import.php');


    }
}
