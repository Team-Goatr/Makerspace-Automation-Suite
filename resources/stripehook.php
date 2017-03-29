<?php
Stripe\Stripe::setApiKey("sk_test_49SSSUMxAPbpYSmy4Omblrgk");

$input = @file_get_contents("php://input");
$event = json_decode($input);

echo $event->id;
http_response_code(200);
?>
