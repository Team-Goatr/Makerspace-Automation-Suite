<?php
    wp_enqueue_style( 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');

    wp_enqueue_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js');
    wp_enqueue_script('bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');

    require_once dirname(__DIR__).'/resources/SlackAPI.php';
    sendSlackInvite("mrperson1289@gmail.com", "Craig", "O.");

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
