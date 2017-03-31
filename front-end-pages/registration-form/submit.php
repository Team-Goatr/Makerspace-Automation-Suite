<?php

require_once dirname(__DIR__).'/resources/StripeAPI.php';
require_once dirname(__DIR__).'/resources/GSuiteAPI.php';
require_once dirname(__DIR__).'/resources/SlackAPI.php';

try {
    // Get things submitted to the form
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
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

    // Subscribe or charge the new Stripe customer
    if ($recurring == 'checked') {
        subscribeStripeCustomer($customer->id, $plan->id);
        error_log("Customer $email has been subscribed to " . $plan->name);
    } else {
        $charge = chargeStripeCustomer($customer->id, $plan->amount);
        error_log("Customer $email has been charged for " . $plan->name);
    }

    $hashedPassword = sha1($password);
    $status = "Pending";

    error_log("Hashed Password: " . $hashedPassword);

    $now = new DateTime();
    $now->modify("+1 month");
    $expiration = $now->format("Y-m-d");

    //Create Customer in G Suite
    $newUser = userFactory($username, $email, $firstname, $lastname, $hashedPassword, $customer->id, $plan->name, $status, $recurring=='checked', $expiration);
    createUser($newUser);

    // Have Slack invite the user
    sendSlackInvite($email, $firstname, $lastname);

    // Send email to admin about the new user
    // TODO: Make this admin email configurable somewhere?
    $adminemail = 'thomas@decaturmakers.org';
    $subject = 'DecaturMakers New User';
    $message = "Congratulations! A new user has registered with the Decatur Makerspace.\n\nName: $firstname $lastname\nEmail: $email\nUsername: $username";
    $headers[] = 'From: Makerspace Automation Suite <noreply@decaturmakers.org>';
    wp_mail($adminemail, $subject, $message, $headers);

    // If no errors have been thrown, the subscription is successful
    include 'success.html';
} catch (Exception $e) {
    echo $e->getMessage();
    include 'failure.html';
}

