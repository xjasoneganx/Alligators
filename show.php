<?php require_once('../../../private/initialize.php'); ?>

<?php
$id = isset($_GET['id']) ? $_GET['id'] : '1';
//$id = $_GET['id'] ?? '1'; // PHP > 7.0
$user = find_user_by_id($id)
?>

<?php $page_title = 'Show User'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/staff/users/index.php'); ?>">&laquo; Back to List</a>

    <div class="page show">

        User ID: <?php echo h($id); ?>

    </div>



    <div class="subject show">

        <h1>User ID: <?php echo h($user['id']); ?></h1>

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
                <dt>Role</dt>
                <dd><?php echo h($user['role']); ?></dd>
            </dl>
        </div>

    </div>



</div>



<?php include(SHARED_PATH . '/footer.php'); ?>


