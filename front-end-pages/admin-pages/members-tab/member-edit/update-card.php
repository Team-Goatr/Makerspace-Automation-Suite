<?php

// Preventing loading direct from browser
defined( 'ABSPATH' ) or die();

include dirname(__DIR__).'../../../resources/StripeAPI.php';

if (isset($_POST["customer-id"]) && isset($_POST["stripeToken"])) {
    updateStripeCustomerCard($_POST["customer-id"], $_POST["stripeToken"]);
    echo 'Successful update';
} else {
    echo 'Invalid parameters';
}

// Update User in G Suite