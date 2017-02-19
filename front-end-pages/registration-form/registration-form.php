<?php get_header(); ?>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
		<?php
		switch($_GET['action']) {
			case 'review': include 'review.php'; break;
			case 'submit': include 'submit.php'; break;
            default: include 'registration-form.html'; break;
		}
        ?>
    </main><!-- .site-main -->
    <?php get_sidebar( 'content-bottom' ); ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
