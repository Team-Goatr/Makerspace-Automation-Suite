<?php
error_log("Webhook event received");

#require_once __DIR__ . '/../front-end-pages/resources/StripeAPI.php';
#Stripe\Stripe::setApiKey("sk_test_49SSSUMxAPbpYSmy4Omblrgk");

$input = @file_get_contents("php://input");
$event = json_decode($input);

if ($event->type == 'invoice.payment_failed') {
    $cus = $event->data->object->customer;
    error_log("Payment failed for customer $cus");
}


http_response_code(200);
?>
