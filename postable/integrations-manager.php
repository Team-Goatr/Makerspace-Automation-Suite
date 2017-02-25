<?php

include_once dirname(__DIR__).'/../resources/GSuiteAPI.php';
include_once dirname(__DIR__).'/../resources/StripeAPI.php';

// Adding the keys to the wordpress hooks
add_action('admin_post_update_keys', 'prefix_admin_update_keys');

add_action('admin_post_test', 'prefix_admin_test');

function prefix_admin_update_keys() {
    if (isset($_POST["stripe-public"])) {
        updateStripePublic($_POST["stripe-public"]);
    }

    if (isset($_POST["stripe-private"])) {
        updateStripeSecret($_POST["stripe-private"]);
    }

    if (isset($_POST["gsuite-json"])) {
        updateGSuiteCredentials($_POST["gsuite-json"]);
    }
    
    echo '<h1>Success</h1>';

    wp_redirect(admin_url('admin.php?page=mas-plugin&content=4'));
}

function prefix_admin_test() {
    echo "Test successful";
    die('Working!');
}