<?php
/* Registration process, inserts user info into the database
   and sends account confirmation email message
 */
require_once('../initialize.php');
global $db;

// Set session variables to be used on profile.php page
$_SESSION['email'] = $_POST['email'];
$_SESSION['first_name'] = $_POST['firstname'];
$_SESSION['last_name'] = $_POST['lastname'];

// Escape all $_POST variables to protect against SQL injections

$first_name = $db->escape_string($_POST['firstname']);
$last_name = $db->escape_string($_POST['lastname']);
$email = $db->escape_string($_POST['email']);
$password = $db->escape_string($_POST['password']);
$hash = $db->escape_string( md5( $password ) );

// Check if user with that email already exists
$result = user_exists($email, "NEW");

	if (DEBUG_MODE == 'ON') {
		echo 'DEBUG MODE: ' . dirname(__FILE__).'<br/>';
		print_r($result);
		echo '<br/><br/><br/><br/>';
	}

// We know user email exists if the rows returned are more than 0
if ( $result->num_rows > 0 ) {

    $_SESSION['message'] = 'User with this email already exists!';
	$_SESSION['logged_in'] = false; // ensure we don't stay (sort-of) logged in
	unset ($_SESSION['email']);
	unset ($_SESSION['first_name']);
	unset ($_SESSION['last_name']);
    header("location: error.php");

}
else { // Email doesn't already exist in a database, proceed...


		$midpath_a = substr(PROJECT_PATH, strlen(SERVER_ROOT_PATH) + 1);
		$midpath_b = substr(dirname(__FILE__), strlen(SERVER_ROOT_PATH . $midpath_a) + 1);
		$suffix = '/verify.php?email='.$email.'&hash='.$hash;
		$verify_url = DEPLOYMENT_URL . $midpath_a . $midpath_b . $suffix;

		if (insert_user($first_name, $last_name, $email, $password, $hash)) {

			$_SESSION['active'] = 0; //0 until user activates their account with verify.php
			$_SESSION['logged_in'] = true; // So we know the user has logged in
			$_SESSION['message'] =

					 "Confirmation link has been sent to $email, please verify
					 your account by clicking on the link in the message!";

			// Send registration confirmation link (verify.php)
			$to      = $email;
			$subject = 'Account Verification for Physical Literacy Portal';
			$message_body = '
			Hello '.$first_name.',

			Thank you for signing up!

			Please click this link to activate your account:  ' .

			$verify_url;

			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

			mail( $to, $subject, $message_body );
			header("location: profile.php");
    }
    else {
        $_SESSION['message'] = 'Registration failed!';
        header("location: error.php");
    }
}
