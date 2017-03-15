<?php

require_once dirname(__DIR__).'/resources/StripeAPI.php';
require_once dirname(__DIR__).'/resources/GSuiteAPI.php';
require_once dirname(__DIR__).'/resources/SlackAPI.php';


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
	$expiration = $now->format("Y-m-d");
	
	//Create Customer
	$newUser = userFactory($username, $email, $firstname, $lastname, $password, $customer->id, $plan->name, $status, $recurring=='checked', $expiration);
	createUser($newUser);

    sendSlackInvite($email, $firstname, $lastname);

    // If no errors have been thrown, the subscription is successful
    include 'success.html';
    
    
} catch (Exception $e) {
    echo $e->getMessage();
    include 'failure.html';
}

