<?php

// Preventing loading direct from browser
defined( 'ABSPATH' ) or die();

require_once __DIR__ . '/vendor/autoload.php';


/**
 * Echos a javascript button which builds the Stripe checkout
 * $email: The customer's provided email
 * $amount: the amount in cents to show on the button
 */
function getStripeCheckout($email, $amount) {
    $stripe_pub_key = get_option('stripe-public');
    echo <<<END

    <script
        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="$stripe_pub_key"
        data-amount="$amount"
        data-email="$email"
        data-name="Decatur Makerspace"
        data-description="Membership"
        data-label="Pay with Card (secured by Stripe)"
        data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
        data-locale="auto"
        data-currency="usd"
        data-zip-code="true"
        data-allow-remember-me="false">
    </script>

END;
}

/**
 * Echos a javascript button which builds the Stripe update card button
 * $email: The customer's stored email
 */
function getStripeUpdateCard($email) {
    $stripe_pub_key = get_option('stripe-public');
    echo <<<END
    <script
        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="$stripe_pub_key"
        data-email="$email"
        data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
        data-name="Decatur Makerspace"
        data-panel-label="Update Card Details"
        data-label="Update Card Details"
        data-zip-code="true"
        data-allow-remember-me=false
        data-locale="auto">
    </script>
END;
}

/**
 * Returns a Stripe customer object created from the token generated by checkout
 */
function createStripeCustomer($email, $token) {
    $stripe_secret_key = get_option('stripe-secret');
    \Stripe\Stripe::setApiKey($stripe_secret_key);

    $customer = \Stripe\Customer::create(array(
      "email" => $email,
      "source" => $token,
    ));

    return $customer;
}

/**
 * Returns a Stripe customer object that already exists in our user base
 */
function retrieveStripeCustomer($customer_id) {
    $stripe_secret_key = get_option('stripe-secret');
    \Stripe\Stripe::setApiKey($stripe_secret_key);

    $customer = \Stripe\Customer::retrieve($customer_id);
    return $customer;
}

/**
 * Updates the stored card for a Stripe customer
 * $customer_id: The ID of the customer to update
 * $token: The token returned by Stripe checkout
 */
function updateStripeCustomerCard($customer_id, $token) {
    $stripe_secret_key = get_option('stripe-secret');
    \Stripe\Stripe::setApiKey($stripe_secret_key);

    $result;
    try {
        $cu = \Stripe\Customer::retrieve($customer_id);
        $cu->source = $token;
        $cu->save();
        $result = "Your card details have been updated!";
    } catch(\Stripe\Error\Card $e) {
        $body = $e->getJsonBody();
        $err  = $body['error'];
        $result = $err['message'];
    }
    return $result;
}

/**
 * Return the card that a Stripe customer has stored
 * $customer_id: The ID of the customer to query
 */
function getStripeCustomerCard($customer_id) {
    $stripe_secret_key = get_option('stripe-secret');
    \Stripe\Stripe::setApiKey($stripe_secret_key);

    try {
        $cu = \Stripe\Customer::retrieve($customer_id);
        return $cu->sources->data[0];
    } catch (Exception $e) {
        $body = $e->getJsonBody();
        $err  = $body['error'];
        echo $err['message'];
        return NULL;
    }
}

/**
 * Returs a Stripe plan
 */
function retrieveStripePlan($id) {
    $stripe_secret_key = get_option('stripe-secret');
    \Stripe\Stripe::setApiKey($stripe_secret_key);

    $plan = \Stripe\Plan::retrieve($id);
    return $plan;
}

/**
 * Charge a stripe customer an amount (one time)
 */
function chargeStripeCustomer($id, $amount) {
    $stripe_secret_key = get_option('stripe-secret');
    \Stripe\Stripe::setApiKey($stripe_secret_key);

    $charge = \Stripe\Charge::create(array(
      "amount" => $amount,
      "currency" => "usd",
      "customer" => $id
    ));

    return $charge;
}

/**
 * Subscribe a stripe customer to a plan (recurring)
 */
function subscribeStripeCustomer($id, $plan) {
    $stripe_secret_key = get_option('stripe-secret');
    \Stripe\Stripe::setApiKey($stripe_secret_key);

    $customer = retrieveStripeCustomer($id);
    $customer->updateSubscription(array(
        "plan" => $plan
    ));
    $customer->save();
}

/**
 * Retrieve a Stripe event
 */
function getStripeEvent($event_id) {
    $stripe_secret_key = get_option('stripe-secret');
    \Stripe\Stripe::setApiKey($stripe_secret_key);

    try {
        $event = \Stripe\Event::retrieve($event_id);
        return $event;
    } catch (Exception $e) {
        $body = $e->getJsonBody();
        $err  = $body['error'];
        echo $err['message'];
        return NULL;
    }
}

/**
 * Retrieve a Stripe subscription
 */
function getStripeSubscription($sub_id) {
    $stripe_secret_key = get_option('stripe-secret');
    \Stripe\Stripe::setApiKey($stripe_secret_key);

    try {
        $sub = \Stripe\Subscription::retrieve($sub_id);
        return $sub;
    } catch (Exception $e) {
        $body = $e->getJsonBody();
        $err  = $body['error'];
        echo $err['message'];
        return NULL;
    }
}

