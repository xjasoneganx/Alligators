<?php

require_once('../../../private/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to(url_for('/staff/users/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {

    //echo "delete user" . $id;
  $result = delete_user($id);
  redirect_to(url_for('/staff/users/index.php'));

}
  $user = find_user_by_id($id);
  
?>
<?php

//$current_user_id = h($user['id']);
//$current_username = h($user['first_name']);
//$current_user_email = h($user['last_name']);
//$current_user_email = h($user['email']);
//$current_user_role = h($user['role']);
//$current_user_active_status = h($user['active']);

?>
<?php $page_title = 'Delete User'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/users/index.php'); ?>">&laquo; Back to List</a>

  <div class="subject delete">
    <h1>Delete User</h1>

    <form action="<?php echo url_for('/staff/users/delete.php?id=' . h(u($id))); ?>" method="post">

		<div class="attributes">
            <div class="attributes">
                <dl>
                    <dt>First Name</dt>
                    <dd><?php echo h($user['first_name']); ?></dd>
                </dl>
                <dl>
                    <dt>Last Name</dt>
                    <dd><?php echo h($user['last_name']); ?></dd>
                </dl>
                <dl>
                    <dt>User Email</dt>
                    <dd><?php echo h($user['email']); ?></dd>
                </dl>
                <dl>
                    <dt>Active Flag</dt>
                    <dd><?php echo h($user['active']); ?></dd>
                </dl>				
                <dl>
                    <dt>Role</dt>
                    <dd><?php echo h($user['role']); ?></dd>
                </dl>
            </div>
        </div>

		
		<p>Are you sure you want to delete this user?</p>
		
		
		<div id="operations">
			<input type="submit" nae="commit" value="Delete User" />
		</div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
