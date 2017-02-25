<?php

// Preventing loading direct from browser
defined( 'ABSPATH' ) or die();

require dirname(__DIR__).'/resources/StripeAPI.php';
require dirname(__DIR__).'/resources/GSuiteAPI.php';


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

    // If no errors have been thrown, the subscription is successful
    echo <<<END
        <br>
        <body>
            <div class="panel panel-success">
                <div class="panel-heading">
                    Success!
                </div>
                
                <div class="panel-body">
                    <p>Congrats! Your registration has been received. Be on the lookout for an email with your next steps!</p>
                </div>
            </div>
        </body>
END;
    
    
} catch (Exception $e) {
    echo $e->getMessage();
     echo <<<END
        <br>
        <body>
            <div class="panel panel-danger">
                <div class="panel-heading">
                    Whoops!
                </div>
                
                <div class="panel-body">
                    <p>It seems that there are some issues on our end. Please try again later.</p>
                </div>
            </div>
        </body>
END;
}

