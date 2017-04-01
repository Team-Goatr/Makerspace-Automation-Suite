<?php
    error_log("Webhook event received");

    require_once __DIR__ . '/../front-end-pages/resources/StripeAPI.php';
    require_once __DIR__ . '/../front-end-pages/resources/GSuiteAPI.php';

    # Get POST json data
    $input = @file_get_contents("php://input");
    $eventjson = json_decode($input);

    # Get the event from Stripe to verify validity
    #$event = getStripeEvent($eventjson->id);
    ##TESTING
    $event = $eventjson;
    ##TESTING
    if (is_null($event)) {
        http_response_code(500);
        die();
    }

    ##TESTING
    #$cus = $event->data->object->customer;
    #$user = getUserByStripeID($cus);
    #error_log("User: " . $user->getName()->getFullName());
    ##TESTING

    # Note: event types defined at: https://stripe.com/docs/api#event_types
    if ($event->type == 'invoice.payment_failed') {
        # Customer ID from Stripe
        $cus = $event->data->object->customer;

        # User info from G Suite
        $user = getUserByStripeID($cus);
        var_dump($user);
        $name = $user->getName()->getFullName();
        $username = $user->getPrimaryEmail();
        $useremail = $user->getEmails()[0]['address'];
        $sub_status = $user->getCustomSchemas()['Subscription_Management']['Subscription_Status'];

        error_log("Payment failed for customer $cus ($useremail)");

        # Check user's subscription status, only do the following if subscription is active
        if ($sub_status != 'disabled' && $sub_status != 'expired') {
            # Parameters for sending email
            $adminemail = 'thomas@decaturmakers.org';
            $subject = 'DecaturMakers Failed Payment';
            $headers = 'From: Makerspace Automation Suite <noreply@decaturmakers.org>';

            # Send an email to the admin, alerting them that a payment has failed
            # TODO: Make this admin email configurable somewhere?
            $adminmessage = "A user's membership payment has failed!\nName: $name\nUsername: $username\nEmail: $useremail\nStripe Customer: $cus";
            mail($adminemail, $subject, $adminmessage, $headers);

            # Send an email to the user to alert them of their payment failure
            $usermessage = "Your latest payment to DecaturMakers has failed. Please update your payment information or contact $adminemail for additional instructions.";
            mail($useremail, $subject, $usermessage, $headers);

            # TODO: Update G suite subscription status to 'expired'
        }

    } elseif ($event->type == 'invoice.payment_succeeded') {
        # Customer ID
        $cus = $event->data->object->customer;
        # End of subscription period (UNIX Epoch time)
        $end = $event->data->object->period_end;
        # G suite user
        $user = getUserByStripeID($cus);

        # TODO: Update G suite subscription expiration date to $end

        # TODO: Update G Suite subscription status to 'active'
    }


    http_response_code(200);
?>
