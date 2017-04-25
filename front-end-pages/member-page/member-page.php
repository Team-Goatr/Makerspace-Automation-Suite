<?php
require_once dirname(__DIR__).'/../resources/GSuiteAPI.php';

get_header();

// Show error if not logged in
$wp_user = wp_get_current_user();
if ($wp_user->ID == 0 || getUser($wp_user->user_email) == NULL) {
    include 'failure.html';
    get_footer();
    exit();
}
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php include 'member-page.html';?>
    </main>
</div>

<?php get_footer(); ?>
