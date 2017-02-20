<?php

wp_enqueue_style( 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
wp_enqueue_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js');
wp_enqueue_script('bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');

include dirname(__DIR__).'/resources/StripeAPI.php';

// Dump everything (for testing)
//print_r($_POST);
//echo "<br>";


try {
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

    // Create a new customer
    $customer = createStripeCustomer($email, $token);
    error_log("Customer $firstname $lastname created with ID: " . $customer->id);
    // TODO: The $customer->id needs to be stored in G Suite
    // TODO: The user $username needs to be created in G Suite

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
	$now.modify("+1 month");
	$expiration = $now.date_format($DATE_ATOM);
	
	//Create Customer
	$newUser = userFactory($username, $email, $firstname, $lastname, $password, $stripeToken, $plan, $status, $recurring, $expiration);
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
    echo $e->getTraceAsString();
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

