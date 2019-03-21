<?php 
/* Reset your password form, sends reset.php password link */
require_once('../../../private/initialize.php');
global $db;

// Check if form submitted with method="post"
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) 
{   
    $email = $db->escape_string($_POST['email']);
    $result = $db->query("SELECT * FROM users WHERE email='$email'");

    if ( $result->num_rows == 0 ) // User doesn't exist
    { 
        $_SESSION['message'] = "User with that email doesn't exist!";
        header("location: error.php");
    }
    else { // User exists (num_rows != 0)

        $user = $result->fetch_assoc(); // $user becomes array with user data
        
        $email = $user['email'];
        $hash = $user['hash'];
        $first_name = $user['first_name'];

		$midpath_a = substr(PROJECT_PATH, strlen(SERVER_ROOT_PATH) + 1);	 
		$midpath_b = substr(dirname(__FILE__), strlen(SERVER_ROOT_PATH . $midpath_a) + 1);	 
		$suffix = '/reset.php?email='.$email.'&hash='.$hash;
		$verify_url = DEPLOYMENT_URL . $midpath_a . $midpath_b . $suffix;		
		
        // Session message to display on success.php
        $_SESSION['message'] = "<p>Please check your email <span>$email</span>"
        . " for a confirmation link to complete your password reset!</p>";

        // Send registration confirmation link (reset.php)
        $to      = $email;
        $subject = 'PL Portal Password Reset Link';
        $message_body = '
        Hello '.$first_name.',

        You have requested password reset!

        Please click this link to reset your password: ' .
		$verify_url;
			
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        mail($to, $subject, $message_body);

        header("location: success.php");
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Reset Your Password</title>
  <?php include 'css/css.html'; ?>
</head>

<body>
    
  <div class="form">

    <h1>Reset Your Password</h1>

    <form action="forgot.php" method="post">
     <div class="field-wrap">
      <label>
        Email Address<span class="req">*</span>
      </label>
      <input type="email"required autocomplete="off" name="email"/>
    </div>
    <button class="button button-block"/>Reset</button>
    </form>
  </div>
          
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>
</body>

</html>
