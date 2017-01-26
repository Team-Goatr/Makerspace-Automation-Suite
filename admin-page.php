<?php /* Template Name: CustomPageT1 */ ?>

<?php get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

			// End of the loop.
		endwhile;
		?>

	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div>

<html> <!-- JASMINE AND DANA's STUFF -->
    <head>
        <link rel="stylesheet" type="text/css" href="admin-style.css">
    </head>
    <body>
        <button class="button">Members</button>
        <button class="button">Classes</button>
        <button class="button">Access</button>
        <button class="button">Integrations</button>
        
        <h1>Here's my plugin front-end page</h1>
        <h2>You can put anything you want in this php file.</h2>
    </body>
</html>

<?php get_sidebar(); ?>
<?php get_footer(); ?>

