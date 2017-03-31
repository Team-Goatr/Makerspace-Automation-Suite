<?php
    error_log("Webhook event received");

    # TODO: Troubleshoot loading Stripe API
    require_once __DIR__ . '/../front-end-pages/resources/StripeAPI.php';
    #Stripe\Stripe::setApiKey("sk_test_49SSSUMxAPbpYSmy4Omblrgk");

    # Get POST json data
    $input = @file_get_contents("php://input");
    $event = json_decode($input);

    #TODO: Get the event from Stripe and verify validity
    #$eventobj = \Stripe\Event::retrieve($event->id);

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
