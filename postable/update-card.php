<?php

// Preventing loading direct from browser
defined( 'ABSPATH' ) or die();

include_once dirname(__DIR__).'/resources/StripeAPI.php';

// Adding the keys to the wordpress hooks
add_action('admin_post_update_card', 'prefix_admin_update_card');

function prefix_admin_update_card() {
    if (isset($_POST["customer-id"]) && isset($_POST["stripeToken"])) {
        updateStripeCustomerCard($_POST["customer-id"], $_POST["stripeToken"]);
        echo 'Successful update';
    } else {
        echo 'Invalid parameters';
    }
    
    wp_redirect(home_url('member'));
    exit();
}
