<?php
require_once __DIR__ . '/../front-end-pages/resources/StripeAPI.php';

#Stripe\Stripe::setApiKey("sk_test_49SSSUMxAPbpYSmy4Omblrgk");

$input = @file_get_contents("php://input");
$event = json_decode($input);

error_log("Webhook event received");
error_log($event->id);

http_response_code(400);
?>
