<?php /* Template Name: CustomPageT1 */ ?>

<?php include 'admin-header.html';?>

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

		// changes the html in the div based on button click
		switch($_GET['content']) {
			case 1: include 'members-tab/member-table/admin-members-table.html'; break;
			case 4: include 'integrations-tab/admin-integrations.html'; break;
            default: include 'members-tab/member-table/admin-members-table.html'; break;
		}
		
		switch($_GET['member']) {
			case 1: include 'members-tab/member-edit/admin-members-edit.html'; break;
		}

		?>

	</main><!-- .site-main -->

</div>