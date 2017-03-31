<?php
    error_log("Webhook event received");

    require_once __DIR__ . '/../front-end-pages/resources/StripeAPI.php';
    require_once __DIR__ . '/../front-end-pages/resources/GSuiteAPI.php';

    # Get POST json data
    $input = @file_get_contents("php://input");
    $eventjson = json_decode($input);

    # Get the event from Stripe to verify validity
    $event = getStripeEvent($eventjson->id);
    if (is_null($event)) {
        http_response_code(500);
        die();
    }

    # Note: event types defined at: https://stripe.com/docs/api#event_types
    if ($event->type == 'invoice.payment_failed') {
        $cus = $event->data->object->customer;
        error_log("Payment failed for customer $cus");
        # TODO: Send email to admin and customer? Update G Suite
    } elseif ($event->type == 'invoice.payment_succeeded') {
        # Customer ID
        $cus = $event->data->object->customer;
        # End of subscription period (UNIX Epoch time)
        $end = $event->data->object->period_end;

        # TODO: Update G suite subscription expiration date
        # TODO: Update G Suite subscription status
    }


    http_response_code(200);
?>
