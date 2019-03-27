<?php require_once('../initialize.php'); ?>

<?php

$user_set = find_all_users();

?>

<?php $page_title = 'Users'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="content">
    <div class="subjects listing">
        <h1>Users</h1>

		<?php if(is_super_admin() == true) {
		    echo '<div class="actions">';
			echo '	<a class="action" href="' . url_for('/staff/users/edit_create.php?action=create') . '">Create New User</a>';
			echo '	</div>';
		}
		?>

        <table  class="table table-striped">
            <tr>
                <th>User ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>User Email</th>
                <th>Role</th>
				<th>Active</th>
                <th colspan="3">Actions</th>
            </tr>

            <?php while($user = mysqli_fetch_assoc($user_set)) { ?>
                <tr>
                    <td><?php echo h($user['id']); ?></td>
                    <td><?php echo h($user['first_name']); ?></td>
                    <td><?php echo h($user['last_name']); ?></td>
                    <td><?php echo h($user['email']); ?></td>
                    <td><?php echo h($user['role']); ?></td>
					<td><?php echo h($user['active']); ?></td>
                    <td><a class="action" href="<?php echo url_for('/staff/users/show.php?id=' . h(u($user['id']))); ?>">View</a></td>
					
					<?php if(is_super_admin() == true) {
						echo '<td><a class="action" href="' . url_for('/staff/users/edit_create.php?action=edit&id=' . h(u($user['id']))) . '">Edit</a></td>';
						echo '<td><a class="action" href="' . url_for('/staff/users/delete.php?id=' . h(u($user['id']))) . '">Delete</a></td>';
					}
					else
					{
						echo '<td></td>';
						echo '<td></td>';
					
					}
					?>

                </tr>
            <?php } ?>
        </table>

        <?php
        mysqli_free_result($user_set);
        ?>
    </div>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
