<?php

// Preventing loading direct from browser
defined( 'ABSPATH' ) or die();

include_once dirname(__DIR__).'/front-end-pages/resources/GSuiteAPI.php';
include_once dirname(__DIR__).'/front-end-pages/resources/StripeAPI.php';

// Adding action for non-logged-in users
add_action( 'admin_post_nopriv_register_new', 'prefix_admin_register_new' );

function prefix_admin_register_new() {
    try {
        // Get things submitted to the form
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $token = $_POST['stripeToken'];
        $email = $_POST['email'];
        $username = $_POST["username"];
        $type = $_POST['type'];
        $recurring = empty($_POST["autorenew"]) ? "" : "checked";

        // Get plan from Stripe
        $plan = retrieveStripePlan($type);

        // Create a new customer
        $customer = createStripeCustomer($email, $token);
        error_log("Customer $firstname $lastname created with ID: " . $customer->id);

        if ($recurring == 'checked') {
            // Subscribe the new customer as basic individual
            subscribeStripeCustomer($customer->id, $plan->id);
            error_log("Customer $email has been subscribed to " . $plan->name);
        } else {
            $charge = chargeStripeCustomer($customer->id, $plan->amount);
            error_log("Customer $email has been charged for " . $plan->name);
        }

        $password = "ChangeMe";
        $status = "Pending";

        $now = new DateTime();
        $now->modify("+1 month");
        $expiration = $now->format($DATE_ATOM);

        //Create Customer
        $newUser = userFactory($username, $email, $firstname, $lastname, $password, $customer->id, $plan->name, $status, $recurring=='checked', $expiration);
        createUser($newUser);

        // Success
        wp_redirect(get_site_url() . '/register?action=success');
        exit();
    
    } catch (Exception $e) {
        error_log($e->getMessage());
        
        // Failure
        wp_redirect(get_site_url() . '/register?action=failure');
        exit();
    }
}
