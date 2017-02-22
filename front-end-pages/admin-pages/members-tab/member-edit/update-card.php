<?php

// Ensuring that only logged-in users can update card information
if (wp_validate_auth_cookie()) {
    include dirname(__DIR__).'../../../resources/StripeAPI.php';

    if (isset($_POST["customer-id"]) && isset($_POST["stripeToken"])) {
        updateStripeCustomerCard($_POST["customer-id"], $_POST["stripeToken"]);
        echo 'Successful update';
    } else {
        echo 'Invalid parameters';
    }
} else {
    die();
}