<?php require_once('../../private/initialize.php');

	if (!is_admin()) {redirect_to(url_for('/index.php')); }
?>


<?php include(SHARED_PATH . '/footer.php'); ?>
