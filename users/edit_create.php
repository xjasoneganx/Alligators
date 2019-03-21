<?php

require_once('../../../private/initialize.php');

$action = $_GET['action'];
if ($action == 'edit') {
	if(!isset($_GET['id'])) {
		redirect_to(url_for('/staff/users/index.php'));
	}
	$id = $_GET['id'];
}


if(is_post_request()) {
	if ($action == 'edit') {
		$sql = "UPDATE users SET ";
		$sql .= "first_name='" . $_POST['first_name'] . "', ";
		$sql .= "last_name='" . $_POST['last_name'] . "', ";	
		$sql .= "email='" . $_POST['user_email'] . "', ";
		$sql .= "role='" . $_POST['role'] . "', ";
		$sql .= "active='" . $_POST['active'] . "' ";
		
		if (isset($_POST['user_password'])) {
			if ($_POST['user_password'] != "") {
				$sql .= ", password='" . $_POST['user_password'] . "' ";	
				}
			}
			
		$sql .= "WHERE id='" . $_GET['id'] . "' ";
		$sql .= "LIMIT 1";

		//echo $sql;
		
		$result = mysqli_query($db, $sql);
		if($result == true) {
			redirect_to(url_for('/staff/users/index.php'));
		} else {
			$errors = $result;
			var_dump($errors);
			die('gfdsgfdg');
		}
	}
	else {
		$first_name = $db->escape_string($_POST['first_name']);
		$last_name = $db->escape_string($_POST['last_name']);
		$email = $db->escape_string($_POST['user_email']);
		$pw = $db->escape_string($_POST['user_password']);
		$hash = $db->escape_string( md5( rand(0,1000) ) );
		$role = $db->escape_string($_POST['role']);
		$active = $db->escape_string($_POST['active']);

		$result = user_exists($email, "NEW");
		// We know user email exists if the rows returned are more than 0
		if ( $result->num_rows > 0 ) {		
			$_SESSION['message'] = 'User with this email already exists!';
			redirect_to(url_for('/staff/login-system/error.php'));
		}		
	
		if (!insert_user($first_name, $last_name, $email, $pw, $hash, $role, $active)) {
			die('Error creating a new user');
			}
		redirect_to(url_for('/staff/users/index.php'));
	}

} 
else {
	if ($action == 'edit') {
		$user = find_user_by_id($id);
		$page_title = 'Edit User';
	}
	else {
		$page_title = 'Create New User';
	}
}
include(SHARED_PATH . '/header.php');
?>


<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/users/index.php'); ?>">&laquo; Back to List</a>

  <div class="subject edit">
    <h1><?php echo ucfirst($action); ?> User</h1>

	<?php
		$target_url = '/staff/users/edit_create.php?action=' . $action;
		if ($action == 'edit') {
			$target_url .= '&id=' . h(u($id));
		}	
	?>
	
    <form id="useractions" onsubmit="return validateForm()" action="<?php echo url_for($target_url); ?>" method="post">
        <h1>User:</h1>

        <div class="attributes">
            <div class="attributes">
                <dl>
                    <dt>First Name</dt>
                    <dd><input type="text" size="60" name="first_name" value="<?php echo ($action =='edit' ? h($user['first_name']) : ''); ?>" /></dd>
                </dl>
                <dl>
                    <dt>Last Name</dt>
                    <dd><input type="text" size="60" name="last_name" value="<?php echo ($action =='edit' ? h($user['last_name']) : ''); ?>" /></dd>
                </dl>
                <dl>
                    <dt>User Email</dt>
                    <dd><input type="text" size="60" name="user_email" value="<?php echo ($action =='edit' ? h($user['email']) : ''); ?>" /></dd>
                </dl>
                <dl>
                    <dt>Password</dt>
                    <dd><input type="text" size="60" name="user_password" value="" /></dd>
                </dl>
				                <dl>
                    <dt>Verify Password</dt>
                    <dd><input type="text" size="60" name="user_password_v" value="" /></dd>
                </dl>
                <dl>
                    <dt>Active Status</dt>
                    <dd><input type="text" size="60" name="active" value="<?php echo ($action =='edit' ? h($user['active']) : ''); ?>" /></dd>
                </dl>				

				<dl>
				
				<?PHP
					if ($action == 'edit') {
						echo '<select id="ddcategory" name="role">';
						echo '<option ' . ($user['role'] == 'USER' ? 'selected' : '') . ' value="USER">User</option>';
						echo '<option ' . ($user['role'] == 'ADMIN' ? 'selected' : '') . ' value="ADMIN">Admin</option>';
						echo '<option ' . ($user['role'] == 'SUPER-ADMIN' ? 'selected' : '') . ' value="SUPER-ADMIN">Super Admin</option>';
						echo '</select>';
						}
					else {
						echo '<select id="ddcategory" name="role">';
						echo '<option selected value="USER">User</option>';
						echo '<option value="ADMIN">Admin</option>';
						echo '<option value="SUPER-ADMIN">Super Admin</option>';
						echo '</select>';
						}
				?>
                </dl>				
            </div>
        </div>

      <div id="operations">
        <input type="submit" value="Submit" />
      </div>
    </form>

  </div>

</div>

<script>
	
	function validateForm() {
    var pw1 = document.forms["useractions"]["user_password"].value;
	var pw2 = document.forms["useractions"]["user_password_v"].value;
    if (pw1 !== pw2) {
        alert("Passwords do not match");
        return false;
    }
} 
</script>


<?php include(SHARED_PATH . '/footer.php'); ?>
