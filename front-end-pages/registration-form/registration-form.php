<?php
    // Allowing the usernames to be checked via username-check.php file
    if ($_GET['action'] == "check") {
        include 'username-check.php';
        die();
    }

    get_header();
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <div class="col-sm-8">
		<?php
		switch($_GET['action']) {
			case 'review': include 'review.php'; break;
			case 'submit': include 'submit.php'; break;
            default: include 'registration-form.html'; break;
		}
        ?>
        </div>
    </main><!-- .site-main -->
    <?php get_sidebar( 'content-bottom' ); ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
