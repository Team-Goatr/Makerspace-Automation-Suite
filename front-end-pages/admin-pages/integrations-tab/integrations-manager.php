<?php

include_once dirname(__DIR__).'/../resources/GSuiteAPI.php';
include_once dirname(__DIR__).'/../resources/StripeAPI.php';

// Adding the keys to the wordpress hooks
add_action('admin_post_update_keys', 'prefix_admin_update_keys');

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

    wp_redirect(admin_url('admin.php?page=mas-plugin&content=4'));
}