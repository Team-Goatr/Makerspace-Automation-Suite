<?php

add_action( 'admin_post_add_foobar', 'prefix_admin_add_foobar' );
//this next action version allows users not logged in to submit requests

//if you want to have both logged in and not logged in users submitting, you have to add both actions!

add_action( 'admin_post_nopriv_add_foobar', 'prefix_admin_add_foobar' );


function prefix_admin_add_foobar() {
    status_header(200);
    die("Server received '{$_REQUEST['data']}' from your browser.");
    //request handlers should die() when they complete their task
}

//include_once dirname(__DIR__).'/../resources/GSuiteAPI.php';
//include_once dirname(__DIR__).'/../resources/StripeAPI.php';
//
//// Adding the keys to the wordpress hooks
//add_action('admin_post_update_keys', 'prefix_admin_update_keys');
//
//function prefix_admin_update_keys() {
//    if (isset($_POST["stripe-public"])) {
//        updateStripePublic($_POST["stripe-public"]);
//    }
//
//    if (isset($_POST["stripe-private"])) {
//        updateStripeSecret($_POST["stripe-private"]);
//    }
//
//    if (isset($_POST["gsuite-json"])) {
//        updateGSuiteCredentials($_POST["gsuite-json"]);
//    }
//    
//    echo '<h1>Success</h1>';
//
//    wp_redirect(admin_url('admin.php?page=mas-plugin&content=4'));
//}