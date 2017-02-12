<?php
include dirname(__DIR__).'../resources/StripeAPI.php';

echo "<html><body>\n";

// Dump everything (for testing)
print_r($_POST);
echo "<br>";

// Get things submitted to the form
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$token = $_POST['stripeToken'];
$email = $_POST['stripeEmail'];
$type = $_POST['type'];
$recurring = $_POST['recurring'];

// Get plan from Stripe
$plan = retrieveStripePlan($type);
if (empty($plan)) {
    echo "Invalid subscription type.";
    die();
}

// Create a new customer
$customer = createStripeCustomer($email, $token);
echo "Customer $firstname $lastname created with ID: " . $customer->id . "<br>";
// TODO: The $customer->id needs to be stored in G Suite

if ($recurring == 'true') {
    // Subscribe the new customer as basic individual
    subscribeStripeCustomer($customer->id, $type);
    echo "Customer $email has been subscribed to " . $plan->name . "<br>";
} else {
    $charge = chargeStripeCustomer($customer->id, $plan->amount);
    echo "Customer $email has been charged for " . $plan->name . "<br>";
}

echo "</body></html>";

?>
