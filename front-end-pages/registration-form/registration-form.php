<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


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
