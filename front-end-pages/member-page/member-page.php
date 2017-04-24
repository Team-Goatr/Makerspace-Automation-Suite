<?php 

$wp_user = wp_get_current_user();

//redirect if not logged in
if ($wp_user->ID == 0) {
    wp_redirect('/login');
    exit('Redirected logged out user');
}

get_header(); 

?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php include 'member-page.html';?>
    </main>
</div>

<?php get_footer(); ?>
