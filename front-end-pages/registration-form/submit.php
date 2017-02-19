<?php
require dirname(__DIR__).'/resources/StripeAPI.php';
require dirname(__DIR__).'/resources/GSuiteAPI.php';

// Dump everything (for testing)
print_r($_POST);
echo "<br>";

// Get things submitted to the form
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$token = $_POST['stripeToken'];
$email = $_POST['email'];
$username = $_POST["username"] . "@decaturmakers.org";
$type = $_POST['type'];
$recurring = empty($_POST["autorenew"]) ? "" : "checked";

// Get plan from Stripe
$plan = retrieveStripePlan($type);
if (empty($plan)) {
    echo "Invalid subscription type.";
    die();
}

// Create a new customer
$customer = createStripeCustomer($email, $token);
echo "Customer $firstname $lastname created with ID: " . $customer->id . "<br>";


if ($recurring == 'checked') {
    // Subscribe the new customer as basic individual
    subscribeStripeCustomer($customer->id, $plan->id);
    echo "Customer $email has been subscribed to " . $plan->name . "<br>";
} else {
    $charge = chargeStripeCustomer($customer->id, $plan->amount);
    echo "Customer $email has been charged for " . $plan->name . "<br>";
}


$password = "ChangeMe";
$status = "Pending";

$now = new DateTime();
$now.modify("+1 month");
$expiration = $now.date_format($DATE_ATOM);

//Create Customer
$newUser = userFactory($username, $email, $firstname, $lastname, $password, $stripeToken, $plan, $status, $recurring, $expiration);

createUser($newUser);

?>
