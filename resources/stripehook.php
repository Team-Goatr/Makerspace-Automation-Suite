<?php
defined( 'ABSPATH' ) or die();
function stripe_webhook_listener() {
    if(isset($_GET['webhook-listener']) && $_GET['webhook-listener'] == 'stripe') {
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
            $name = $user->getName()->getFullName();
            $username = $user->getPrimaryEmail();
            $useremail = $user->getEmails()[0]['address'];
            $sub_status = $user->getCustomSchemas()['Subscription_Management']['Subscription_Status'];

            #error_log("Payment failed for customer $cus ($useremail)");

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

                # Update G suite subscription status to 'expired'
                $fields = array(
                    "customSchemas" => array (
                        "Subscription_Management" => array(
                            "Subscription_Status" => 'expired'
                        )
                    )
                );
                updateUser($username, $fields);
                #error_log("User updated in G Suite");
            }
        } elseif ($event->type == 'invoice.payment_succeeded') {
            # Data from Stripe JSON
            $cus = $event->data->object->customer;
            $sub_id = $event->data->object->subscription;

            # User info from G Suite
            $user = getUserByStripeID($cus);
            $username = $user->getPrimaryEmail();

            # Get new end date of subscription
            $sub = getStripeSubscription($sub_id);
            $end = $sub->current_period_end;
            $dt = new DateTime("@$end");
            $date = $dt->format('Y-m-d');

            # Update G suite subscription expiration date to $end and status to 'active'
            $fields = array(
                "customSchemas" => array (
                    "Subscription_Management" => array(
                        "Subscription_Status" => 'active',
                        "Subscription_Expiration" => $date
                    )
                )
            );
            updateUser($username, $fields);
        }

        http_response_code(200);
        die();
    }
}
add_action('init', 'stripe_webhook_listener');
?>
