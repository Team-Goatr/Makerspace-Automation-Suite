<?php

// Dump everything (for testing)
print_r($_POST);

// Get things submitted to the form
$token = $_POST['stripeToken'];
$email = $_POST['stripeEmail'];

// Create a new customer
$customer = createStripeCustomer($email, $token);

// TODO: The $customer->id needs to be stored in G Suite

// Subscribe the new customer as basic individual
$charge = subscribeStripeCustomer($customer->id, "basic-ind");

?>
